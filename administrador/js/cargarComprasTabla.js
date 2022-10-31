const buscadorCodigo = document.querySelector('#buscadorCodigo');
const tbody = document.querySelector('#tbody');
const comprasEnLaTabla = document.querySelectorAll('.compraRegistrada');

let compras = [];
comprasEnLaTabla.forEach(row => {
    //compras.push(row.childNodes[1].textContent);
    compras.push(row);
});

buscadorCodigo.addEventListener('input',e=>{
    let codigo = e.target.value;
    tbody.innerHTML = "";
    if(codigo.length == 0){
        comprasEnLaTabla.forEach(tr => {
            tbody.appendChild(tr);
        });
    }else{
        compras.forEach(compra => {
            let cadena = compra.childNodes[1].textContent.toLowerCase();
            let evalua = codigo.toLowerCase();
            if(cadena.includes(evalua)){
                tbody.appendChild(compra);
            }
        });
    }
});