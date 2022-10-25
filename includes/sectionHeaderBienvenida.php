
<?php

    //Obtenemos el campo imgPerfil del usuario cuyo email es:
    /*$getUser = "SELECT cliente.imgPerfil FROM cliente WHERE email = '$email'";
    $resultImg = mysqli_query($conn,$getUser);
    $imgUser = mysqli_fetch_array($resultImg);
    $img = $imgUser['imgPerfil'];*/

    //Mejor solo obtenemos la primera letra del nombre del usuarioq que inicia sesion
    $inicialLetraUser = $_SESSION['info_account']['given_name'][0];

?>

<header class="header">
    <section class="slider">
        <img src="./img/img1.jpg" id="imageSlider" alt="image">
    </section>

    <section class="overlay">
        <nav class="navegacion">
            <div id="logo"></div>
            <div class="menu-options">
                <span id="carritoBtn"><i class="fa-solid fa-cart-shopping"></i><b id="countItems">0</b></span>
                <div class="data-profile">
                    <div id="profile-img"><p><?= $inicialLetraUser ?></p></div>
                    <p id="emailUser"><?= $_SESSION['info_account']['email'] ?></p>
                    <i class="fa-solid fa-caret-down" id="btn-profile"></i>
                    <ul id="signout-option" class="hide-menu-profile">
                        <li id="logout">Log Out</li>
                    </ul>
                </div>
            </div>
        </nav>

        <aside class="content">
            <h1>Parque acuático <span>"Dios Padre"</span></h1>
            <h3>¡El parque más padre!</h3>
        </aside>
    </section>
</header>