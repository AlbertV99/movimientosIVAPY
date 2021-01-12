<!DOCTYPE html>
<html lang="es" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <script src="bootstrap/js/bootstrap.bundle.js" charset="utf-8"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php
            session_start();
            require_once('Parametros/Conexion.php');
            require_once('Parametros/Objetos/Movimiento.php');
            use Movimientos\Config\Conexion as Conexion;
            $conexion=new Conexion\Conexion();
            $conexion->conectar();

        ?>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md">
                    <h2>Menu principal</h2>
                </div>
            </div>
            <div class="row justify-content-center align-items-center">
                <div class="col-md-5 ">
                    <div class="form-floating input-group mb-3" >
                        <input class="form-control" placeholder="0" type="text" list="usuarioLista" id="usuario" value="<?php echo (isset($_SESSION['usuario_actual']))?$_SESSION['usuario_actual']:""?>">
                        <label for="usuario">Usuario</label>
                        <button class="btn btn-outline-secondary" type="button" onclick="cambiarUsuario()" >Cambiar</button>

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
            <div class="row justify-content-center align-items-center">
                <div class="col-md-5 ">
                    <div class="d-grid gap-2">

                        <button type="button" class="btn btn-primary text-nowrap btn-lg" name="button" onclick="window.location='usuario_panel.php'">usuarios</button>
                        <br>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center align-items-center">
                <div class="col-md-5 ">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-primary text-nowrap btn-lg " name="button" onclick="window.location='empresa_panel.php'">Empresas</button>
                        <br>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-5 ">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-primary text-nowrap btn-lg" name="button" onclick="window.location='movimiento_panel.php'">Movimientos</button>
                    </div>
                </div>
            </div>

            </div>
        </div>

    </body>
    <script type="text/javascript">
        function cambiarUsuario(){
            let metodo='POST';
            let form={
                "usuario":document.getElementById("usuario").value,
            };
            fetch("api/cambiar_usuario.php", {
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
                   return temp.text()
               }
           ).then(
               function (res){
                   console.log(res);
               }
           ).catch(
               res=>console.log(res)
           );
        }
    </script>
</html>
