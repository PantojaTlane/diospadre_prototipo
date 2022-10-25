<?php if(isset($_GET['id_boleto'])): ?><!--Aqui podemos obtener ese id y poder sacar informacion de ese boleto de forma detallada-->
    
    <?php
        $idBoleto = $_GET['id_boleto'];
        $getDescription = "SELECT * FROM boleto WHERE idBoleto = $idBoleto";
        $resultBoletoDes = mysqli_query($conn,$getDescription);
        
        $descriptionBoleto = mysqli_fetch_array($resultBoletoDes);
    ?>
    
    <section class="modal-description-boleto"><!--Modal que aparece al dar click en Detalles-->
        <div class="description-boleto" data-id="<?=$descriptionBoleto['idBoleto'] ?>">
            <div id="img-description-boleto"><img src="./img/boleto.png" alt="boleto"></div>
            <div id="title-boleto"><?= $descriptionBoleto['nombre'] ?> <span>   $<b><?= $descriptionBoleto['precio'] ?></b> MXN</span></div>
            <ul id="detalles-enlistado">
                <?php
                    $detalles = $descriptionBoleto['detalles'];
                    
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
                    <li><?= $detalle ?></li>
                <?php endforeach;?>
            </ul>
            <div class="actions-boleto">
                <a href="bienvenida.php?<?=$bienvenida?>" id="cancelar-boleto-modal">Cancelar</a><!--La variable $bienvenida viene del archivo bienvenida.phpy es para redirigir a la pagina principal bienvenida.php sin pasar ningun id en la url-->
                <input type="number" name="numero_boletos" id="numero_boletos" placeholder="No. boletos" min="1" max="<?= $descriptionBoleto['cantidadBoletosDisponibles'] ?>" value="1">
                <a href="bienvenida.php?<?=$bienvenida?>" id="agregar-boleto-carro">Agregar al carrito</a>
            </div>
        </div>
    </section><!--Modal que aparece al dar click en Detalles-->
<?php endif; ?>