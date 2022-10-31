const notifyEdited = document.querySelector('#notifyEdited');
notifyEdited.classList.add('showBoletoAdd');

setTimeout(()=>{
    notifyEdited.classList.remove('showBoletoAdd');
},2000);