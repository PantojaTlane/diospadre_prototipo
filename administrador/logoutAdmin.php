<?php
//Codigo para cerrar sesión
session_start();
session_unset();
session_destroy();
header("Location: /Sistema2/administrador/index.php");
?>