<?php

   
    require '../db.php';//Importamos la conexion a la base de datos
    session_start();//Iniciamos sesion


    $user = null;

    if(isset($_SESSION["user_id"])){
        $id = $_SESSION["user_id"];
        $query = "SELECT * FROM administrador WHERE idAdministrador = '$id'";
        $result = mysqli_query($conn,$query);

        $row = mysqli_fetch_array($result);
        $user = $row;
    }

    if($user==null){
        header("Location: /Sistema2/administrador/");
    }
    //$_SESSION["started"] = "true";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./css/dashboard.css">
    <link rel="stylesheet" href=".././css/index.css">
    <link rel="stylesheet" href="./css/compraDetalles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js" type="text/javascript"></script>   
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
</head>
<body>

    <?php if(isset($_GET['id'])): ?>
        <?php
            $idBol = $_GET['id'];
            $queryGetBol = "SELECT * FROM boleto WHERE idBoleto = $idBol";
            $resultQueryBol = mysqli_query($conn,$queryGetBol);
            
            $infoBol = mysqli_fetch_array($resultQueryBol);
        ?>
        <section id="section-crear">
            <form action="editarBoleto.php?id=<?= $infoBol["idBoleto"] ?>" method="post" enctype="multipart/form-data" id="formCrearBoleto">
                <div id="encabezado"><h1>Registro de entradas</h1></div>
                <a href="/Sistema2/administrador/dashboardAdmin.php" id="closeCrear">x</a>
                <section id="data-boleto">
                    <div id="datos-generales">
                        <h1>Datos Generales</h1>
                        <label for="nombre">Nombre:</label>
                        <input type="text" value="<?= $infoBol["nombre"] ?>" name="nombre" placeholder="Nombre del boleto" id="nombre" required>
                        <label for="costo">Costo:</label>
                        <input type="number" value="<?= $infoBol["precio"] ?>" placeholder="$00.00 MXN" id="costo" name="costo" min="1" required>
                        <label for="cantidad">Cantidad:</label>
                        <input type="number" value="<?= $infoBol["cantidadBoletosDisponibles"] ?>" name="cantidad" id="cantidad" min="1" placeholder="Numero de boletos a emitir" required>
                        <label for="descripcion">Descripción:</label>
                        <input type="text" name="descripcion" value="<?= $infoBol["detalles"] ?>" id="descripcion" placeholder="-descripcion1-descripcion2-" required>
                    </div>
                    <div id="imagen">
                        <h1>Imagen</h1>
                        <b id="nameFile" class="hideNameFile">Boleto general.jpgs</b>
                        <div id="containerFile"><input type="file" name="imagen" id="imagenInput" accept="image/png,.jpeg,.jpg" required></div>
                        <input type="submit" value="Registrar" id="btnRegistrar" class="hideBtnRegistrar">
                    </div>
                </section>
            </form>
        </section>
    <?php endif; ?>

    <section id="section-crear" class="hideSectionCrear">
        <form action="crearBoleto.php" method="post" enctype="multipart/form-data" id="formCrearBoleto">
            <div id="encabezado"><h1>Registro de entradas</h1></div>
            <span id="closeCrear">x</span>
            <section id="data-boleto">
                <div id="datos-generales">
                    <h1>Datos Generales</h1>
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" placeholder="Nombre del boleto" id="nombre" required>
                    <label for="costo">Costo:</label>
                    <input type="number" placeholder="$00.00 MXN" id="costo" name="costo" min="1" required>
                    <label for="cantidad">Cantidad:</label>
                    <input type="number" name="cantidad" id="cantidad" min="1" placeholder="Numero de boletos a emitir" required>
                    <label for="descripcion">Descripción:</label>
                    <input type="text" name="descripcion" id="descripcion" placeholder="-descripcion1-descripcion2-" required>
                </div>
                <div id="imagen">
                    <h1>Imagen</h1>
                    <b id="nameFile" class="hideNameFile">Boleto general.jpgs</b>
                    <div id="containerFile"><input type="file" name="imagen" id="imagenInput" accept="image/png,.jpeg,.jpg" required></div>
                    <input type="submit" value="Registrar" id="btnRegistrar" class="hideBtnRegistrar">
                </div>
            </section>
        </form>
    </section>
    <div id="logoAdmi">
        <div>Administrador</div>
        <ul>
            <li id="optionEntrada" ><i class="fa-solid fa-ticket"></i>Entradas</li>
            <li id="optionTransacciones" ><i class="fa-solid fa-money-bill"></i>Transacciones</li>
            <li id="optionControlIngreso" ><i class="fa-solid fa-door-open"></i>Control de ingreso</li>
        </ul>
    </div>
    <header id="header">
        <div id="user"><div><?= $user['usuario'] ?><span><i class="fa-solid fa-user"></i></span><a href="logoutAdmin.php"><i class="fa-solid fa-right-from-bracket"></i></a></div></div>
    </header>
    <section id="actions-dash" class="main-content hide-content">
        <div id="crear-section">
            <h1>Entradas</h1>
            <button id="crearEntradaBtn">Crear entrada</button>
            <a href="/Sistema2/administrador/dashboardAdmin.php" id="updateEstado"><i class="fa-solid fa-rotate"></i></a>
        </div>
        <section id="boletos-creados">

            <!--Notificaciones-->
            <?php if(!empty($_SESSION['added'])): ?>
                <div id="notifyAdd">Boleto creado exitosamente</div>
            <?php endif;?>
            <?php if(!empty($_SESSION['edited'])): ?>
                <div id="notifyEdited">Boleto editado exitosamente</div>
            <?php endif;?>
            <?php if(!empty($_SESSION['deleted'])): ?>
                <div id="notifyDeleted">Boleto eliminado exitosamente</div>
            <?php endif;?>
            

            <?php
                $getBoletosAdmin = "SELECT * FROM boleto";
                $resultGetBoletosAdmin = mysqli_query($conn,$getBoletosAdmin);
            ?>
            <?php if(mysqli_num_rows($resultGetBoletosAdmin)==0): ?>
                <div id="sinCrear">
                    <p>No se han creado boletos</p>
                </div>
            <?php endif; ?>
        
            <?php while($boleto = mysqli_fetch_array($resultGetBoletosAdmin)): ?>
                <div class="boleto-creado">
                    <div id="detailsBoleto">
                        <h1><?= $boleto['nombre'] ?></h1>
                        <p><?= $boleto['detalles'] ?></p>
                    </div>
                    <img src="<?= $boleto['imgUrl'] ?>" alt="boleto">
                    <div id="actionsBoleto">
                        <a href="eliminarBoleto.php?id=<?= $boleto['idBoleto'] ?>"><i class="fa-solid fa-trash"></i></a>
                        <a href="/Sistema2/administrador/dashboardAdmin.php?id=<?= $boleto['idBoleto'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                    </div>
                    <?php
                       $numVentas =  $boleto['cantidadBoletosDisponibles'];
                       $emitidos = $boleto['numBoletosEmitidos'];

                       $porcentaje = (($numVentas * 100)/$emitidos);
                    ?>
                    <?php if($porcentaje >= 50): ?>
                        <div id="estadoBoleto" class="porvender"><span><b>No. Boletos Emitidos:</b><?= $boleto['numBoletosEmitidos'] ?></span><span><b>Restantes:</b><?= $boleto['cantidadBoletosDisponibles'] ?></span></div>
                    <?php  endif;?>
                    <?php if(($porcentaje < 50) && ($porcentaje != 0)): ?>
                        <div id="estadoBoleto" class="poragotarse"><span><b>No. Boletos Emitidos:</b><?= $boleto['numBoletosEmitidos'] ?></span><span><b>Restantes:</b><?= $boleto['cantidadBoletosDisponibles'] ?></span></div>
                    <?php  endif;?>
                    <?php if($porcentaje == 0): ?>
                        <div id="estadoBoleto" class="vendidos"><span><b>No. Boletos Emitidos:</b><?= $boleto['numBoletosEmitidos'] ?></span><span><b>Restantes:</b><?= $boleto['cantidadBoletosDisponibles'] ?></span></div>
                    <?php  endif;?>
                </div>
            <?php endwhile; ?>

        </section>
    </section>














    <!--SECTION DE CONTROL DE INGRESO. INICIO-->
    <?php if(isset($_GET['idCompra'])): ?><!--Contenedor para mostrar los detalles de una compra-->
        <?php
            $idCompra = $_GET['idCompra'];
            $queryGetDetallesCompra = "SELECT compraboleto.cantidadComprada, boleto.nombre,boleto.detalles, compra.estadoLlegada FROM boleto INNER JOIN compraboleto ON boleto.idBoleto = compraboleto.idBoleto INNER JOIN compra ON compraboleto.idCompra = compra.idCompra WHERE compraboleto.idCompra = $idCompra";
            $resultQueryDetallesCompra = mysqli_query($conn,$queryGetDetallesCompra);  
        ?>
        <div id="container-detalles-compra">
            <div id="modal-detalles-compra">
                <b>Detalles de compra</b>
                <?php
                    $queryGetToken = "SELECT tokenCompra FROM compra WHERE idCompra = $idCompra";
                    $resultQueryGetToken = mysqli_query($conn,$queryGetToken);
                    $tokenCompra = mysqli_fetch_array($resultQueryGetToken);
                ?>
                <p id="tokenTxt"><?= $tokenCompra['tokenCompra'] ?></p>
                <ul>
                    <?php while($detalle = mysqli_fetch_array($resultQueryDetallesCompra)): ?>
                        <li class="option-slice"><?= $detalle['nombre'] ?> <span><?= $detalle['cantidadComprada'] ?></span>
                            <div>
                                <?php
                                    $detalles = $detalle['detalles'];
                                    
                                    $detallesOrdenados = [];
                                    $itemList = "";
                                    for($i = 1; $i < strlen($detalles); $i++){
                                        if($detalles[$i]=="-"){
                                            array_push($detallesOrdenados,$itemList);
                                            $itemList = "";
                                            continue;
                                        }
                                        $itemList .= $detalles[$i];
                                    }
                                ?>
                                <?php foreach($detallesOrdenados as $detalle): ?><!--Aqui me quede, al recorrer cada item de detalle de la base de datos-->
                                    <p><?= $detalle ?></p>
                                <?php endforeach;?>
                            </div>
                        </li>
                    <?php endwhile; ?>
                </ul>
                <div id="botones-details-compra">
                    <?php
                        $queryGetCompra = "SELECT estadoLlegada FROM compra WHERE idCompra = $idCompra";
                        $resultGetEstado = mysqli_query($conn,$queryGetCompra);
                        $estadoArrival = mysqli_fetch_array($resultGetEstado); 
                    ?>
                        <a href="/Sistema2/administrador/dashboardAdmin.php" id="cancelarVer">Cancelar</a>
                    <?php if($estadoArrival['estadoLlegada'] == "SinLlegar"): ?>
                        <a href="/Sistema2/administrador/actualizarEstadoCompra.php?idCompra=<?= $_GET['idCompra'] ?>" id="ingresadoCliente">El cliente ha ingresado</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?><!--Contenedor para mostrar los detalles de una compra-->


    <section id="control-entrada" class="main-content hide-content">
        <div id="buscar-section">
            <h1>Control de ingreso</h1>
            <div id="container-buscador"><i class="fa-solid fa-qrcode"></i><input type="search" name="buscarCompra" id="buscadorCodigo" placeholder="Buscar codigo de boleto"></div>
            <a href="/Sistema2/administrador/dashboardAdmin.php" id="updateEstadoControl"><i class="fa-solid fa-rotate"></i></a>
        </div>
        <?php
            $queryGetCompras = "SELECT * FROM compra";
            $resultGetCompras = mysqli_query($conn,$queryGetCompras);
        ?>
        <div id="container-tabla">
            <?php if(mysqli_num_rows($resultGetCompras) == 0): ?>
                <p id="noHayComprasTxt" class="hideTxtCompras">No se han realizado compras en el sitio</p>
            <?php endif; ?>
            <?php if(!mysqli_num_rows($resultGetCompras) == 0): ?>
                <table id="table-compras" cellspacing="0" cellpadding="0" class="hideTable">
                    <thead>
                        <tr>
                            <td>Código Boleto</td>
                            <td>Fecha</td>
                            <td>Correo</td>
                            <td>Costo</td>
                            <td>Estado</td>
                            <td>Acciones</td>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php while($compra = mysqli_fetch_array($resultGetCompras)): ?>
                            <?php
                                //Seleccionar el email
                                $idCliente = $compra['idCliente'];
                                $getEmailJoin = "SELECT email FROM cliente INNER JOIN compra ON cliente.idCliente = compra.idCliente WHERE cliente.idCliente = $idCliente";
                                $resultEmail = mysqli_query($conn,$getEmailJoin);
                                $email = mysqli_fetch_array($resultEmail);
                            ?>
                            <tr class="compraRegistrada">
                                <td><?= $compra['tokenCompra'] ?></td>
                                <td><?= $compra['fechaReservada'] ?></td>
                                <td><?= $email['email'] ?></td>
                                <td>$<?= $compra['valor'] ?><?= $compra['tipoMoneda'] ?></td>
                                <?php if($compra['estadoLlegada'] == "SinLlegar"): ?>
                                    <td><div id="estadoDiv" class="sinLlegar"></div></td>
                                <?php else: ?>
                                    <td><div id="estadoDiv" class="llego"></div></td>
                                <?php endif; ?>
                                <td><a href="/Sistema2/administrador/dashboardAdmin.php?idCompra=<?= $compra['idCompra'] ?>"><i class="fa-solid fa-eye"></i></a></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </section>
    <!--SECTION DE CONTROL DE INGRESO. FIN-->











    <!--SECTION TRANSACCIONES. INICIO-->
    <section id="transacciones" class="main-content hide-content">
        <div id="buscar-section-trans">
            <h1>Transacciones</h1>
            <div id="container-buscador-trans"><i class="fa-solid fa-qrcode"></i><input type="search" name="buscarCompra" id="buscadorCodigoTrans" placeholder="Buscar email"></div>
            <a href="/Sistema2/administrador/dashboardAdmin.php" id="updateEstadoTrans"><i class="fa-solid fa-rotate"></i></a>
        </div>
        <?php
            $queryGetCompras = "SELECT * FROM compra";
            $resultGetCompras = mysqli_query($conn,$queryGetCompras);
        ?>
        <div id="container-tabla-trans">
            <?php if(mysqli_num_rows($resultGetCompras) == 0): ?>
                <p id="noHayComprasTxt" class="hideTxtCompras">No se han realizado compras en el sitio</p>
            <?php endif; ?>
            <?php if(!mysqli_num_rows($resultGetCompras) == 0): ?>
                <table id="table-compras-trans" cellspacing="0" cellpadding="0" class="hideTable">
                    <thead>
                        <tr>
                            <td>Id Compra</td>
                            <td>Cliente</td>
                            <td>CodigoPais</td>
                            <td>CodigoPostal</td>
                            <td>Estado</td>
                            <td>Ciudad</td>
                            <td>Moneda</td>
                            <td>Valor</td>
                        </tr>
                    </thead>
                    <tbody id="tbodyTrans">
                        <?php while($compra = mysqli_fetch_array($resultGetCompras)): ?>
                            <?php
                                //Seleccionar el email
                                $idCliente = $compra['idCliente'];
                                $getEmailJoin = "SELECT email,nombre FROM cliente INNER JOIN compra ON cliente.idCliente = compra.idCliente WHERE cliente.idCliente = $idCliente";
                                $resultEmail = mysqli_query($conn,$getEmailJoin);
                                $email = mysqli_fetch_array($resultEmail);
                            ?>
                            <tr class="transaccionRegistrada">
                                <td><?= $compra['idCompra'] ?></td>
                                <td><?= $email['email'] ?></td>
                                <td><?= $compra['codigoPais'] ?></td>
                                <td><?= $compra['codigoPostal'] ?></td>
                                <td><?= $compra['estado'] ?></td>
                                <td><?= $compra['ciudad'] ?></td>
                                <td><?= $compra['tipoMoneda'] ?></td>
                                <td>$<?= $compra['valor'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </section>
    <!--SECTION TRANSACCIONES. FIN-->





    <script src="https://kit.fontawesome.com/eee10799b3.js" crossorigin="anonymous"></script>
    <script src="js/dashboard.js"></script>
    <script src="js/formCargarArchivo.js"></script>
    <script src="js/validarDescripcion.js"></script>
    
    <?php if(!empty($_SESSION['added'])): ?>
        <script src="js/notificaciones.js"></script>
    <?php $_SESSION['added'] = ""; endif;?>
    
    <?php if(!empty($_SESSION['edited'])): ?>
        <script src="js/notifyEdited.js"></script>
    <?php  $_SESSION['edited'] = ""; endif; ?>

    <?php if(!empty($_SESSION['deleted'])): ?>
        <script src="js/notifyDeleted.js"></script>
    <?php $_SESSION['deleted'] = ""; endif; ?>

    <?php if(!mysqli_num_rows($resultGetCompras) == 0): ?>
        <script src="js/cargarComprasTabla.js"></script>
        <script src="js/cargarTransacciones.js"></script>
    <?php endif; ?>

    <script src="js/cambiosPaginas.js"></script>
</body>
</html>