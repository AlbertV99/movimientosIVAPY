<!DOCTYPE html>
<html lang="es" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <script src="bootstrap/js/bootstrap.bundle.js" charset="utf-8"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <div class=".container">
            <div class="row">
                <div class="col-md">
                    <h2>Usuario</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <button type="button" class="btn btn-primary" name="button" onclick="window.location='usuario_form.php'">Crear</button>
                    <button type="button" class="btn btn-secondary" name="button">Editar</button>
                    <button type="button" class="btn btn-danger" name="button">Eliminar</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md">
                    <table class='table table-striped table-hover'>
                        <thead>
                            <tr style="background-color:#214184;color:white">
                                <th>Ruc</th>
                                <th>Nombre</th>
                                <th>Telefono</th>
                                <th>Direccion</th>
                            </tr>

                        </thead>
                        <tbody id='tabla-usuario'>

                        </tbody>
                    </table>

                </div>
            </div>

        </div>

    </body>
    <script type="text/javascript">
    function inicializar(){
        obtenerDatos()
    }
    function obtenerDatos() {
        fetch("api/usuario.php", {
           method: 'GET', // *GET, POST, PUT, DELETE, etc.
           redirect: 'follow', // manual, *follow, error
           referrerPolicy: 'no-referrer',
       })
       .then(temp=>temp.json())
       .then(function (res){cargarTabla(res)})
       .catch(res=>console.log(res));
    }
    function cargarTabla(datos){
        console.log(datos);
        const TABLA=document.getElementById('tabla-usuario');
        TABLA.innerHTML="";
        for (var fila of datos) {
            TABLA.innerHTML+="<tr><td>"+fila.ruc+"</td><td>"+fila.nombre+"</td><td>"+fila.telefono+"</td><td>"+fila.direccion+"</td></tr>"
        }
    }
    inicializar();
    </script>
</html>
