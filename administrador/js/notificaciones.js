const notifyAdd = document.querySelector('#notifyAdd');
notifyAdd.classList.add('showBoletoAdd');

setTimeout(()=>{
    notifyAdd.classList.remove('showBoletoAdd');
},2000);