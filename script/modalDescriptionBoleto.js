const numeroBoletos =  document.querySelector('#numero_boletos');//Campo que dice el numero de boletos a comprar
const agregarBoletoCarro = document.querySelector('#agregar-boleto-carro');//Boton para agregar boleto al carro


agregarBoletoCarro.addEventListener('click',e=>{//Cuando de click en el boton de agregar al carrito del modal de descripcion de boleto
    
    let cuentas = JSON.parse(localStorage.getItem('cuentas'));
    cuentas = cuentas.map(account => {
        if(account.emailUser == emailUser.textContent){
            account.numeroItems += 1;//Aumentamos el numero de items

            //Capturando los datos del elemento al que se le dio el click
            let idItem = Date.now();
            let idBoleto = e.target.parentElement.parentElement.getAttribute('data-id');
            let tituloBoleto = e.target.parentElement.parentElement.children[1].textContent;
            let cantidadBoletos = parseFloat(e.target.parentElement.children[1].value);
            let imgBoleto = e.target.parentElement.parentElement.children[0].children[0].src;
            let precio = parseFloat(e.target.parentElement.parentElement.children[1].children[0].children[0].textContent);

            let boletoAdquirido = {
                idItem,
                idBoleto,
                tituloBoleto,
                cantidadBoletos,
                precio,
                imgBoleto
            };

            account.carrito.push(boletoAdquirido);
        }
        return account;
    });
    localStorage.setItem('cuentas',JSON.stringify(cuentas));
    
});