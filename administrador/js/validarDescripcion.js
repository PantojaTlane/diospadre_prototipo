const btnRegistrar = document.querySelector('#btnRegistrar');//Bton para registrar el boleto

let nombreInput = document.querySelector('#nombre');
let costoInput = document.querySelector('#costo');
let cantidadInput = document.querySelector('#cantidad');
let descripcionInput = document.querySelector('#descripcion'); 
let imagenIn = document.querySelector('#imagenInput');


nombreInput.addEventListener('input',e=>{
    verificarLlenado(descripcionInput.value,costoInput.value,cantidadInput.value,e.target.value,imagenIn.value);
});
costoInput.addEventListener('input',e=>{
    verificarLlenado(descripcionInput.value,e.target.value,cantidadInput.value,nombreInput.value,imagenIn.value);
});
cantidadInput.addEventListener('input',e=>{
    verificarLlenado(descripcionInput.value,costoInput.value,e.target.value,nombreInput.value,imagenIn.value);
});
descripcionInput.addEventListener('input',e=>{
    verificarLlenado(e.target.value,costoInput.value,cantidadInput.value,nombreInput.value,imagenIn.value);
});
imagenIn.addEventListener('change',e=>{
    verificarLlenado(descripcionInput.value,costoInput.value,cantidadInput.value,nombreInput.value,e.target.value);
    let nameFile = document.querySelector('#nameFile');
    nameFile.classList.remove('hideNameFile');
})

function verificarLlenado(p1,p2,p3,p4,p5) {
    if(p1 != "" && p2 != "" && p3 != "" && p4 != "" && p5 != ""){
        if(p1.charAt(0) == "-" && p1.charAt(p1.length-1)=="-" && p1.length>2 && (parseInt(p2)>0) && (parseInt(p3)>0)){
            btnRegistrar.classList.remove('hideBtnRegistrar');
        }else{
            btnRegistrar.classList.add('hideBtnRegistrar');
        }
    }else{
        if(!btnRegistrar.classList.contains('hideBtnRegistrar')){
            btnRegistrar.classList.add('hideBtnRegistrar');
        }
    }
}