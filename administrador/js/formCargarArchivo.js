const nameFile = document.querySelector('#nameFile');//Es la cajita con el texto del nombre del archivo cargado o sseleccionado
const imagenInput = document.querySelector('#imagenInput');//Es el input de tipo file

imagenInput.addEventListener('change',e=>{
    nameFile.classList.remove('hideNameFile');
    let files = e.target.files;
    let name = files[0].name;
    nameFile.textContent = name;
});