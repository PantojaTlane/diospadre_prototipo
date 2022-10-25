const sectionModalItems = document.querySelector('.modal-items');
const carritoBtn = document.querySelector('#carritoBtn');
const btnClose2 = document.querySelector('.btn-close-2');

carritoBtn.addEventListener('click',()=>{
    sectionModalItems.classList.remove('hide-modal-items');
});

btnClose2.addEventListener('click',()=>{
    sectionModalItems.classList.add('hide-modal-items');
});

sectionModalItems.addEventListener('click',e=>{
    e.stopPropagation();
    if(e.target.classList.contains('modal-items')){
        sectionModalItems.classList.add('hide-modal-items'); 
    }
});