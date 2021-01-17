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
            if(!isset($_SESSION['usuario_actual'])){
                header("Location:index.php");
            }

        ?>
    </head>
    <body>
        <div class=".container">
            <div class="row">
                <div class="col-md">
                    <h2>Movimientos</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <button type="button" class="btn btn-primary" name="button" onclick="window.location='movimiento_compra_form.php'">Cargar Compra</button>
                    <button type="button" class="btn btn-success" name="button" onclick="window.location='movimiento_venta_form.php'">Cargar Venta</button>
                    <button type="button" class="btn btn-secondary" name="button">Editar</button>
                    <button type="button" class="btn btn-danger" name="button">Eliminar</button>
                    <button type="button" class="btn btn-outline-info" name="button" onclick="generarExcel()">Generar Excel</button>
                    <button type="button" class="btn btn-outline-info" name="button" onclick="generarExcel()">Generar Totales</button>

                </div>
                <div class="col-md-5 d-flex justify-content-end">
                    <div class="btn-group" id='tipo'>
                        <input type="radio" class="btn-check" name="btnradio" id="compra" autocomplete="off" checked onclick='cambiar("COMPRA")'>
                        <label class="btn btn-outline-primary" for="compra">Compra</label>

                        <input type="radio" class="btn-check" name="btnradio" id="venta" autocomplete="off" onclick="cambiar('VENTA')">
                        <label class="btn btn-outline-primary" for="venta">Venta</label>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md">
                    <table class='table table-striped table-hover'>
                        <thead>
                            <tr style="background-color:#214184;color:white">
                                <th>Fecha</th>
                                <th>N. Factura</th>
                                <th>Empresa</th>
                                <th>Total</th>
                                <th>Usuario</th>
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
    function cambiar(tipo){
        obtenerDatos(tipo);
    }
    function obtenerDatos(tipo="COMPRA") {
        console.log(tipo);
        fetch("api/movimiento.php?tipo="+tipo, {
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
            TABLA.innerHTML+="<tr><td>"+fila.fecha+"</td><td>"+fila.numero_factura+"</td><td>"+fila.empresa_nombre+"</td><td>"+fila.total+"</td><td>"+fila.usuario_nombre+"</td></tr>"
        }
    }
    function generarExcel(){
        let mes=window.prompt("Introduzca el mes del reporte");
        let anho=window.prompt("Introduzca el año del reporte");
        if(document.getElementById('compra').checked){
            window.open(`generar_archivo.php?tipo=COMPRA&anho=${anho}&mes=${mes}`);
        }else {
            window.open(`generar_archivo.php?tipo=VENTA&anho=${anho}&mes=${mes}`);

        }
    }
    function generarTotales(){
        let mes=window.prompt("Introduzca el mes del reporte");
        let anho=window.prompt("Introduzca el año del reporte");
        window.open(`generar_totales.php?anho=${anho}&mes=${mes}`);
    }
    function popup(titulo,cuerpo,botones){
        const BODY=document.body;
        let popup=[];
            popup['popup']= document.createElement('div');
            popup['popup'].className='modal fade show';
            popup['popup'].tabindex="-1"
            popup['popup'].id='modal';
            popup['dialog']= document.createElement('div');
            popup['dialog'].className='modal-dialog';
            popup['contenido']= document.createElement('div');
            popup['contenido'].className='modal-content';
            popup['cabecera']= document.createElement('div');
            popup['cabecera'].className='modal-header';
            popup['titulo']= document.createElement('div');
            popup['titulo'].className='modal-title';
            popup['titulo'].innerHTML=titulo;
            popup['cerrar']= document.createElement('input');
            popup['cerrar'].className='btn-close';
            popup['cerrar'].dataBsDismiss="modal"
            popup['cerrar'].addEventListener('click',function(){
                new bootstrap.Modal(document.getElementById('modal'));
                myModal.show()
            });
            popup['cerrar'].type='button';
            popup['cerrar'].dataBsDismiss='modal';
            popup['cerrar'].ariaLabel='Close';
            popup['cuerpo']= document.createElement('div');
            popup['cuerpo'].className='modal-body';
            popup['pie']= document.createElement('div');
            popup['pie'].className='modal-footer';
            // recorrerHijosEjecutar(popup['cuerpo'],cuerpo);
            // recorrerHijosEjecutar(popup['pie'],botones);
            agregarHijo(popup['popup'],popup['dialog']);
            agregarHijo(popup['dialog'],popup['contenido']);
            agregarHijo(popup['contenido'],popup['cabecera']);
            agregarHijo(popup['cabecera'],popup['titulo']);
            agregarHijo(popup['cabecera'],popup['cerrar']);
            agregarHijo(popup['contenido'],popup['cuerpo']);
            agregarHijo(popup['contenido'],popup['pie']);
            agregarHijo(BODY,popup['popup']);
            // console.log("testing");
            var myModal = new bootstrap.Modal(document.getElementById('modal'));
            myModal.show();


    }
    function agregarHijo(padre,hijo){
        padre.appendChild(hijo);
        // console.log(padre+"<="+hijo);
    }
    function verificarExistenciaHijo(padre){
        console.log(padre);
        // console.log(Array.isArray(padre)+"VERIFICAR"+padre.length);
        if((Array.isArray(padre) || Object.prototype.toString.call(padre) === '[object Object]' ) && padre.length>0){
            return true;
        }
    }
    function recorrerHijosEjecutar(padre,cuerpo){
        let anterior='';
        let c=0;
        for (var variable in cuerpo) {
            if (cuerpo.hasOwnProperty(variable)) {
                if(verificarExistenciaHijo(cuerpo[variable])){
                    recorrerHijosEjecutar(anterior,cuerpo[variable]);
                }else{
                    agregarHijo(padre,cuerpo[variable]);
                }
                anterior=variable;
            }
        }
    }
    // popup("titul","test","test");


    inicializar();
    </script>
</html>
