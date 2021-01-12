<?php
    session_start();
    $temp=json_decode(file_get_contents("php://input"));
    if(isset($temp->usuario)){
        $_SESSION['usuario_actual'] = $temp->usuario;
    }else{
        echo json_encode(['mensaje'=>"Error al definir usuario"]);
    }




?>
