<?php

require("vendor/autoload.php");

use PHPMailer\PHPMailer\PHPMailer;

function sendMail($subject, $body, $email, $name, $html = false){//Asumimos que no se enviara HTML poniendo false

    //Se ha pegado la configuracion inicial de nuestro servidor de correo que me proporciono mailtrap al crear un inbox
    $phpmailer = new PHPMailer();
    $phpmailer->isSMTP();
    $phpmailer->Host = 'smtp.gmail.com';//Cambiamos el servidor a gmail
    $phpmailer->SMTPAuth = true;
    $phpmailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;//Agregamos esto. Gmail. Activamos la encryptacion de datos
    $phpmailer->Port = 465;//Cambiamos el puerto. Gmail. Es el que tiene seguridad al enviar correos
    $phpmailer->Username = 'daypayutick@gmail.com';//Ponemos nuestro gmail de empresa
    $phpmailer->Password = 'reosesvxnpjznakv';//Ponemos la contraseña que nos genero Gmail de Google

    //Añadiendo destinatario
    $phpmailer->setFrom('daypayutick@gmail.com', 'Parque Acuatico Dios Padre');//Quien envia el correo
    $phpmailer->addAddress($email, $name);//A quien se lo vamos a mandar

    //Definiendo el contenido de mi email
    $phpmailer->isHTML($html);//Es  para decir que se va a mandar correos con HTML, true es para verdad                                 
    $phpmailer->Subject = $subject;
    $phpmailer->Body    = $body;
    
    //Mandar el correo
    $phpmailer->send();
}

?>