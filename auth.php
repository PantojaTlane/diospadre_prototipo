<?php

    require_once 'config.php';

    //Si en la URL hay codigo, entonces obtenemos los datos de la sesion iniciada
    if(isset($_GET['code'])){
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($token['access_token']);

        //Obtener informacion de perfil
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();

    }

?>