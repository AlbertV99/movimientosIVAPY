<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    session_start();
    require_once('Parametros/Conexion.php');
    use Movimientos\Config\Conexion as Conexion;
    $conexion=new Conexion\Conexion();
    $conexion->conectar();
    $mes=$_GET['mes'];
    // $mes="01";
    $anho=$_GET['anho'];
    // $anho="2021";
    if(!isset($_SESSION['usuario_actual'])){
        header("Location:index.php");
    }

    $total_compra=$conexion->conexion->query("SELECT COALESCE(sum(valor_excenta),0) as excenta,COALESCE(sum(gravada_5),0) as gravada5,COALESCE(sum(gravada_10),0) as gravada10 ,COALESCE(sum(gravada_5*5/105),0) as neto5,COALESCE(sum(gravada_10*10/110),0) as neto10,COALESCE(sum(total),0) AS total FROM movimiento WHERE tipo='COMPRA' AND MONTH(fecha)=$mes AND YEAR(fecha)=$anho");
    $total_compra=$total_compra->fetchAll(PDO::FETCH_ASSOC);
    $total_compra=$total_compra[0];
    $total_venta=$conexion->conexion->query("SELECT COALESCE(sum(valor_excenta),0) as excenta,COALESCE(sum(gravada_5),0) as gravada5,COALESCE(sum(gravada_10),0) as gravada10 ,COALESCE(sum(gravada_5*5/105),0) as neto5,COALESCE(sum(gravada_10*10/110),0) as neto10,COALESCE(sum(total),0) as total FROM movimiento WHERE tipo='VENTA' AND MONTH(fecha)=$mes AND YEAR(fecha)=$anho");
    $total_venta=$total_venta->fetchAll(PDO::FETCH_ASSOC);
    $total_venta=$total_venta[0];
    // print_r($total_compra);
    // print_r($total_venta);
    $datos = [];
    array_push($datos,$total_compra);
    array_push($datos,$total_venta);

    // print_r($datos);
    $timestamp = time();
    $filename = "Total_". $timestamp . '.xls';

    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");

    $isPrintHeader = false;
    echo "Total I.V.A. \n";
    if(count($datos)<1){
        echo "No hubo movimientos";
    }
    foreach ($datos as $row) {

        if (! $isPrintHeader ) {

            echo implode("\t", array_keys($row)) . "\n";
            $isPrintHeader = true;

        }

        echo implode("\t", array_values($row)) . "\n";

    }
    echo "\n\t\tTOTAL\t".($datos[0]['neto5']-$datos[1]['neto5'])."\t".
    ($datos[0]['neto10']-$datos[1]['neto10'])."\t".($datos[0]['total']-$datos[1]['total'])."\n";
    exit();


?>
