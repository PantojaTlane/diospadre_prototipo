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
        header('Location: /index.php');
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
$queryAgregarCompra = "INSERT INTO compra(tokenCompra,valor,tipoMoneda,estado,ciudad,codigoPais,codigoPostal,idCliente,fechaReservada,estadoLlegada) VALUES('$tokenCompra',$valor,'$tipoMoneda','$estado','$ciudad','$codigoPais','$codigoPostal',$idCliente,'$fechaReservada','SinLlegar')";
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
        

        $queryAgregarBoletoCompra = "INSERT INTO compraboleto(idCompra,idBoleto,cantidadComprada) VALUES($idCompra,$idB,$cantidadB)";
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

        /*$trHTML .= "<tr>
                        <td style=\"padding:0.3rem;color:#4e4e4e\">$nombreReal</td>
                        <td style=\"padding:0.3rem;\">$cantidadB</td>
                    </tr>";*/
        $trHTML .= "<tr>
                        <td style=\"text-align: left; padding: 4px\">$nombreReal</td>
                        <td style=\"text-align: left; padding: 4px\">$cantidadB</td>
                    </tr>";
    }

    $subject = "Codigo de entrada al parque";

    /*$body = "
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
    ";*/

    $body = "
    <header
    style=\"
      background-color: #0852a4;
      padding: 1rem;
      color: white;
      font-weight: 900;
      font-size: 0.7rem;
    \"
  >
    Balneario Dios Padre
  </header>
  <h1 style=\"text-align: center; font-size: 0.7rem\">Gracias por su compra</h1>
  <h2
    style=\"
      text-align: center;
      font-size: 0.6rem;
      text-transform: uppercase;
      color: #ff6a00;
    \"
  >
    Proporciona al personal el siguiente código
  </h2>
  <div
    id=\"codigo\"
    style=\"
      width: 180px;
      height: 30px;
      margin: auto;
      padding: 0.2rem;
      display: flex;
      justify-content: center;
      align-items: center;
      letter-spacing: 0.1rem;
      background-color: #ff6a00;
      font-size: 0.7rem;
      border-radius: 0.3rem;
      color: white;
    \"
  >
    ".$tokenCompra."
  </div>
  <div
    class=\"tabla-container\"
    style=\"width: 100%; margin-top: 1rem; margin-bottom: 1rem\"
  >
    <table style=\"width: 90%; font-size: 0.7rem; margin: auto\">
      <thead style=\"background-color: #c1c1c1; color: white\">
        <tr id=\"filauno\">
          <td style=\"text-align: left; padding: 4px\">TIPO DE BOLETO</td>
          <td style=\"text-align: left; padding: 4px\">CANTIDAD</td>
        </tr>
      </thead>
      <tbody>
        ".$trHTML."
      </tbody>
    </table>
  </div>
  <h1 style=\"text-align: center; font-size: 0.7rem\">Fecha de llegada</h1>
  <p style=\"font-size: 0.7rem; text-align: center\">".$fechaReservada."</p>
  <div id=\"como\" style=\"background-color: #06b1ec; padding: 0.5rem\">
    <h3 style=\"color: white; font-size: 0.7rem; text-align: center\">
      Como llegar al lugar
    </h3>
    <a
      href=\"https://goo.gl/maps/TqFKdnqCBDwvHU2AA\"
      style=\"
        display: block;
        width: 70px;
        margin: auto;
        text-decoration: none;
        background-color: #8ed2ed;
        color: white;
        border: none;
        padding: 0.5rem;
        text-align: center;
        border-radius: 3px;
        font-weight: 600;
        font-size: 0.6rem;
      \"
      >Ubicación</a
    >
  </div>
  <div
    id=\"redes\"
    style=\"
      width: 100%;
      display: flex;
      flex-direction: row;
      justify-content: center;
      margin-top: 2rem;
      margin-bottom: 2rem;
    \"
  >
    <a
      href=\"https://m.facebook.com/padiospadre/\"
      style=\"text-decoration: none; margin-right: 0.5rem; font-size: 0.8rem\"
      >Facebook</a
    >
    <a
      href=\"http://www.padiospadre.com.mx/\"
      style=\"text-decoration: none; margin-right: 0.5rem; font-size: 0.8rem\"
      >Sitio</a
    >
    <a
      href=\"https://instagram.com/balneariodiospadreoficial?igshid=YmMyMTA2M2Y=\"
      style=\"text-decoration: none; margin-right: 0.5rem; font-size: 0.8rem\"
      >Instagram</a
    >
  </div>
  <h1 style=\"text-align: center; font-size: 0.7rem\">
    Visítanos para más información y diversión.
  </h1>
  <p style=\"font-size: 0.7rem; text-align: center\">
    ©2022 DAY. | Derechos reservados
  </p>
    ";

    sendMail($subject,$body,$emailUser,$nombreCliente,true);
}

echo $urlMain;//Devolvemos la url de bienvenidad.php como respuestas, y esta pueda ser leida por JavaScript y se pueda redireccionar


?>