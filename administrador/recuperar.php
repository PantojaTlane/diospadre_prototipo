<?php

require '../db.php';
require('../vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;

$json = file_get_contents('php://input');
$data = json_decode($json,true);//El json lo pasamos como arreglo

function sendMailRecovery($subject, $body, $email, $name, $html = false){//Asumimos que no se enviara HTML poniendo false

    //Se ha pegado la configuracion inicial de nuestro servidor de correo que me proporciono mailtrap al crear un inbox
    $phpmailer = new PHPMailer();
    $phpmailer->isSMTP();
    $phpmailer->Host = 'smtp.gmail.com';//Cambiamos el servidor a gmail
    $phpmailer->SMTPAuth = true;
    $phpmailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;//Agregamos esto. Gmail. Activamos la encryptacion de datos
    $phpmailer->Port = 465;//Cambiamos el puerto. Gmail. Es el que tiene seguridad al enviar correos
    $phpmailer->Username = 'tl419411@uaeh.edu.mx';//Ponemos nuestro gmail de empresa
    $phpmailer->Password = 'uhbagnxgnbcnknya';//Ponemos la contraseña que nos genero Gmail de Google

    //Añadiendo destinatario
    $phpmailer->setFrom('tl419411@uaeh.edu.mx', 'DAYEnterprise');//Quien envia el correo
    $phpmailer->addAddress($email, $name);//A quien se lo vamos a mandar

    //Definiendo el contenido de mi email
    $phpmailer->isHTML($html);//Es  para decir que se va a mandar correos con HTML, true es para verdad                                 
    $phpmailer->Subject = $subject;
    $phpmailer->Body    = $body;
    
    //Mandar el correo
    $phpmailer->send();
}


$queryGetAd = "SELECT * FROM administrador WHERE email = 'daypayutick@gmail.com'";
$resultAd = mysqli_query($conn,$queryGetAd);
$getData = mysqli_fetch_array($resultAd);

$usuario = $getData['usuario'];
$contrasenia = $getData['contrasenia'];

$body = "
    <b>Tu usuario es: $usuario</b><br>
    <b>Tu contrasenia es: $contrasenia</b>
";

sendMailRecovery('Recuperar de credenciales',$body,'daypayutick@gmail.com','Parque Acuatico Dios Padre',true);

echo "ready";
?>