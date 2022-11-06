const usuarioAdmin =  document.querySelector('#usuarioAdmin');
const passAdmin = document.querySelector('#passAdmin');
const recuperar =  document.querySelector("#recuperar");

usuarioAdmin.addEventListener('input',e=>{
    if(e.target.value==""){
        console.log("vacio");
        usuarioAdmin.classList.add('rojoVacio');
    }else{
        usuarioAdmin.classList.remove('rojoVacio');
    }
});
passAdmin.addEventListener('input',e=>{
    if(e.target.value==""){
        console.log("vacio");
        passAdmin.classList.add('rojoVacio');
    }else{
        passAdmin.classList.remove('rojoVacio');
    }
});


//Consulta Ajax para recuperar ceredneciales del administtadopr
recuperar.addEventListener("click",e=>{
    e.preventDefault();
    e.stopPropagation();

    fetch("https://diospadre.herokuapp.com/administrador/recuperar.php", {
        method: "POST",
        body: {
            email: 'daypayutick@gmail.com'
        }
    })
    .then(function (response) {
        if (response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function (texto) {
        if(texto=="ready"){
            const enviadoCorreo = document.querySelector('#enviado-correo');
            enviadoCorreo.classList.add('showEnviado');
            setTimeout(() => {
                enviadoCorreo.classList.remove('showEnviado');
            }, 3000);
        }

    })
    .catch(function (err) {
        console.log(err);
    });
});