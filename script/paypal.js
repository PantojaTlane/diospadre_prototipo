//Este archivo va de la mano con el archivo celandario.js
const contenedorBotonPaypal = document.querySelector('#push-paypal');


const boletosAlmacenados = document.querySelector('.items-modal-container');//Vamos a obtener el id de los boletos adquiridos
let idBoletosAdquiridos = [];
boletosAlmacenados.childNodes.forEach(boleto => {//Obtenemos los id de los boletos comprados
    //idBoletosAdquiridos.push(boleto.getAttribute('data-id'));

    let idBoleto = parseInt(boleto.getAttribute('data-id'));
    let cantidadBoletos = parseInt(boleto.childNodes[5].childNodes[0].textContent);
    let detailsBoleto = {
        idBoleto,
        cantidadBoletos
    };
    idBoletosAdquiridos.push(detailsBoleto);
});











//Calculando el precio a pagar en Paypal. Lado FRONTEND
let valor = 0;
const precioPagar =  document.querySelector('#precioPagar');//Seleccionamos el span que muestra el valor
//Buscamos la cuenta actual
let cuentasLocalStorage = JSON.parse(localStorage.getItem('cuentas'));
cuentasLocalStorage.forEach(cuenta => {
    if(cuenta.emailUser == emailUser.textContent){
        let itemsUsuario = cuenta.carrito;//Paso los items del carrito de la cuenta actual

        itemsUsuario.forEach(boleto => {
            valor += (boleto.precio * boleto.cantidadBoletos);
        });
    }
});
precioPagar.textContent = '$' + valor + 'MXN';//Esto solo lo colocamos para informar al usuario, el precio lo vamos a sacar usando AJAX, esto para garantizar que no se modifique el precio
//LADO FRONTEND





const dataBoletos = JSON.stringify(idBoletosAdquiridos);
            
fetch("https://diospadre.herokuapp.com/verificarDisponibilidad.php", {
    method: "POST",
    body: dataBoletos,
})
.then(function (response) {
    if (response.ok) {
        return response.text();
    } else {
        throw "Error en la llamada Ajax";
    }
})
.then(function (texto) {
    if(texto == "correcto"){

        const conPay = document.querySelector('#container-paypal');
        conPay.classList.remove('hideContainerPaypal');

        paypal.Buttons({
            style: {
                layout: "vertical",
                color: "gold",
                shape: "rect",
                label: "paypal",
            },
            createOrder: function(data, actions) {
                return actions.order.create({
                  purchase_units: [{
                    amount: {
                      value: valor//-------ATENCIONNNNN------VULNERABILIDAD EXPUESTA--------Estoy conciente que pase el valor que capture en el lado del frontend, este valor puede cambiar si cambio el precio de los items en el localstorage
                    }
                  }]
                });
            },
            onApprove: function(data, actions) {
                //Esta funcion captura el monto de la transaccion
                return actions.order.capture().then(function(details) {
                    //Que hacer cuando la transaccion se haya completado
                    
        
                    let cuentas = JSON.parse(localStorage.getItem('cuentas'));
                    var fecha;
                    cuentas.forEach(account => {
                        if(account.emailUser == emailUser.textContent){
                            fecha = account.fechaReservacion;
                        }
                    });
        
        
                    //Creamos un objeto que contendra todos los datos para mandarlo a procesarPagoPaypal.php
                    let datosCompra = {
                        tokenCompra: details.id,
                        valor: details.purchase_units[0].amount.value,
                        tipoMoneda: details.purchase_units[0].amount.currency_code,
                        estado: details.purchase_units[0].shipping.address.admin_area_1,
                        ciudad: details.purchase_units[0].shipping.address.admin_area_2,
                        codigoPais: details.purchase_units[0].shipping.address.country_code,
                        codigoPostal: details.purchase_units[0].shipping.address.postal_code,
                        emailUser: emailUser.textContent,
                        fechaReservada: fecha,
                        idBoletosAdquiridos: idBoletosAdquiridos
                    };
        
                    const compraData = JSON.stringify(datosCompra);
                    
                    fetch("https://diospadre.herokuapp.com/procesarPagoPaypal.php", {
                        method: "POST",
                        body: compraData,
                    })
                    .then(function (response) {
                        if (response.ok) {
                            return response.text();
                        } else {
                            throw "Error en la llamada Ajax";
                        }
                    })
                    .then(function (texto) {
        
                        let cuentas = JSON.parse(localStorage.getItem('cuentas'));
                        cuentas = cuentas.map(account => {
                            if(account.emailUser == emailUser.textContent){
                                account.numeroItems = 0;
                                account.carrito = [];
                            }
                            return account;
                        });
        
                        localStorage.setItem('cuentas',JSON.stringify(cuentas));
        
                        const containerPaypal = document.querySelector('#container-paypal');
                        const compraRealizada = document.querySelector('#compra-realizada');
                        const closeCompraDone =  document.querySelector('#closeCompraDone');
        
                        containerPaypal.classList.add('hideContainerPaypal');
                        compraRealizada.classList.remove('hideCompraRealizada');
                        
                        closeCompraDone.addEventListener('click',()=>{
                            setTimeout(()=>{
                                //containerPaypal.classList.remove('hideContainerPaypal');
                                compraRealizada.classList.add('hideCompraRealizada');
                            },1000);
                        });
                        //location.href = `${texto}`;//Redirigir a la pagina principal
                    })
                    .catch(function (err) {
                        console.log(err);
                    });
        
                    //console.log(compra);
                    //console.log('Transaction completed by ' + details.payer.name.given_name);
                });
            },
            onCancel: function (data) {
                // Cuando se cancele algo, cuando se haya cargado la ventana de PayPal pero luego lo cierro
                const canceladoTransaccion = document.querySelector('.cancelado-transaccion');
                canceladoTransaccion.classList.add('showCancelNotification');
        
                canceladoTransaccion.childNodes[1].textContent = "Has cancelado el pago en PayPal";
        
                setTimeout(()=>{
                    canceladoTransaccion.classList.remove('showCancelNotification');
                },2000);
            },
            onError: function (err) {
                //Cuando haya un error, cancelar al momento que se carga la ventana de PayPal
                const canceladoTransaccion = document.querySelector('.cancelado-transaccion');
                canceladoTransaccion.classList.add('showCancelNotification');
        
                canceladoTransaccion.childNodes[1].textContent = "Hubo un error al pagar en PayPal";
        
                setTimeout(()=>{
                    canceladoTransaccion.classList.remove('showCancelNotification');
                },2000);
            },
            onShippingChange: function(data, actions) {//Mientras este abierta la ventana de PayPal, se puede hacer acciones
                if (data.shipping_address.country_code !== 'MX') {//Decimos que la compra solos se puede realizar dentro de Mexico
                  return actions.reject();//Sirve para indicar que la direccion de compra es invalida, aqui puedo decir solo sea en MEXICO
                }
            }
        }).render("#paypal-button-container");

    }else{
        const capacidadRebasada = document.querySelector('#capacidad-rebasada');
        const btncloseCapacidad = document.querySelector('#closeCapacidad');
        const boletosFilas = document.querySelector('#boletosFilas');

        boletosFilas.innerHTML = "";

        let boletosNoDisponibles = JSON.parse(texto);
        boletosNoDisponibles.forEach(boleto => {
            let {nombre, cantidadBoletosDisponibles} = boleto;
            let fila = document.createElement('tr');
            fila.innerHTML = `
                <td>${nombre}</td>
                <td>${cantidadBoletosDisponibles}</td>
            `;
            boletosFilas.appendChild(fila);
        });

        capacidadRebasada.classList.remove('hideCapacidad');

        btncloseCapacidad.addEventListener('click',()=>{
            setTimeout(()=>{
                capacidadRebasada.classList.add('hideCapacidad');
            },1000);
        });
    }
})
.catch(function (err) {
    console.log(err);
});










/*paypal.Buttons({
    style: {
        layout: "vertical",
        color: "gold",
        shape: "rect",
        label: "paypal",
    },
    createOrder: function(data, actions) {
        return actions.order.create({
          purchase_units: [{
            amount: {
              value: valor//-------ATENCIONNNNN------VULNERABILIDAD EXPUESTA--------Estoy conciente que pase el valor que capture en el lado del frontend, este valor puede cambiar si cambio el precio de los items en el localstorage
            }
          }]
        });
    },
    onApprove: function(data, actions) {
        //Esta funcion captura el monto de la transaccion
        return actions.order.capture().then(function(details) {
            //Que hacer cuando la transaccion se haya completado
            

            let cuentas = JSON.parse(localStorage.getItem('cuentas'));
            var fecha;
            cuentas.forEach(account => {
                if(account.emailUser == emailUser.textContent){
                    fecha = account.fechaReservacion;
                }
            });


            //Creamos un objeto que contendra todos los datos para mandarlo a procesarPagoPaypal.php
            let datosCompra = {
                tokenCompra: details.id,
                valor: details.purchase_units[0].amount.value,
                tipoMoneda: details.purchase_units[0].amount.currency_code,
                estado: details.purchase_units[0].shipping.address.admin_area_1,
                ciudad: details.purchase_units[0].shipping.address.admin_area_2,
                codigoPais: details.purchase_units[0].shipping.address.country_code,
                codigoPostal: details.purchase_units[0].shipping.address.postal_code,
                emailUser: emailUser.textContent,
                fechaReservada: fecha,
                idBoletosAdquiridos: idBoletosAdquiridos
            };

            const compraData = JSON.stringify(datosCompra);
            
            fetch("http://localhost/Sistema2/procesarPagoPaypal.php", {
                method: "POST",
                body: compraData,
            })
            .then(function (response) {
                if (response.ok) {
                    return response.text();
                } else {
                    throw "Error en la llamada Ajax";
                }
            })
            .then(function (texto) {

                let cuentas = JSON.parse(localStorage.getItem('cuentas'));
                cuentas = cuentas.map(account => {
                    if(account.emailUser == emailUser.textContent){
                        account.numeroItems = 0;
                        account.carrito = [];
                    }
                    return account;
                });

                localStorage.setItem('cuentas',JSON.stringify(cuentas));

                const containerPaypal = document.querySelector('#container-paypal');
                const compraRealizada = document.querySelector('#compra-realizada');
                const closeCompraDone =  document.querySelector('#closeCompraDone');

                containerPaypal.classList.add('hideContainerPaypal');
                compraRealizada.classList.remove('hideCompraRealizada');
                
                closeCompraDone.addEventListener('click',()=>{
                    setTimeout(()=>{
                        //containerPaypal.classList.remove('hideContainerPaypal');
                        compraRealizada.classList.add('hideCompraRealizada');
                    },1000);
                });
                //location.href = `${texto}`;//Redirigir a la pagina principal
            })
            .catch(function (err) {
                console.log(err);
            });

            //console.log(compra);
            //console.log('Transaction completed by ' + details.payer.name.given_name);
        });
    },
    onCancel: function (data) {
        // Cuando se cancele algo, cuando se haya cargado la ventana de PayPal pero luego lo cierro
        const canceladoTransaccion = document.querySelector('.cancelado-transaccion');
        canceladoTransaccion.classList.add('showCancelNotification');

        canceladoTransaccion.childNodes[1].textContent = "Has cancelado el pago en PayPal";

        setTimeout(()=>{
            canceladoTransaccion.classList.remove('showCancelNotification');
        },2000);
    },
    onError: function (err) {
        //Cuando haya un error, cancelar al momento que se carga la ventana de PayPal
        const canceladoTransaccion = document.querySelector('.cancelado-transaccion');
        canceladoTransaccion.classList.add('showCancelNotification');

        canceladoTransaccion.childNodes[1].textContent = "Hubo un error al pagar en PayPal";

        setTimeout(()=>{
            canceladoTransaccion.classList.remove('showCancelNotification');
        },2000);
    },
    onShippingChange: function(data, actions) {//Mientras este abierta la ventana de PayPal, se puede hacer acciones
        if (data.shipping_address.country_code !== 'MX') {//Decimos que la compra solos se puede realizar dentro de Mexico
          return actions.reject();//Sirve para indicar que la direccion de compra es invalida, aqui puedo decir solo sea en MEXICO
        }
    }
}).render("#paypal-button-container");*/