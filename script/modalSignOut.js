const btnCloseModal = document.querySelector('.btn-close');
const btnCancelar = document.querySelector('#btnCancelar');
const modalContainer = document.querySelector('.modal-sign-out');
const logOutOption = document.querySelector('#logout');

const profileImg =  document.querySelector('#profile-img');

btnCloseModal.addEventListener('click',()=>{
    modalContainer.classList.add('hide-modal-sign-out');
});
btnCancelar.addEventListener('click',()=>{
    modalContainer.classList.add('hide-modal-sign-out');
});
logOutOption.addEventListener('click',()=>{
    modalContainer.classList.remove('hide-modal-sign-out');
    signOutOption.classList.add('hide-menu-profile');
    
    console.log(profileImg.firstChild.getAttribute('src'));
});
modalContainer.addEventListener('click',e=>{
    e.stopPropagation();
    if(e.target.classList.contains('modal-sign-out')){
        modalContainer.classList.add('hide-modal-sign-out'); 
    }
});