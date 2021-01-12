<?php
    //inclusion de php para conectar con la BD

    namespace Movimientos\Api\Usuario ;
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    require_once('../Parametros/Conexion.php');
    require_once('../Parametros/Objetos/Usuario.php');
    session_start();
    use Movimientos\Config\Conexion as Conexion;
    use Movimientos\Config\Objetos\Usuario as Usuario;
    $conexion=new Conexion\Conexion();
    $conexion->conectar();

    $usuario=new Usuario\Usuario($conexion->conexion);
    // NOTE: condicionar por tipo de protocolo
    $metodo = $_SERVER['REQUEST_METHOD'];
    //CRUD
    switch ($metodo) {
        case 'POST'://NUEVO USUARIO
            $temp=json_decode(file_get_contents("php://input"));
            // $temp=$temp[0];
            // var_dump($temp);
            $usuario->nombre = $temp->nombre;
            $usuario->ruc = $temp->ruc;
            $usuario->direccion = $temp->direccion;
            $usuario->telefono = $temp->telefono;
            try {
                $resultado=$usuario->crear_usuario();
                echo \json_encode(['mensaje'=>$resultado]);
            } catch (\Exception $e) {
                echo \json_encode(['mensaje'=>$e->getMessage()]);
            }

            // echo \json_encode($temp);
            break;
        case 'GET'://OBTENER USUARIO
            $temp=json_decode(file_get_contents("php://input"));
            $res=[];
            try {
                if(isset($temp->id)){
                    $usuario->cargar_id($temp->id);
                    $res=$usuario->leer_usuario_unico();
                }else{
                    $res=$usuario->leer_usuarios();
                }

            } catch (\Exception $e) {
                $res=["mensaje"=>$e->getMessage()];
            }
            echo \json_encode($res);
            break;

        case 'PUT'://MODIFICACION DE USUARIO
            $temp=json_decode(file_get_contents("php://input"));


            $usuario->nombre = $temp->nombre;
            $usuario->ruc = $temp->ruc;
            $usuario->direccion = $temp->direccion;
            $usuario->telefono = $temp->telefono;

            try {
                $usuario->cargar_id($temp->id);
                $resultado=$usuario->actualizar_usuario();
                echo \json_encode(['mensaje'=>$resultado]);
            } catch (\Exception $e) {
                echo \json_encode(['mensaje'=>$e->getMessage()]);
            }

            break;

        case 'DELETE'://ELIMINAR USUARIO
            $temp=json_decode(file_get_contents("php://input"));
            try {
                $usuario->cargar_id($temp->id);
                $resultado=$usuario->eliminar_usuario();
                echo \json_encode(['mensaje'=>$resultado]);
            } catch (\Exception $e) {
                echo \json_encode(['mensaje'=>$e->getMessage()]);
            }
            break;
        default:
            echo 'ERROR';
            break;
    }




?>
