const signOutOption =  document.querySelector('#signout-option');
const btnSignOut =  document.querySelector('#btn-profile');

btnSignOut.addEventListener('click',()=>{
    signOutOption.classList.toggle('hide-menu-profile');
});
