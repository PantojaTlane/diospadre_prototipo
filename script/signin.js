//const sectionForm =  document.querySelector('#sectionForm');
const btnSignIn = document.querySelector('#btn-sign-in');
const btnIngresar = document.querySelector('#btnIngresar');
const sectionRegistro = document.querySelector('#sectionRegistro');
//const btnRegistrarse = document.querySelector('#btn-sign-up');

const sectionTip = document.querySelector('#sectionTip');

btnSignIn.addEventListener('click',()=>{
    //sectionForm.classList.toggle('hide-section-form');
    sectionRegistro.classList.toggle('hide-section-registro');
    sectionTip.classList.toggle('hide-sectionTip');

    /*if(!sectionRegistro.classList.contains('hide-section-registro')){
        sectionRegistro.classList.add('hide-section-registro');
    }*/
});

/*btnIngresar.addEventListener('click',()=>{
    sectionForm.classList.add('hide-section-form');
    sectionTip.classList.remove('hide-sectionTip');
})*/