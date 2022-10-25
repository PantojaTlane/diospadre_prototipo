const numItems = document.querySelector('#numItes');//Muestra el numero de items adquiridos en el cuadro del carrito
const countItems = document.querySelector('#countItems');//Muestra el numero de items adquridos en el icono del carro
const emailUser = document.querySelector('#emailUser');//Es el texto del nombre del usuario

const itemsModalContainer = document.querySelector('.items-modal-container');//Contenedor que almacena los items adquiridos

const btnAdquirirBoletos = document.querySelector('#btnAdquirirBoletos');//Seleccionamos el boton de adquirir boletos

//Asignar su propio local storage a cada cuenta
if(!JSON.parse(localStorage.getItem("cuentas"))){
    let cuenta = {
        emailUser: emailUser.textContent,
        numeroItems: 0,
        carrito: []
    };
    let cuentas = [];
    cuentas.push(cuenta);
    localStorage.setItem("cuentas",JSON.stringify(cuentas));
}else{
    let cuentas = JSON.parse(localStorage.getItem('cuentas'));
    let cuenta = null;
    cuentas.forEach(account => {
        if(account.emailUser == emailUser.textContent){
            cuenta = account;
        }
    });

    if(cuenta){//Aqui comenzamos a renderizar los datos en la pagina de acuerdo a lo que este almacenado en el local storage
        numItems.textContent = `${cuenta.numeroItems}`;//Asignamos los numeros a los span
        countItems.textContent = `${cuenta.numeroItems}`;//Asignamos los numeros a los span

        itemsModalContainer.innerHTML = "";//Este es el contenedor que contendra los boletos que se van adquiriendo

        cuenta.carrito.forEach(car => {//Se van mostrando los boletos uno a uno en el contenedor de boletos
            let item = document.createElement('div');
            item.classList.add('item-modal');
            item.setAttribute('data-id',car.idBoleto);
            item.setAttribute('data-item',car.idItem);
            item.innerHTML = `
                <div id="item-img"><img src="${car.imgBoleto}" alt="image"></div>
                <b>${car.tituloBoleto}</b>
                <p><span id="cantidad-boletos">${car.cantidadBoletos}</span> boletos </p>
                <div class="actions-item-modal"><i class="fa-solid fa-trash"></i></div>
            `;
            itemsModalContainer.appendChild(item);
        });



        //AQUI YA EXISTE LOS ITEMS DENTRO DEL CARRO, POR LO QUE SELECCIONAMOS ESOS ITEMS PARA BORRARLOS
        let btnTrash = document.querySelectorAll('.fa-trash');
        btnTrash.forEach(btn => {//Seleccionamos todos los botones de los items
            btn.addEventListener('click',e=>{
                
                if(itemsModalContainer.childNodes.length<=1){//Verificar si el contenedor de items ya no tiene nada, entonces se oculta el boton de adquirir boletos
                    btnAdquirirBoletos.classList.add('hide-btn-adquirir');
                }

                let emailTxt = emailUser.textContent;//Seleccionamos el email del usuario actual
                let idIt = e.target.parentElement.parentElement.getAttribute('data-item');//Obtenemos el ID del item eliminado
                let cuentas = JSON.parse(localStorage.getItem('cuentas'));//Obtenemos los datos del local storage
                
                cuentas = cuentas.map(cuenta => {//Buscamos la cuenta en especifico
                    if(cuenta.emailUser == emailTxt){//Cuando coinicida, vamos a modifica su carrito
                        cuenta.carrito = cuenta.carrito.filter(item => item.idItem != idIt) //Quitamos el item
                        cuenta.numeroItems -= 1;//Reducimos la cantidad de items adquiridos
                        numItems.textContent = cuenta.numeroItems;
                        countItems.textContent = cuenta.numeroItems;
                    }
                    return cuenta;
                });

                localStorage.setItem('cuentas',JSON.stringify(cuentas));//Actualizamo el local storage con el item eliminado y el numero items disminuido
                e.target.parentElement.parentElement.remove();//Se elimina la estructura HTML de ese item
            });
        });

        
    }else{
        cuenta = {
            emailUser: emailUser.textContent,
            numeroItems: 0,
            carrito: []
        };
        cuentas.push(cuenta);
        localStorage.setItem('cuentas',JSON.stringify(cuentas));
    }
}


function mostrarUBorrar() {
    if(itemsModalContainer.children.length>0){//Si el contenedor que almacena los boletos del carrito tiene items, entonces, mostramos el boton de adquirir boletos
        btnAdquirirBoletos.classList.remove('hide-btn-adquirir');
    }else{
        btnAdquirirBoletos.classList.add('hide-btn-adquirir');
    }   
}

mostrarUBorrar();