<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        <form class="form" >
            <input type="hidden" name="id" id='id' value="">
            <label for="nombre">Fecha</label>
            <input type="text" name="nombre" id='nombre' value=""><br>
            <label for="ruc">Factura</label>
            <input type="text" name="ruc" id='ruc' value=""><br>
            <label for="direccion">Direccion</label>
            <input type="text" name="direccion" id='direccion' value=""><br>
            <input type="button" name="guardar" value="Guardar" onclick="test()">
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
