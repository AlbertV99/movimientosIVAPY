<?php
/*conexion V2
    VERSION DEL MODULO DE CONEXION IMPLEMENTANDO LOS MISMOS METODOS PERO DE UNA MANERA MAS ORDENADA, APLICANDO:
        DICCIONARIOS PARA RECIBIR LOS CAMPOS Y DATOS
        PDO
*/
namespace Movimientos\Config\Conexion;

// echo __NAMESPACE__."<br>";
class Conexion {
    const HOST = "mysql:host=localhost;dbname=facturacion";
    const USER = "root";
    const PASS = '';
    //const TBL_LOG = "log";
    public $conexion;

    public function __construct(){

    }
    /**
     * Funcion para establecer conexion a la base de datos
     * @return [type] [description]
     */
    public function conectar(){
        try {
            $this->conexion= new \PDO(self::HOST,self::USER,self::PASS);
        } catch (PDOException $e) {
            print "ERROR EN CONEXION ->".$e->getMessage()."</br>";
            die();
        }finally{
        }
    }
    /**
     * Funcion para realizar cualquier tipo de consulta a la base de datos utilizando el prepare()->execute();
     * @param  string $query [description]
     * @param  array  $datos array de datos a ser reemplazados en el statement(OBS: pasar en el orden que deben ser utilizados en el query)
     * @return mixed        valor a retornar
     */
    public function consultar($query,$datos){
        $temp=$this->conexion->prepare($query);
        //var_dump( $temp);

        try {
            $res = $temp->execute($datos);
            //var_dump( $res);
        } catch (PDOException $e) {
            print("error ");
            throw new PDOExceptions("Error Processing Request", 1);

        }finally{
            //echo $res ." - ";
            if($res==TRUE){
                //echo $temp->fetchAll();
                return $temp;
            }else{
                return $res;
            }
        }
    }
}
















?>
