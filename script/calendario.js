const formDate = document.querySelector('#formDate');//Formulario
const dateInput = document.querySelector('#date');//Es el input que contiene la fecha

dateInput.addEventListener('change',e=>{
    
    let diaActual = new Date().getUTCDate();
    let mesActual = new Date().getMonth()+1;
    let anioActual = new Date().getFullYear();
    
    let fechaElegida = e.target.value;
    let anioElegido = parseInt(fechaElegida.substring(0,4));
    let mesElegido = parseInt(fechaElegida.substring(5,7));
    let diaElegido = parseInt(fechaElegida.substring(8,10));
    
    
    if(e.target.value){
        btnPagar.disabled = false;
        btnPagar.classList.remove('disable-btnpagar');
    }
    
    if((diaElegido <= diaActual && mesActual == mesElegido) || (mesElegido < mesActual || anioElegido < anioActual) || (anioElegido < anioActual)){
        btnPagar.disabled = true;
        btnPagar.classList.add('disable-btnpagar');
    }

    if(!(e.target.value)){
        btnPagar.disabled = true;
        btnPagar.classList.add('disable-btnpagar');
    }
});

formDate.addEventListener('submit',()=>{
    let cuentas = JSON.parse(localStorage.getItem('cuentas'));
    cuentas = cuentas.map(account => {
        if(account.emailUser == emailUser.textContent){
            account.fechaReservacion = dateInput.value;
        }
        return account;
    });
    localStorage.setItem('cuentas',JSON.stringify(cuentas));
});