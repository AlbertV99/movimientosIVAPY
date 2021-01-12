<?php
/**
 * Clase de usuarios
 */
namespace Movimientos\Config\Objetos\Movimiento ;
// echo __NAMESPACE__;

define('CANTIDAD_FILAS',25);
class Movimiento{
    public $nfactura;
    public $fecha;
    public $tipo;
    public $empresa;
    public $valor_excenta=0;
    public $valor_gravada10=0;
    public $valor_gravada5=0;
    public $total;
    public $neto10;
    public $neto5;
    public $iva10;
    public $iva5;
    public $usuario;
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
    public function crear_movimiento(){
        $this->procesar_total();
        if(empty($this->nfactura) ){
            throw new \Exception("Es necesario el numero de factura", 1);
        }elseif(empty($this->fecha) ){
            throw new \Exception("Es necesaria la fecha", 1);

        }elseif(empty($this->empresa) ){
            throw new \Exception("Es necesaria la empresa", 1);

        }elseif (empty($this->valor_excenta) && empty($this->valor_gravada5) && empty($this->valor_gravada10) ){
            throw new \Exception("Es necesario que la gravada10/5 o excenta ", 1);

        }elseif ($this->tipo!="VENTA" && $this->tipo!="COMPRA" ){
            throw new \Exception("El tipo de operacion no es correcto".$this->tipo, 1);

        }elseif ($this->total<=0 ){
            throw new \Exception("Es el total de la factura no puede ser menor a 1", 1);

        }elseif (empty($this->usuario) ){
            throw new \Exception("El usuario no puede quedar sin datos", 1);

        }else{
            try {
                $insert=$this->db->prepare('INSERT INTO movimiento(numero_factura, fecha, tipo, empresa_ruc, valor_excenta, gravada_10, gravada_5, total, usuario) VALUES (?,?,?,?,?,?,?,?,?)');
                $insert->execute([$this->nfactura,$this->fecha,$this->tipo,$this->empresa,$this->valor_excenta,$this->valor_gravada10,$this->valor_gravada5,$this->total,$this->usuario]);
                if($insert->rowCount()>0){
                    return "correcto";
                }else{
                    throw new \Exception("Error al guardar".\implode(':',$insert->errorInfo()), 1);
                    //implode(':',$insert->errorInfo()) con este codigo se puede armar un log de las razones de por que no guarda el registro
                }
                return "correcto";
            } catch (\Exception $e) {
                throw $e;
            }

        }
    }
    private function procesar_total(){
        $this->total=$this->valor_excenta+$this->valor_gravada5+$this->valor_gravada10;
        $this->iva10=$this->valor_gravada10*0.1;
        $this->iva5=$this->valor_gravada5*5/105;
        $this->neto5=$this->valor_gravada5-$this->iva5;
        $this->neto10=$this->valor_gravada10-$this->iva10;
    }
    public function actualizar_movimiento(){
        $this->procesar_total();
        if(empty($this->nfactura) ){
            throw new \Exception("Es necesario el numero de factura", 1);
        }elseif(empty($this->fecha) ){
            throw new \Exception("Es necesaria la fecha", 1);

        }elseif(empty($this->empresa) ){
            throw new \Exception("Es necesaria la empresa", 1);

        }elseif (empty($this->valor_excenta) && empty($this->valor_gravada5) && empty($this->valor_gravada10) ){
            throw new \Exception("Es necesario ", 1);

        }elseif ($this->tipo!="VENTA" || $this->tipo!="COMPRA" ){
            throw new \Exception("Es necesario el telefono", 1);

        }elseif ($this->total<=0 ){
            throw new \Exception("Es el total de la factura no puede ser menor a 1", 1);

        }else{
            try {
                // $this->db->prepare('UPDATE usuario SET nombre=?,ruc=?,direccion=?,telefono=? WHERE id = ?');
                // $temp=$this->execute([$this->nombre,$this->ruc,$this->direccion,$this->telefono]);
                return "correcto";
            } catch (\Exception $e) {
                throw $e;
            }

        }
    }
    public function eliminar_movimiento(){
        if(empty($this->id)){
            throw new \Exception("Movimiento no seleccionado",1);
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
    public function leer_movimiento_unico(){
        if(!empty($this->id)){
            $query = "SELECT nombre,ruc,direccion,telefono FROM usuario WHERE id=? ";
        }else{
            throw new \Exception("No se puede obtener usuario, id no configurado", 1);

        }
    }
    public function leer_movimientos(){
        if(!empty($this->id)){
            $query = "SELECT numero_factura,fecha,empresa.nombre AS empresa_nombre,empresa_ruc ,total,usuario.nombre AS usuario_nombre, usuario FROM movimiento LEFT JOIN   usuario ON usuario.ruc=usuario LEFT JOIN  empresa ON empresa_ruc = empresa.ruc ORDER BY fecha DESC";
        }else{
            throw new \Exception("No existen usuarios", 1);

        }
    }
    public function leer_movimientos_tipo($tipo){
        $query = "SELECT numero_factura,fecha,empresa.nombre AS empresa_nombre,empresa_ruc ,total,usuario.nombre AS usuario_nombre, usuario FROM movimiento LEFT JOIN   usuario ON usuario.ruc=usuario LEFT JOIN  empresa ON empresa_ruc = empresa.ruc WHERE tipo=? AND usuario=? ORDER BY fecha DESC";
        $temp=$this->db->prepare($query);
        $temp->execute([$tipo,$this->usuario]);
        if($temp->rowCount()>0){
            return $temp->fetchAll(\PDO::FETCH_ASSOC);
        }else{
            throw new \Exception("No existen movimientos", 1);

        }
    }
    public function obtener_movimientos_totalizado_tipo($tipo,$mes,$anho){
        $query = "SELECT
            numero_factura,
            fecha,
            empresa.nombre AS empresa_nombre,
            empresa_ruc ,
            usuario.nombre AS usuario_nombre,
            usuario,
            valor_excenta,
            gravada_10,
            gravada_5,
            total
            FROM movimiento
            LEFT JOIN   usuario ON usuario.ruc=usuario
            LEFT JOIN  empresa ON empresa_ruc = empresa.ruc
             WHERE  tipo=? AND MONTH(fecha)=? AND YEAR(fecha)=?  AND usuario = ? ORDER BY fecha DESC";
             // echo $tipo." ".$mes." ".$anho." ".$this->usuario;
        $temp=$this->db->prepare($query);
        $temp->execute([$tipo,$mes,$anho,$this->usuario]);

        if($temp->rowCount()>0){
            return $temp->fetchAll(\PDO::FETCH_ASSOC);
        }else{
            return [];

        }
    }


}

?>
