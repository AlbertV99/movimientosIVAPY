<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
        <style media="screen">
        $theme-colors: (
            "primary": #00000f,
            );
            </style>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <script src="bootstrap/js/bootstrap.bundle.js" charset="utf-8"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">

    </head>
    <body>
        <form class="form" >
            <div class=".container">
                <input type="hidden" name="id" id='id' value="">
                <div class="row">
                    <div class="col-md-1">
                        <label class="form-label" for="nombre">Nombre</label>
                    </div>
                    <div class="col-md-3">
                        <input class="form-control" type="text" name="nombre" id='nombre' value=""><br>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <label class="form-label" for="ruc">R.U.C.</label>
                    </div>
                    <div class="col-md-3">
                        <input class="form-control" type="text" name="ruc" id='ruc' value=""><br>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <label class="form-label" for="telefono">Telefono</label>
                    </div>
                    <div class="col-md-3">
                        <input class="form-control" type="text" name="telefono" id='telefono' value=""><br>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <label class="form-label" for="direccion">Direccion</label>
                    </div>
                    <div class="col-md-3">
                        <input class="form-control" type="text" name="direccion" id='direccion' value=""><br>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <input type="button" class="btn btn-secondary" name="volver" value="Volver" onclick="window.location='usuario_panel.php'">
                    </div>
                    <div class="col-md-1">
                        <input type="button" class="btn btn-primary" name="guardar" value="Guardar" onclick="test()">
                    </div>
                </div>
            </div>



        </form>
    </body>
    <script type="text/javascript">
        function test(){
            guardar();
        }
        function guardar() {
            let metodo='POST';
            let form={
                "nombre":document.getElementById("nombre").value,
                "ruc":document.getElementById("ruc").value,
                "telefono":document.getElementById("telefono").value,
                "direccion":document.getElementById("direccion").value,
            };
            if(document.getElementById('id').value!=''){
                metodo='PUT';
                form['id']=document.getElementById('id').value;
            }
            fetch("api/usuario.php", {
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
    </script>
</html>
