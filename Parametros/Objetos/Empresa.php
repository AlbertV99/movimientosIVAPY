<?php
/**
 * Clase de usuarios
 */
namespace Movimientos\Config\Objetos\Empresa ;
// echo __NAMESPACE__;

define('CANTIDAD_FILAS',25);
class Empresa{
    private $id;
    public $nombre;
    public $ruc;
    public $direccion;
    public $telefono;
    public function __construct($db){
        $this->db=$db;
    }
    public function cargarId($id){
        if($id<1){
            throw new \Exception("Id invalido", 1);
        }else{
            $this->id=$id;
        }
    }
    public function crear_empresa(){
        if(empty($this->nombre) ){
            throw new \Exception("Es necesario el nombre", 1);

        }elseif(empty($this->ruc) ){
            throw new \Exception("Es necesario el R.U.C.", 1);

        }elseif(empty($this->direccion) ){
            throw new \Exception("Es necesario la direccion", 1);

        }elseif (empty($this->telefono) ){
            throw new \Exception("Es necesario el telefono", 1);

        }else{
            try {
                $insert=$this->db->prepare('INSERT INTO empresa (nombre,ruc,direccion,telefono) VALUES (?,?,?,?)');
                $insert->execute([$this->nombre,$this->ruc,$this->direccion,$this->telefono]);
                if($insert->rowCount()>0){
                    return "correcto";
                }else{
                    throw new \Exception("Error al guardar", 1);

                }
                // return "correcto";
            } catch (\Exception $e) {
                throw $e;
            }

        }
    }
    public function actualizar_empresa(){
        if(empty($this->id) ){
            throw new \Exception("Usuario no seleccionado", 1);

        }elseif(empty($this->nombre) ){
            throw new \Exception("Es necesario el nombre", 1);

        }elseif(empty($this->ruc) ){
            throw new \Exception("Es necesario el R.U.C.", 1);

        }elseif(empty($this->direccion) ){
            throw new \Exception("Es necesario la direccion", 1);

        }elseif (empty($this->telefono) ){
            throw new \Exception("Es necesario el telefono", 1);

        }else{
            try {
                $actualizar=$this->db->prepare('UPDATE empresa SET nombre=?,ruc=?,direccion=?,telefono=? WHERE id = ?');
                $actualizar->execute([$this->nombre,$this->ruc,$this->direccion,$this->telefono,$this->id]);
                return "correcto";
            } catch (\Exception $e) {
                throw $e;
            }

        }
    }
    public function eliminar_usuario(){
        if(empty($this->id)){
            throw new \Exception("Usuario no seleccionado",1);
        }else{
            try {
                $this->db->prepare('DELETE usuario WHERE id = ?');
                $temp=$this->execute([$this->id]);
                return true;
            } catch (\Exception $e) {
                throw $e;
            }
        }
        return false;
    }
    public function leer_empresa_unico(){
        if(!empty($this->id)){
            $query = "SELECT nombre,ruc,direccion,telefono FROM usuario WHERE id=? ";
        }else{
            throw new \Exception("No se puede obtener empresa, id no configurado", 1);

        }
    }
    public function leer_empresas(){
        $temp=$this->db->prepare("SELECT nombre,ruc,direccion,telefono FROM empresa ORDER BY ruc DESC ");
        $temp->execute();
        if($temp->rowCount()>0){
            return $temp->fetchAll(\PDO::FETCH_ASSOC);
        }else{
            throw new \Exception("No existen empresas", 1);

        }
    }

}


?>
