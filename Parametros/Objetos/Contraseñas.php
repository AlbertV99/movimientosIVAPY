<?php
/**
 * Clase de usuarios
 */
namespace Movimientos\Config\Objetos\Contrasenhas ;
// echo __NAMESPACE__;

define('CANTIDAD_FILAS',25);
class Constrasenha{
    public $usuario;
    public $programa;
    public $nombre_usuario;
    public $pass;
    public $observacion;
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
    public function crear_cuenta(){
        if(empty($this->usuario) ){
            throw new \Exception("Es definir de quien es el registro", 1);

        }elseif(empty($this->nombre_usuario) ){
            throw new \Exception("Es necesario el usuario", 1);

        }elseif(empty($this->programa) ){
            throw new \Exception("Es necesario el programa ", 1);
        }elseif (empty($this->pass) ){
            throw new \Exception("Es necesario la contrasenha", 1);

        }else{
            try {
                $insert=$this->db->prepare('INSERT INTO registro_password (usuario,programa,nombre_usuario,pass,nota) VALUES (?,?,?,?)');
                $insert->execute([$this->usuario,$this->programa,$this->nombre_usuario,$this->pass,$this->observacion]);
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
    public function actualizar_cuenta(){
        if(empty($this->usuario) ){
            throw new \Exception("Es definir de quien es el registro", 1);

        }elseif(empty($this->nombre_usuario) ){
            throw new \Exception("Es necesario el usuario", 1);

        }elseif(empty($this->programa) ){
            throw new \Exception("Es necesario el programa ", 1);
        }elseif (empty($this->pass) ){
            throw new \Exception("Es necesario la contrasenha", 1);

        }else{
            try {
                $actualizar=$this->db->prepare('UPDATE empresa SET usuario=?,programa=?,nombre_usuario=?,pass=?,nota=? WHERE usuario = ? AND nombre_usuario=? AND programa=?');
                $actualizar->execute([$this->usuario,$this->programa,$this->nombre_usuario,$this->pass,$this->observacion,$this->usuario,$this->nombre_usuario,$this->programa]);
                return "correcto";
            } catch (\Exception $e) {
                throw $e;
            }

        }
    }
    public function eliminar_cuenta(){
        if(empty($this->id)){
            throw new \Exception("Cuenta no seleccionada",1);
        }else{
            try {
                $this->db->prepare('DELETE registro_password WHERE usuario = ? AND nombre_usuario=? AND programa=?');
                $temp=$this->execute([$this->usuario,$this->nombre_usuario,$this->programa]);
                return true;
            } catch (\Exception $e) {
                throw $e;
            }
        }
        return false;
    }
    public function leer_cuenta_unica(){
        if(!empty($this->id)){
            $query = "SELECT usuario,nombre_usuario,pass,programa,nota FROM registro_password WHERE id=? ";
        }else{
            throw new \Exception("No se puede obtener empresa, id no configurado", 1);
        }
    }
    public function leer_cuenta(){
        $temp=$this->db->prepare("SELECT usuario,usuario.nombre,nombre_usuario,pass,programa,nota FROM registro_password LEFT JOIN usuario ON usuario.ruc = registro_password.usuario  ORDER BY programa DESC ");
        $temp->execute();
        if($temp->rowCount()>0){
            return $temp->fetchAll(\PDO::FETCH_ASSOC);
        }else{
            throw new \Exception("No existen empresas", 1);

        }
    }

}


?>
