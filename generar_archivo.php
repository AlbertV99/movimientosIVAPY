<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    session_start();
    require_once('Parametros/Conexion.php');
    require_once('Parametros/Objetos/Movimiento.php');
    use Movimientos\Config\Conexion as Conexion;
    use Movimientos\Config\Objetos\Movimiento as Movimiento;
    $conexion=new Conexion\Conexion();
    $conexion->conectar();
    $movimiento=new Movimiento\Movimiento($conexion->conexion);
    if(!isset($_SESSION['usuario_actual'])){
        header("Location:index.php");
    }
    $movimiento->usuario=$_SESSION['usuario_actual'];
    // $movimiento->usuario='5031168-9';
    $tipo=$_GET['tipo'];
    if(isset($tipo)){
        try {
            $resultado=$movimiento->obtener_movimientos_totalizado_tipo($tipo,$_GET['mes'],$_GET['anho']);
            // print_r(totalizar($resultado,$tipo));
            $datos_generados=totalizar($resultado,$tipo);
            // print_r($datos_generados);
            generar_excel($datos_generados);
        } catch (\Exception $e) {
            echo "Error".$e->getMessage();
        }

    }else{
        echo "HA OCURRIDO UN ERROR, NOTIFIQUE AL SOPORTE";
    }


    function generar_excel($datos) {
        // print_r($datos);
        $timestamp = time();
        $filename = $datos['movimiento']['tipo']."_". $timestamp . '.xls';

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");

        $isPrintHeader = false;
        $excel=$datos['movimiento']['datos'];
        echo $datos['movimiento']['tipo']."\n";
        if(count($excel)<1){
            echo "No hubo movimientos";
        }
        foreach ($excel as $row) {

            if (! $isPrintHeader ) {

                echo implode("\t", array_keys($row)) . "\n";
                $isPrintHeader = true;

            }

            echo implode("\t", array_values($row)) . "\n";

        }
        echo "\nTOTAL ".$datos['movimiento']['tipo']." :\t".$datos['movimiento']['total'];
        exit();

    }

    function totalizar($movimiento,$tipo){
        $total_datos=[
            'movimiento'=>[
                'tipo'=>$tipo,
                'datos'=>[],
                'totalizar'=>[],
                'total'=>0
            ],
        ];


        for ($i=0; $i <count($movimiento) ; $i++) {
            $movimiento[$i]['iva10']=  $movimiento[$i]['gravada_10']*10/110;
            //$movimiento[$i]['iva10']= $movimiento[$i]['gravada_10']*10/110;
            $movimiento[$i]['iva5']= $movimiento[$i]['gravada_5']*5/105;
            $movimiento[$i]['neto10']= $movimiento[$i]['gravada_10']-$movimiento[$i]['iva10'];
            $movimiento[$i]['neto5']= $movimiento[$i]['gravada_5']-$movimiento[$i]['iva5'];
            $movimiento[$i]['total_impuestos']=$movimiento[$i]['iva10']+$movimiento[$i]['iva5'];
            $total_datos['movimiento']['total']+=$movimiento[$i]['total_impuestos'];


            //FORMATEO DE NUMEROS
            $movimiento[$i]['iva10']= number_format((((float) $movimiento[$i]['gravada_10'])*10/110), 0, ',', '.');
            //$movimiento[$i]['iva10']= $movimiento[$i]['gravada_10']*10/110;
            $movimiento[$i]['iva5']=number_format((((float) $movimiento[$i]['gravada_5'])*5/105),0,',','.');
            $movimiento[$i]['neto10']=number_format((((float) $movimiento[$i]['gravada_10']-$movimiento[$i]['iva10'])), 0, ',', '.');
            $movimiento[$i]['neto5']=number_format((((float) $movimiento[$i]['gravada_5']-$movimiento[$i]['iva5'])), 0, ',', '.');
            $movimiento[$i]['total_impuestos']=number_format(((float) $movimiento[$i]['total_impuestos']),0,',','.');
        }
        $total_datos['movimiento']['total']=number_format( ((float) $total_datos['movimiento']['total']),0,',','.');
        //print_r($movimiento);
        $total_datos['movimiento']['datos']=$movimiento;
        return $total_datos;
    }

?>
