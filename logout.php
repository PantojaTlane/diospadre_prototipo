<?php
//Codigo para cerrar sesión
session_start();
session_unset();
session_destroy();
//$google_oauth->userinfo->session_register_shutdown();
header("Location: /index.php");
?>