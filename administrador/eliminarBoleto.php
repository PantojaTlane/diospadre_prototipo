<?php

require '../db.php';//Importamos la conexion a la base de datos
session_start();

if(isset($_GET['id'])){
    $idBoletoEliminar = $_GET['id'];
    $queryDelete = "DELETE FROM boleto where idBoleto = $idBoletoEliminar";
    $resultDelete = mysqli_query($conn,$queryDelete);

    if($resultDelete){
        $_SESSION['deleted'] = "Boleto eliminado correctamente";
        header("Location: /Sistema2/administrador/dashboardAdmin.php");
    }
}else{
    header("Location: /Sistema2/administrador/dashboardAdmin.php");
}

?>