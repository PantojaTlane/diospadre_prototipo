<?php

require 'db.php';

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

$json = file_get_contents('php://input');
$boletosDetails = json_decode($json,true);//El json lo pasamos como arreglo

$boletosNoDisponibles = [];

$boletosTemporal = $boletosDetails;//Este iremos sacando sus elemtos cada que coincida



foreach ($boletosDetails as $boleto) {

    $idBoleto = $boleto['idBoleto'];
    $numBoletos = 0;

    

    for ($i=0; $i < count($boletosTemporal); $i++) { 
        
        if($idBoleto == $boletosTemporal[$i]['idBoleto']){
            $numBoletos += $boletosTemporal[$i]['cantidadBoletos'];
            $boletosTemporal[$i]['cantidadBoletos'] = 0;
        }

    }

    if($numBoletos>=1){
        $queryBol = "SELECT * FROM boleto WHERE idBoleto = $idBoleto";
        $resultQueryBol = mysqli_query($conn,$queryBol);
        $boletoObtenido = mysqli_fetch_array($resultQueryBol);
    
        if($numBoletos > $boletoObtenido['cantidadBoletosDisponibles']){
            //La cantidad de boletos solicitada no esta disponible
            array_push($boletosNoDisponibles,$boletoObtenido);
        }
    }
}



if(count($boletosNoDisponibles) > 0){
    echo json_encode($boletosNoDisponibles);
}else{
    echo "correcto";
}

?>