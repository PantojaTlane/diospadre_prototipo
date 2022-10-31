<?php

    $queryGetBoletos = "SELECT * FROM boleto";
    $resultGetBoletos = mysqli_query($conn,$queryGetBoletos);

?>
<section class="containerBoletos">
    <div id="title-boletos"><i class="fa-sharp fa-solid fa-ticket"></i><h3>Adquiere tus boletos</h3><i class="fa-sharp fa-solid fa-ticket"></i></div>
    <div id="boletos">
        <?php while($boleto_item = mysqli_fetch_array($resultGetBoletos)): ?>
            <?php if(!$boleto_item['cantidadBoletosDisponibles'] <= 0): ?>
                <div class="boleto" data-id="<?= $boleto_item['idBoleto'] ?>">
                    <div class="overlay-boleto">
                        <span><?= $boleto_item['nombre'] ?></span>
                        <a href="bienvenida.php?id_boleto=<?= $boleto_item['idBoleto'] ?>&<?= $bienvenida ?>" id="detalles-boleto">Detalles</a><!--Aqui es para redirigir a un archivo php y capture esos datos. Cuando renderize este boleto, debo pasarlo como por ejemplo archivo.php?id para que reciba ese id y pueda pintarlo en el modal de description del boleto-->
                        <span id="costo-boleto">$<?= $boleto_item['precio'] ?> MXN</span>
                    </div>
                    <?php $boleto_item['imgUrl'][0] = " "; ?>
                    <img src="<?= $boleto_item['imgUrl'] ?>" alt="">
                </div>
            <?php endif; ?>
        <?php endwhile; ?>
    </div>
</section>