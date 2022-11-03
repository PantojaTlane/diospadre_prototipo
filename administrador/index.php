<?php

    require '../db.php';//Importamos la conexion a la base de datos

    session_start();//Iniciamos sesion

    if(isset($_SESSION["user_id"])){
        header("Location: /administrador/dashboardAdmin.php");
    }

    $message = "";
    if((!empty($_POST['usuario'])) && (!empty($_POST['password']))){
        $usuario = $_POST['usuario'];
        $contrasenia = $_POST['password'];

        $queryVerificar = "SELECT * FROM administrador WHERE usuario = '$usuario'";
        $resultQueryVerificar = mysqli_query($conn,$queryVerificar);

        if(mysqli_num_rows($resultQueryVerificar)==0){//Si no encuentra usuario en la base de datos
            $message = "Usuario inexistente";
        }else{//Si existe usuario en la base de datos
            $getUser = mysqli_fetch_array($resultQueryVerificar);
            if($contrasenia === $getUser['contrasenia']){//Si la contraseña es correcta y existe usuario
                $_SESSION["user_id"] = $getUser['idAdministrador'];
                header("Location: /administrador/dashboardAdmin.php");
            }else{//Existe usuario pero la contraseña es incorrecta
                $message = "Contraseña incorrecta";
            }   
        }
    }
    
    
?>

<?php include 'includes/headerSesion.php'; ?>
<section id="sectionSecond">
    <?php if(!empty($message)): ?>
        <div id="mensajeAdmin"><i class="fa-sharp fa-solid fa-xmark"></i><?= $message?></div>
    <?php endif; ?>
    <div id="signin-last">
        <img src=".././img/logo.png" alt="logo">
        <b>Bienvenido a la administración del sistema</b>
        <form action="index.php" method="post" id="signin-admin" name="form">
            <label for="usuario">Usuario</label>
            <input type="text" name="usuario" id="usuarioAdmin" placeholder="Nombre de usuario asignado">
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="passAdmin" placeholder="Ingresar contraseña">
            <input type="submit" value="Ingresar" id="ingresarAdmin" name="entrar">
            <p>¿Ha olvidado su usuario o contraseña?<a href="#" id="recuperar">Recuperar</a></p>
        </form>
    </div>
    <div id="enviado-correo">Se ha enviado sus credenciales a daypayutick@gmail.com</div>
</section>
<?php include 'includes/footerSesion.php'; ?>