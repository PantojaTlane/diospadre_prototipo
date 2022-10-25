<?php

require 'mail.php';
require 'db.php';

session_start();//Iniciamos sesion

if(!isset($_SESSION['login'])){//Esto es para llamar una sola vez el archivo auth.php y par redirigir al index.php en caso de que se quiere ingresar a welcome.php sin antes logearse con google
    require_once 'auth.php';
    if($google_account_info){//Si existe una cuenta ya logeado
        $_SESSION['login'] = $google_account_info['id'];
        $_SESSION['info_account'] = $google_account_info;
    }else{
        header('Location: /Sistema2/index.php');
    }
}

$json = file_get_contents('php://input');
$detallesCompra = json_decode($json,true);//El json lo pasamos como arreglo


$tokenCompra = $detallesCompra['tokenCompra'];
$valor = $detallesCompra['valor'];
$tipoMoneda = $detallesCompra['tipoMoneda'];
$estado = $detallesCompra['estado'];
$ciudad = $detallesCompra['ciudad'];
$codigoPais = $detallesCompra['codigoPais'];
$codigoPostal = $detallesCompra['codigoPostal'];
$emailUser = $detallesCompra['emailUser'];
$fechaReservada = $detallesCompra['fechaReservada'];
$idBoletosAdquiridos = $detallesCompra['idBoletosAdquiridos'];


//Obtenemos el id del cliente que esta iniciando sesion en la pagina, asi como la url de la pagina
$getUserQuery = "SELECT * FROM cliente WHERE email = \"$emailUser\"";
$resultGetUserQuery = mysqli_query($conn,$getUserQuery);
$cliente = mysqli_fetch_array($resultGetUserQuery);
$urlMain = $cliente['urlMain'];
$idCliente = $cliente['idCliente'];
$nombreCliente = $cliente['nombre'];//Obtenemos el nombre del cliente, para enviar el email


//Query para insertar un registro de compra en la base de datos
$queryAgregarCompra = "INSERT INTO compra(tokenCompra,valor,tipoMoneda,estado,ciudad,codigoPais,codigoPostal,idCliente,fechaReservada) VALUES('$tokenCompra',$valor,'$tipoMoneda','$estado','$ciudad','$codigoPais','$codigoPostal',$idCliente,'$fechaReservada')";
$resultAgregarCompra = mysqli_query($conn,$queryAgregarCompra);

if(!$resultAgregarCompra){//Si no se llevo a cabo la insercion del registro de compra....
    echo "No se pudo insertar la compra en la base de datos";
    die();
}else{//Si se llevo a cabo el resgitro de compra...asignar a cada boleto el id de compra
    $queryObtenerCompra = "SELECT * FROM compra WHERE tokenCompra = '$tokenCompra'";
    $resultObtenerCompra = mysqli_query($conn,$queryObtenerCompra);
    $compra = mysqli_fetch_array($resultObtenerCompra);
    $idCompra = $compra['idCompra'];//Se obtiene el id de la compra actual

    foreach ($idBoletosAdquiridos as $idBoleto) {//Aqui es para insertarlo en la tabla de compraBoleto y actualizar cantidad de boletos disponibles
        
        $idB = $idBoleto['idBoleto'];
        $cantidadB = $idBoleto['cantidadBoletos'];
        

        $queryAgregarBoletoCompra = "INSERT INTO compraboleto(idCompra,idBoleto) VALUES($idCompra,$idB)";
        $resultAgregarBoletoCompra = mysqli_query($conn,$queryAgregarBoletoCompra);
        if($resultAgregarBoletoCompra){
            $queryActualizarCantidadBoleto = "UPDATE boleto set cantidadBoletosDisponibles = cantidadBoletosDisponibles - $cantidadB WHERE idBoleto = $idB";
            $resultActualizarCantidadBoleto = mysqli_query($conn,$queryActualizarCantidadBoleto);
            if(!$resultActualizarCantidadBoleto){
                die();
            }
        }
    }

    $trHTML = "";

    foreach ($idBoletosAdquiridos as $idBoleto) {//Obtenemos los nombres de los boletos obtenidos y lo ponemos en un tr
        $idB = $idBoleto['idBoleto'];
        $cantidadB = $idBoleto['cantidadBoletos'];

        $querygetBol = "SELECT * FROM boleto WHERE idBoleto = $idB";
        $resultquerygetBol = mysqli_query($conn,$querygetBol);
        $getBol = mysqli_fetch_array($resultquerygetBol);
        $nombreReal = $getBol['nombre'];

        $trHTML .= "<tr>
                        <td style=\"padding:0.3rem;color:#4e4e4e\">$nombreReal</td>
                        <td style=\"padding:0.3rem;\">$cantidadB</td>
                    </tr>";
    }

    $subject = "Codigo de entrada al parque";

    $body = "
    <div id=\"entrada\" style=\"
                                background-color: #fff;
                                box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
                                color: #383838;
                                width: 95vw;
                                margin: 0.5rem auto;
                                text-align: center;
                                padding: 1rem 0.5rem;\">
        <h3 style=\"text-transform:uppercase; font-weight:900; font-size:0.8rem;line-height:1.6rem;\">Proporciona al personal el siguiente codigo: <span style=\"padding:0.2rem;background-color: #06b1ec;color:white;\" >".$tokenCompra."</span></h3>
        <table cellspacing=\"0\" cellpadding=\"0\" style=\"font-size: 0.8rem;margin:auto;width:95vw;background-color:#f8f8f8;border-radius:0.3rem;overflow:hidden;\">
                <thead>
                    <tr>
                        <td style=\"padding:0.3rem; background-color:#06b1ec; color:white;\">Nombre Boleto</td>
                        <td style=\"padding:0.3rem; background-color:#06b1ec; color:white;\">Cantidad Adquirida</td>
                    </tr>
                </thead>
                <tbody>
                    ".$trHTML."
                </tbody>
        </table>
    </div>
    ";

    sendMail($subject,$body,$emailUser,$nombreCliente,true);
}

echo $urlMain;//Devolvemos la url de bienvenidad.php como respuestas, y esta pueda ser leida por JavaScript y se pueda redireccionar


?>