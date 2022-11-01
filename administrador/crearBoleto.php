<?php

require '../db.php';//Importamos la conexion a la base de datos
session_start();


if(isset($_POST['nombre']) && isset($_POST['costo']) && isset($_POST['cantidad']) && isset($_POST['descripcion'])){
   
    $nombre = $_POST['nombre'];//Guardar en base de datos
    $costo = intval($_POST['costo']);//Guardar en base de datos
    $cantidad = intval($_POST['cantidad']);//Guardar en base de datos
    $descripcion = $_POST['descripcion'];//Guardar en base de datos

    $name_image = $_FILES["imagen"]["name"];
    $ruta_temporal = $_FILES["imagen"]["tmp_name"];//Obteniendo la ruta donde se esta guardando temporalmente

    $ruta_a_subir = "../img/$name_image";//Guardar en base de datos
    
    move_uploaded_file($ruta_temporal,$ruta_a_subir);

    $querySaveBoleto = "INSERT INTO boleto(nombre,detalles,precio,cantidadBoletosDisponibles,numBoletosEmitidos,imgUrl,name,estado,idAdministrador) VALUES('$nombre','$descripcion',$costo,$cantidad,$cantidad,'$ruta_a_subir','$name_image','noeliminado',1)";
    $result = mysqli_query($conn,$querySaveBoleto);

    if($result){
        $_SESSION['added'] = "Boleto agregado correctamente";
        header("Location: /Sistema2/administrador/dashboardAdmin.php");
    }

}else{
    header("Location: /Sistema2/administrador/dashboardAdmin.php");
}

?>