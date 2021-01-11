<?php
    //inclusion de php para conectar con la BD
    namespace Movimientos\Api\Usuario ;
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    require_once('../Parametros/Conexion.php');
    require_once('../Parametros/Objetos/Movimiento.php');
    use Movimientos\Config\Conexion as Conexion;
    use Movimientos\Config\Objetos\Movimiento as Movimiento;
    $conexion=new Conexion\Conexion();
    $conexion->conectar();

    $movimiento=new Movimiento\Movimiento($conexion->conexion);
    // NOTE: condicionar por tipo de protocolo
    $metodo = $_SERVER['REQUEST_METHOD'];
    //CRUD
    switch ($metodo) {
        case 'POST'://NUEVO MOVIMIENTO
            $temp=json_decode(file_get_contents("php://input"));
            $movimiento->nfactura = $temp->n_factura;
            $movimiento->fecha = $temp->fecha;
            $movimiento->tipo = $temp->tipo;
            $movimiento->empresa = $temp->empresa;
            $movimiento->valor_excenta = $temp->valor_excenta;
            $movimiento->valor_gravada10 = $temp->valor_gravada10;
            $movimiento->valor_gravada5 = $temp->valor_gravada5;
            $movimiento->usuario = $temp->usuario;
            try {
                $resultado=$movimiento->crear_movimiento();
                echo \json_encode(['mensaje'=>$resultado]);
            } catch (\Exception $e) {
                echo \json_encode(['mensaje'=>$e->getMessage()]);
            }

            break;
        case 'GET'://OBTENER USUARIO
        // print_r($_GET);
        $res=[];
        try {
            if(isset($_GET['id'])){
                $movimiento->cargar_id($_GET['id']);
                $res=$movimiento->leer_movimiento_unico();
            }else if(isset($_GET['tipo'])){
                
                $res=$movimiento->leer_movimientos_tipo($_GET['tipo']);
                // $res=["mensaje"=>"testing correcto"];
            }

        } catch (\Exception $e) {
            $res=["mensaje"=>$e->getMessage()];
        }
        echo \json_encode($res);
            break;

        case 'PUT'://MODIFICACION DE USUARIO
            $temp=json_decode(file_get_contents("php://input"));
            $movimiento->nfactura = $temp->nfactura;
            $movimiento->fecha = $temp->fecha;
            $movimiento->tipo = $temp->tipo;
            $movimiento->empresa = $temp->empresa;
            $movimiento->valor_excenta = $temp->valor_excenta;
            $movimiento->valor_gravada10 = $temp->valor_gravada10;
            $movimiento->valor_gravada5 = $temp->valor_gravada5;

            try {
                $movimiento->cargarId($temp->id);
                $resultado=$movimiento->actualizar_empresa();
                echo \json_encode(['mensaje'=>$resultado]);
            } catch (\Exception $e) {
                echo \json_encode(['mensaje'=>$e->getMessage()]);
            }

            break;

        case 'DELETE'://ELIMINAR USUARIO
            $temp=json_decode(file_get_contents("php://input"));
            try {
                $movimiento->cargar_id($temp->id);
                $resultado=$movimiento->eliminar_movimiento();
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
