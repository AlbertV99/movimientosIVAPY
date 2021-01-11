<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
        <?php
            require_once('Parametros/Conexion.php');
            use Movimientos\Config\Conexion as Conexion;
            $conexion=new Conexion\Conexion();
            $conexion->conectar();

        ?>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <script src="bootstrap/js/bootstrap.bundle.js" charset="utf-8"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <form class="form" >
            <div class=".container">
                <input type="hidden" name="id" id='id' value="">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input class="form-control" placeholder="0" type="text" list="usuarioLista" id="usuario" value="">
                            <label for="usuario">Usuario</label>
                            <datalist  id='usuarioLista'>
                                <?php
                                    $temp=$conexion->conexion->query("SELECT ruc,nombre FROM usuario");
                                    $temp=$temp->fetchAll(PDO::FETCH_ASSOC);
                                    // print_r($temp);
                                    foreach ($temp as $key => $value) {
                                        echo "<option value='".$value['ruc']."'>".$value['nombre']."</option>";
                                    }
                                ?>
                            </datalist><br>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input class="form-control" placeholder="0" type="date" name="fecha" id='fecha' value=""><br>
                            <label for="fecha">Fecha</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input class="form-control" placeholder="0" type="text" name="factura" id='factura' value=""><br>
                            <label for="factura">Factura</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating input-group">
                            <input class="form-control" placeholder="0" type="text" list="empresaLista" id="empresa" value="">
                            <label for="empresa">Empresa</label>
                            <datalist  id='empresaLista'>
                                <?php
                                    $temp=$conexion->conexion->query("SELECT ruc,nombre FROM empresa");
                                    $temp=$temp->fetchAll(PDO::FETCH_ASSOC);
                                    // print_r($temp);
                                    foreach ($temp as $key => $value) {
                                        echo "<option value='".$value['ruc']."'>".$value['nombre']."</option>";
                                    }
                                ?>
                            </datalist>
                            <button class="btn btn-outline-secondary" type="button"  placeholder="0" type="button" name="" >Nuevo</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">

                        <input class="form-control" placeholder="0" type="number" name="excenta" id='excenta' value=""><br>
                        <label for="excenta">Valor Excenta</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input class="form-control" placeholder="0" type="number" name="gravada5" id='gravada5' value=""><br>
                            <label for="gravada5">Valor Gravada 5%</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input class="form-control" placeholder="0" type="number" name="gravada10" id='gravada10' value=""><br>
                            <label for="gravada10">Valor Gravada 10%</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input class="form-control" placeholder="0" type="number" name="neto10" id='neto10' value=""><br>
                            <label for="neto10">Neto 10%</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input class="form-control" placeholder="0" type="number" name="neto5" id='neto5' value=""><br>
                            <label for="neto5">Neto 5%</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input class="form-control" placeholder="0" type="number" name="iva5" id='iva5' value=""><br>
                            <label for="iva5">I.V.A. 5%</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input class="form-control" placeholder="0" type="number" name="iva10" id='iva10' value=""><br>
                            <label for="iva10">I.V.A. 10%</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input class="form-control" placeholder="0" type="number" name="total" id='total' value=""><br>
                            <label for="total">Total Factura</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <input type="button" class="btn btn-secondary" name="guardar" value="Volver" onclick="window.location='movimiento_panel.php'">

                    </div>
                    <div class="col-md-2">
                        <input type="button" class="btn btn-primary" name="guardar" value="Guardar" onclick="test()">
                    </div>
                </div>

            </div>

            <!-- tipo : compra -->
            <input type="hidden" name="id" id='id' value="">
        </form>
    </body>
    <script type="text/javascript">
        function test(){
            guardar();
        }
        function guardar() {
            let metodo='POST';
            let form={
                "n_factura":document.getElementById("factura").value,
                "fecha":document.getElementById("fecha").value,
                "tipo":"VENTA",
                "empresa":document.getElementById("empresa").value,
                "valor_excenta":document.getElementById("excenta").value,
                "valor_gravada10":document.getElementById("gravada10").value,
                "valor_gravada5":document.getElementById("gravada5").value,
                "usuario":document.getElementById("usuario").value,

            };
            if(document.getElementById('id').value!=''){
                metodo='PUT';
                form['id']=document.getElementById('id').value;
            }
            fetch("api/movimiento.php", {
               method: metodo, // *GET, POST, PUT, DELETE, etc.
               // mode: 'cors', // no-cors, *cors, same-origin
               // cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
               // credentials: 'same-origin', // include, *same-origin, omit
               // headers: {
               //   'Content-Type': 'application/json'
               // },
               redirect: 'follow', // manual, *follow, error
               referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
               body: JSON.stringify(form) // body data type must match "Content-Type" header
           }).then(
               function (temp){
                   return temp.json()
               }
           ).then(
               function (res){
                   alert(res['mensaje'])
               }
           ).catch(
               res=>console.log(res)
           );
        }
        function actualizar_empresa(){
            fetch("api/empresa.php", {
               method: 'GET', // *GET, POST, PUT, DELETE, etc.
               redirect: 'follow', // manual, *follow, error
               referrerPolicy: 'no-referrer',
           }).then(
               function (temp){
                   return temp.json()
               }
           ).then(
               function (res){
                   const LISTA_EMPRESA=document.getElementById('empresaLista');
                   LISTA_EMPRESA.innerHTML="";
                   for (var i = 0; i < res.length; i++) {
                       console.log(res[i].ruc);
                       LISTA_EMPRESA.innerHTML+="<option value='"+res[i]['ruc']+"'>"+res[i]['nombre']+"</option>";
                   }
               }
           ).catch(
               res=>console.log(res)
           );
        }
    </script>
</html>
