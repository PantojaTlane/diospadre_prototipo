<section id="section-metodo-pago"><!--Este modal aparece cuando esta el atributo compra=true-->
        <div id="container-paypal" class="hideContainerPaypal">
            <h1>Elige el metodo de pago</h1>
            <div id="price"><b>El total es de: </b><span id="precioPagar">0</span></div>
            <div class="cancelado-transaccion"><i class="fa-solid fa-ban"></i><p></p></div>
            <div id="paypal-button-container"></div>
            <a href="bienvenida.php?<?=$bienvenida?>" id="btn-cancel-compra">Cancelar</a>
        </div>

        <div id="compra-realizada" class="hideCompraRealizada">
            <a href="bienvenida.php?<?=$bienvenida?>" id="closeCompraDone"><i class="fa-solid fa-xmark"></i></a>
            <div>
                <figure><img src="./img/completed.svg" alt="completed"></figure>
            </div>
            <h3>Compra Realizada</h3>
            <div id="txtCompra"><b>¡Gracias por su compra!   ¡Nos vemos pronto!</b>
            <p>El codigo de entrada ha sido enviado al correo: <span id="correoTxt"><?php echo $email ?><span></p></div>
        </div>


        <div id="capacidad-rebasada" class="hideCapacidad">
            <a href="bienvenida.php?<?=$bienvenida?>" id="closeCapacidad"><i class="fa-solid fa-xmark"></i></a>
            <div id="celda-1">
                <div>
                    <figure><img src="./img/nodisponible.svg" alt="completed"></figure>
                </div>
                <div id="txtCapacidad">
                    <b><span><i class="fa-solid fa-xmark"></i></span>¡Boletos No Disponibles! <span><i class="fa-solid fa-xmark"></i></span></b>
                    <p>La cantidad de boletos solicitada rebasa la capacidad de boletos disponibles</p>
                </div>
            </div>
            <div id="celda-2">
                <b>Revisa la cantidad solicitada de los siguientes boletos:</b>
                <table cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <td>Nombre</td>
                            <td>Cantidad disponible</td>
                        </tr>
                    </thead>
                    <tbody id="boletosFilas">
                        <!--<tr>
                            <td>Entrada General</td>
                            <td>23</td>
                        </tr>-->
                    </tbody>
                </table>
            </div>
        </div>
</section>