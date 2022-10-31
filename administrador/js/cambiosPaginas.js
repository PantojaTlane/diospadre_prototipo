//OPCIONES. Al QUE LE DAMOS CLICK
const optionEntrada = document.querySelector('#optionEntrada');
const optionTransacciones = document.querySelector('#optionTransacciones');
const optionControlIngreso = document.querySelector('#optionControlIngreso');


//SECCIONES
const containerActionsDash = document.querySelector('#actions-dash');
const containerTransacciones = document.querySelector('#transacciones');
const containerControlEntrada = document.querySelector('#control-entrada');

optionEntrada.addEventListener('click',()=>{
    if(containerActionsDash.classList.contains('hide-content')){

        if(localStorage.getItem('pintado')){
            let pintados = JSON.parse(localStorage.getItem('pintado'));
            pintados = pintados.map(li => {
                if(li.id == 1){
                    li.pintar = true;
                }else{
                    li.pintar = false;
                }
                return li;
            });
            localStorage.setItem('pintado',JSON.stringify(pintados));
        }

        containerActionsDash.classList.remove('hide-content');
        containerTransacciones.classList.add('hide-content');
        containerControlEntrada.classList.add('hide-content');
    }
});

optionTransacciones.addEventListener('click',()=>{
    if(containerTransacciones.classList.contains('hide-content')){

        if(localStorage.getItem('pintado')){
            let pintados = JSON.parse(localStorage.getItem('pintado'));
            pintados = pintados.map(li => {
                if(li.id == 2){
                    li.pintar = true;
                }else{
                    li.pintar = false;
                }
                return li;
            });
            localStorage.setItem('pintado',JSON.stringify(pintados));
        }

        containerTransacciones.classList.remove('hide-content');
        containerActionsDash.classList.add('hide-content');
        containerControlEntrada.classList.add('hide-content');
    }
});

optionControlIngreso.addEventListener('click',()=>{
    if(containerControlEntrada.classList.contains('hide-content')){

        if(localStorage.getItem('pintado')){
            let pintados = JSON.parse(localStorage.getItem('pintado'));
            pintados = pintados.map(li => {
                if(li.id == 3){
                    li.pintar = true;
                }else{
                    li.pintar = false;
                }
                return li;
            });
            localStorage.setItem('pintado',JSON.stringify(pintados));
        }

        containerControlEntrada.classList.remove('hide-content');
        containerActionsDash.classList.add('hide-content');
        containerTransacciones.classList.add('hide-content');
    }
});