<?php
    //inclusion de php para conectar con la BD
    namespace Movimientos\Api\Usuario ;
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    require_once('../Parametros/Conexion.php');
    require_once('../Parametros/Objetos/Empresa.php');
    use Movimientos\Config\Conexion as Conexion;
    use Movimientos\Config\Objetos\Empresa as Empresa;
    $conexion=new Conexion\Conexion();
    $conexion->conectar();

    $empresa=new Empresa\Empresa($conexion->conexion);
    // NOTE: condicionar por tipo de protocolo
    $metodo = $_SERVER['REQUEST_METHOD'];
    //CRUD
    switch ($metodo) {
        case 'POST'://NUEVO USUARIO
            $temp=json_decode(file_get_contents("php://input"));
            $empresa->nombre = $temp->nombre;
            $empresa->ruc = $temp->ruc;
            $empresa->direccion = $temp->direccion;
            $empresa->telefono = $temp->telefono;
            try {
                $resultado=$empresa->crear_empresa();
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
                    $empresa->cargar_id($temp->id);
                    $res=$empresa->leer_empresa_unica();
                }else{
                    $res=$empresa->leer_empresas();
                }

            } catch (\Exception $e) {
                $res=["mensaje"=>$e->getMessage()];
            }
            echo \json_encode($res);
            break;

        case 'PUT'://MODIFICACION DE USUARIO
            $temp=json_decode(file_get_contents("php://input"));
            $empresa->nombre = $temp->nombre;
            $empresa->ruc = $temp->ruc;
            $empresa->direccion = $temp->direccion;
            $empresa->telefono = $temp->telefono;

            try {
                $empresa->cargarId($temp->id);
                $resultado=$empresa->actualizar_empresa();
                echo \json_encode(['mensaje'=>$resultado]);
            } catch (\Exception $e) {
                echo \json_encode(['mensaje'=>$e->getMessage()]);
            }

            break;

        case 'DELETE'://ELIMINAR USUARIO
            $temp=json_decode(file_get_contents("php://input"));
            try {
                $empresa->cargar_id($temp->id);
                $resultado=$empresa->eliminar_usuario();
                echo \json_encode(['mensaje'=>$resultado]);
            } catch (\Exception $e) {
                echo \json_encode(['mensaje'=>$e->getMessage()]);
            }
            break;
        default:
            echo \json_encode(['mensaje'=>"Error"]);
            break;
    }




?>
