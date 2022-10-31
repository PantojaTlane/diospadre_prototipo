const sectionCrear = document.querySelector('#section-crear');

const crearEntradaBtn = document.querySelector('#crearEntradaBtn');
crearEntradaBtn.addEventListener('click',()=>{
    sectionCrear.classList.remove('hideSectionCrear');
    let imagenIn = document.querySelector('#imagenInput');
    imagenIn.value = "";
});

const btnCloseCrear = document.querySelector('#closeCrear');
btnCloseCrear.addEventListener('click',()=>{
    let nameFile = document.querySelector('#nameFile');
    nameFile.classList.add('hideNameFile');
    sectionCrear.classList.add('hideSectionCrear');

    let imagenIn = document.querySelector('#imagenInput');
    imagenIn.value = "";

    const btnRegistrar = document.querySelector('#btnRegistrar');
    btnRegistrar.classList.add('hideBtnRegistrar');

    let nombreInput = document.querySelector('#nombre').value = "";
    let costoInput = document.querySelector('#costo').value = "";
    let cantidadInput = document.querySelector('#cantidad').value = "";
    let descripcionInput = document.querySelector('#descripcion').value = ""; 
});

if(!localStorage.getItem('pintado')){
    let pintados = [
        {id:1,pintar:false},
        {id:2,pintar:false},
        {id:3,pintar:false}
    ];
    localStorage.setItem('pintado',JSON.stringify(pintados));
}else{
    
    let quienPintar = JSON.parse(localStorage.getItem('pintado'));
    const containerActionsDash = document.querySelector('#actions-dash');   
    const containerTransacciones = document.querySelector('#transacciones');
    const containerControlEntrada = document.querySelector('#control-entrada');

    quienPintar.forEach(li => {
        if(li.pintar){
            if(li.id==1){
                containerActionsDash.classList.remove('hide-content');
            }
            if(li.id==2){
                containerTransacciones.classList.remove('hide-content');   
            }
            if(li.id==3){
                containerControlEntrada.classList.remove('hide-content');
            }
        }
    });
}