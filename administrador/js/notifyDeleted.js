const notifyDeleted = document.querySelector('#notifyDeleted');
notifyDeleted.classList.add('showBoletoAdd');

setTimeout(()=>{
    notifyDeleted.classList.remove('showBoletoAdd');
},2000);