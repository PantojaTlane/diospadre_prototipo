<script src="https://kit.fontawesome.com/eee10799b3.js" crossorigin="anonymous"></script>
<script src="./script/incializarLocalStorage.js"></script>
<script src="./script/slider.js"></script>
<script src="./script/nav.js"></script>
<script src="./script/modalSignOut.js"></script>
<script src="./script/modalItems.js"></script>
<?php if(isset($_GET['id_boleto'])): ?>
    <script src="./script/modalDescriptionBoleto.js"></script>
<?php endif; ?>
<?php if(isset($_GET['date'])):?>
    <script src="./script/calendario.js"></script>
<?php endif;?>
<?php if(isset($_GET['compra'])): ?><!--Si existe este dato, entonces si renderizamos los scripts de payapal-->
    <script src="https://www.paypal.com/sdk/js?client-id=AQVCQaTl9ZHMUt5q1SCKr_9hbo9IG7t641gf6pSvfDcOXd5oz_InW6lD_wBMNbkChziQsj6afWgG2F2C&currency=MXN&locale=es_MX&components=buttons"></script>
    <script src="./script/paypal.js"></script>
<?php endif; ?>
</body>
</html>