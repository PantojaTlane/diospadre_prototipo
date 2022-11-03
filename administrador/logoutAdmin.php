<?php
//Codigo para cerrar sesión
session_start();
session_unset();
session_destroy();
header("Location: /administrador/index.php");
?>