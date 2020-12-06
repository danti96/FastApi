<?php

$method = strtoupper( $_SERVER['REQUEST_METHOD'] );

$token = sha1('Esto es secreto!!');
if ( $method === 'POST' ) {
    //validar credenciales
    if ( !array_key_exists( 'HTTP_X_CLIENT_ID', $_SERVER ) || !array_key_exists( 'HTTP_X_SECRET', $_SERVER ) ) {
        http_response_code( 400 );

        die( 'Faltan parametros' );
    }
    // Tomar los headers
    $clientId = $_SERVER['HTTP_X_CLIENT_ID'];
    $secret = $_SERVER['HTTP_X_SECRET'];
// Verificar credenciales
    if ( $clientId !== '1' || $secret !== 'SuperSecreto!' ) {
        http_response_code( 403 );

        die ( "No autorizado");
    }
    //retorno el token seguro
    echo "$token";
} elseif ( $method === 'GET' ) {

    //validar token
    if ( !array_key_exists( 'HTTP_X_TOKEN', $_SERVER ) ) {
        http_response_code( 400 );

        die ( 'Faltan parametros' );
    }
    //validar el token pasado, el token podria ser el que se obtiene de la base de datos
    if ( $_SERVER['HTTP_X_TOKEN'] == $token ) {
        echo 'true';
    } else {
        echo 'false';
    }
} else {
    echo 'false';
}