<?php

    require_once 'vendor/autoload.php';
    require_once 'credentials.php';
    
    $clientID = $_ENV['clientID'];
    $clientSecret = $_ENV['clientSecret'];
    $redirectUri = $_ENV['redirectUri'];

    //Crear un objeto de Google Client para realizar una peticion a la API de Google
    $client = new Google_Client();
    $client->setClientId($clientID);
    $client->setClientSecret($clientSecret);
    $client->setRedirectUri($redirectUri);
    $client->setPrompt('consent');
    $client->addScope("email");
    $client->addScope("profile");

?>