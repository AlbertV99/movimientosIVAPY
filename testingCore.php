<?php
//inclusion de php para conectar con la BD

    // NOTE: condicionar por tipo de protocolo
    $method = $_SERVER['REQUEST_METHOD'];
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            // code...
            break;
        case 'GET':
            // code...
            break;

        case 'PUT':
            // code...
            break;

        case 'DELETE':
            // code...
            break;

        default:
            echo 'ERROR';
    }
?>
