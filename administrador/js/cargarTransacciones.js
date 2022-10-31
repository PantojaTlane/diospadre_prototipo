const buscadorCodigoTrans = document.querySelector('#buscadorCodigoTrans');
const tbodyTrans = document.querySelector('#tbodyTrans');
const transEnLaTabla = document.querySelectorAll('.transaccionRegistrada');

let comprasTrans = [];
transEnLaTabla.forEach(row => {
    //comprasTrans.push(row.childNodes[1].textContent);
    comprasTrans.push(row);
});

buscadorCodigoTrans.addEventListener('input',e=>{
    let codigo = e.target.value;
    tbodyTrans.innerHTML = "";
    if(codigo.length == 0){
        transEnLaTabla.forEach(tr => {
            tbodyTrans.appendChild(tr);
        });
    }else{
        comprasTrans.forEach(compra => {
            let cadena = compra.childNodes[3].textContent.toLowerCase();
            let evalua = codigo.toLowerCase();
            if(cadena.includes(evalua)){
                tbodyTrans.appendChild(compra);
            }
        });
    }
});