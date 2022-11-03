<?php

//Una vez renderizamos la pestaña de bienvenida, entonces

require_once 'vendor/autoload.php';

require 'db.php';//Importamos la conexion a la base de datos

session_start();//Iniciamos sesion

if(!isset($_SESSION['login'])){//Esto es para llamar una sola vez el archivo auth.php y par redirigir al index.php en caso de que se quiere ingresar a welcome.php sin antes logearse con google
    require_once 'auth.php';
    if($google_account_info){//Si existe una cuenta ya logeado
        $_SESSION['login'] = $google_account_info['id'];
        $_SESSION['info_account'] = $google_account_info;
    }else{
        header('Location: /index.php');
    }
}






//Una vez se ha iniciado sesion, armamos el url para hacer el redireccionamiento en el index.php
$_SESSION['code'] = $_GET['code'];
$_SESSION['scope'] = $_GET['scope'];
$_SESSION['authuser'] = $_GET['authuser'];
if(isset($_GET['hd'])){
    $_SESSION['hd'] = $_GET['hd'];
}
$_SESSION['prompt'] = $_GET['prompt'];



//Esto es para poner en los boletos cuando queremos redirigir al utilizar el atributo href SE PUSO A LAS 4
if(isset($_SESSION['hd'])){
    $hdd = "&hd=".$_SESSION['hd'];
}else{
    $hdd = "";
}
$bienvenida = "code=".$_SESSION['code']."&scope=".$_SESSION['scope']."&authuser=".$_SESSION['authuser'].$hdd."&prompt=".$_SESSION['prompt'];
//SE PUSO A LAS 4


//Agregando el cliente en la base de datos, pero hay que hacer unas validaciones
$email = $_SESSION['info_account']['email'];//Seleccionamos el email
$query = "SELECT * FROM cliente WHERE email = '$email'";//Hacemos un query
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result)==0){//Si no hay usuario en la base de datos, aseguramos que solo se agrege una vez a la base de datos
    $nombre = $_SESSION['info_account']['given_name'];
    $imgPerfil = $_SESSION['info_account']['picture'];
    $urlMain = "bienvenida.php?".$bienvenida;
    $idAdministrador = 1;
    $addUsuario = "INSERT INTO cliente(nombre,email,imgPerfil,urlMain,idAdministrador) VALUES('$nombre','$email','$imgPerfil','$urlMain',$idAdministrador)";
    $resultAddUser = mysqli_query($conn,$addUsuario);

}
//Agregando el cliente en la base de datos, pero hay que hacer unas validaciones

?>

<?php include './includes/header.php'; ?>
<?php include './includes/modalSignOut.php'; ?>
<?php include './includes/modalItems.php'; ?>
<?php include './includes/sectionHeaderBienvenida.php'; ?>
<?php include './includes/sectionBoletos.php'; ?>

<?php include './includes/modalDescriptionBoleto.php'; ?>

<?php if(isset($_GET['date'])): ?>
    <?php include './includes/calendario.php'; ?>
<?php endif; ?>

<!--Aqui mostramos el modal para realizar el pago con PayPal o con tarjeta de credito-->
<?php if(isset($_GET['compra'])): ?>
    <?php include './includes/procesoCompra.php'; ?>    
<?php endif; ?>

<?php include './includes/footerBienvenida.php'; ?>