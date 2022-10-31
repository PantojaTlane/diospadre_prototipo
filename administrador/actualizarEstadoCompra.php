<?php

require '../db.php';

if(isset($_GET['idCompra'])){
    $idCompra = $_GET['idCompra'];

    $queryActualizarEstado = "UPDATE compra set estadoLlegada = 'Llego' WHERE idCompra = $idCompra";
    $resultQueryActualizar = mysqli_query($conn,$queryActualizarEstado);

    if($resultQueryActualizar){
        header("Location: /Sistema2/administrador/dashboardAdmin.php");
    }
}else{
    header("Location: /Sistema2/administrador/dashboardAdmin.php");
}

?>