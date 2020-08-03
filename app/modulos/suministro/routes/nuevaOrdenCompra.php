<?php
require '../../../../database.php';
require '../components/layout.php';
require '../../recursoshumanos/components/modal.php';
require '../../seguridad/controllers/functions/credenciales.php';
date_default_timezone_set('America/Guayaquil');
$creacion = date('d')."/".date('m')."/".date('Y');
$created = date('d')."/".date('m')."/".date('Y')." ".date("H").":".date("i").":".date("s");
verificarAcceso("../../../../", "modulo_suministros");

$categoria = $conn->query("SELECT * FROM categoria ORDER BY nombre_cate ASC")->fetchAll(PDO::FETCH_OBJ);
$producto = $conn->query("SELECT * FROM productos AS p, categoria AS c WHERE (p.idcategoria_pr = c.idcategoria) AND deleted = 0 ORDER BY nombre_pr ASC")->fetchAll(PDO::FETCH_OBJ);
$proveedor = $conn->query("SELECT * FROM proveedores WHERE deleted = 0 ORDER BY razon_social_empresa_pro ASC")->fetchAll(PDO::FETCH_OBJ);

?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title> Suministro | Orden de Compra</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link href="../assets/styles/dashboard.css" rel="stylesheet">
  </head>
  <body>
<?php
printLayout ('../ico/farma.ico','../index.php', '../../../../index.php','inventario.php','productos.php', 'nuevoProducto.php',
'historialProductos.php','historialOrdenCompra.php','nuevaOrdenCompra.php','listaOrdenesCompra.php','proveedores.php','../../seguridad/controllers/logout.php','../../seguridad/routes/perfil.php',
'../../recursoshumanos/','../index.php','../../contabilidad/','../../citasmedicas/','../../pacientes/','../../seguridad/',7);
?>
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">NUEVA ORDEN DE COMPRA</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar"></span>
            This week
          </button>
        </div>
      </div>
     
    <div class="container mt-5 mb-5">
        <hr class="mb-4">
           

        <form id="formRegistrar" onsubmit="onSubmit(event)" action="../controllers/nuevaOrden.php" method="POST" class="ml-2 mr-2">
            <label class="font-weight-bold">GENERAR UNA NUEVA SOLICITUD PARA ORDEN DE COMPRA</label>
            <hr class="mt-1 mb-4 mr-5">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="fechaPedido">Fecha de pedido de la Orden</label>
                    <input type="text" class="form-control" name="fechaPedido" id="fechaPedido" value="<?php echo $creacion?>" readonly required>
                </div>
                <!-- <div class="form-group col-md-6">
                    <label for="fechaPago">Fecha de pago de la Orden</label>
                    <input type="date" class="form-control" name="fechaPago" id="fechaPago" required>
                </div> -->
            </div>
            <div class="d-flex justify-content-between">
                <label class="font-weight-bold mt-3">Agrega los productos para esta Orden</label>
                <label class="text-danger font-weight-bold mt-3" id="noProduct" style="display:none;">Necesitas almenos agregar un producto para generar esta orden</label>
                <div class="d-flex">
                    <div class="col-md-1"><a data-toggle="modal" href="#informationProducto"><i class="fa fa-plus-circle ml-5 mt-4" aria-hidden="true" style="cursor:pointer; font-size:25px;" title="agregar"></i></a></div>   
                </div>
            </div>
            <hr class="mt-1 mb-4 mr-5">
            <table class="table table-bordered" id="dynamic_field">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th style="width:500px;">Articulo</th>
                        <th>Cantidad</th>
                        <th style="width:150px;">Precio Unitario</th>
                        <th style="width:150px;">Precio total</th>
                        <th style="width:50px;">
                        
                        </th>
                    </tr>
                </thead>
                <tbody >
             
                    
                </tbody>
            </table>
            <div class='modal-footer mt-2'>
            <button id="cancelar" type='button' class="btn btn-light border-secondary" data-dismiss='modal'>Cancelar</button>
            <button id='confirmacion' name='confirmacion' type='submit' class='btn btn-primary font-weight-bold' style="width:200px;">Enviar la Solicitud</button>
            </div> 
        </form>
      </div>
    </main>

    <div class='modal fade' name='informationProducto' id='informationProducto' data-backdrop='static' data-keyboard='false' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabe' aria-hidden='true'>
        <div class='modal-dialog' style="max-width:800px;" >
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='staticBackdropLabel'>Elige un PRODUCTO y su PROVEEDOR (en caso de tener más de uno) para añadirlo a la ORDEN DE COMPRA</h5>
                    <button type='button' id='close-oc' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>               
                <form id="formEditar" method="POST" action="../controllers/updateProduct.php" class="ml-2 mr-2">
                    <label class="font-weight-bold text-danger mt-2">ORDEN DE COMPRA</label>
                    <hr class="mt-1 mb-4 mr-5">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="proveedorOC">Proveedor del Producto</label>
                            <select class="custom-select" name="proveedorOC" id="proveedorOC" required>
                            <option selected disabled value="">Seleccione...</option>
                                <?php
                                foreach ($proveedor as $Proveedores):
                                    ?>
                                <option value="<?php echo $Proveedores->idproveedor;?>"><?php echo utf8_encode($Proveedores->razon_social_empresa_pro).' | Representante: '.utf8_encode($Proveedores->nombre_representante_legal_pro);?></option>
                                <?php 
                                endforeach;
                                ?>  
                            </select>
                        </div>
                        <div class="col-md-6 mb-3" id="productoOC">
                            <label for="producto">PRODUCTO</label>
                            <select class="custom-select" name="" id="" required>
                            <option selected disabled value="">Seleccione...</option>
                            </select>
                        </div>
                    </div>
                    <div id="objeto">
                            <!-- PRODUCTO -->
                       
                    </div>
                </form>                   
                </div>
                <div class='modal-footer mt-2'>
                        <button id="cancelar-oc" type='button' class="btn btn-light border-secondary" data-dismiss='modal'>Cancelar</button>
                        <button id='agregar-oc' name='agregar-oc' type='submit' class='btn btn-primary font-weight-bold' style="width:200px;">Continuar</button>
                </div> 
                </div>
            </div>
        </div>
  </div>
      <div class='modal fade' name='modal-registrar' id='modal-registrar' data-backdrop='static' data-keyboard='false' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabe' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='staticBackdropLabel'>Registrar Producto</h5>
                    <button type='button' id='close-update' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                    ¡Hey!. ¿Estas seguro de eliminar este articulo de tu ORDEN DE COMPRA?.
                </div>
                <div class='modal-footer mt-2'>
                    <button id="btn-cancelar" type='button' class="btn btn-light border-secondary" data-dismiss='modal'>Cancelar</button>
                    <button id='btn-registrar' class='btn btn-primary font-weight-bold' style="width:200px;">Si, de acuerdo</button>
                </div> 
            </div>
        </div>
    </div>
</div>
<script src="../components/scripts/jquery.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="../components/scripts/dashboard.js"></script> 
<script src="../components/scripts/consulta.js"></script> 
<script src="../../recursoshumanos/controllers/validation/validation.js"></script> 
<script>

$(document).ready(function(){
    var i = 1;
    var no = 0;
    $('#agregar-oc').click(function(){
        if($('#proveedorOC').val() == null || $('#producto').val() == null){
            
            document.getElementById("proveedorOC").className = "form-control is-invalid";
            document.getElementById("producto").className = "form-control is-invalid";
        }else{
    
                if($('#cantidad').val()<=0 ){
                    document.getElementById("cantidad").className = "form-control is-invalid";
                }else{
                    i++;
                    no++;
                    var total = $('#cantidad').val()*$('#precio').val();
                    $('#dynamic_field').append(`<tr id="orden${i}">`+
                                    '<th style="width:100px;">'+ 
                                        '<div class="form-group">'+
                                            `<input type="hidden" name="idHasProv[]" value="${$('#producto').val()}">`+
                                            `<input type="text" class="form-control" name="idHas" id="idHas" value="${no}" readonly required>`+
                                        '</div>'+
                                    '</th>'+
                                    '<th style="width:500px;">'+
                                        '<div class="form-group">'+
                                            `<input type="text" class="form-control" value="${$('#producto').val()}" readonly required>`+
                                        '</div>'+
                                    '</th>'+
                                    '<th>'+
                                        '<div class="form-group">'+
                                            `<input type="number" class="form-control" name="cantOc[]" id="cantOc" value="${$('#cantidad').val()}" readonly required>`+
                                        '</div>'+
                                    '</th>'+
                                    '<th style="width:150px;">'+
                                        '<div class="form-group">'+
                                            `<input type="text" class="form-control" name="precioUniOc[]" id="precioUniOc" value="${$('#precio').val()}" readonly required>`+
                                        '</div>'+
                                    '</th>'+
                                    '<th style="width:150px;">'+
                                        '<div class="form-group">'+
                                            `<input type="text" class="form-control" value="${total}" readonly required>`+
                                        '</div>'+
                                    '</th>'+
                                    '<th style="width:50px;">'+
                                    ' <div class="col-md-1">'+
                                        `<i class="fa fa-minus-circle mt-2 btn_remove" data-toggle="modal" data-target="#modal-registrar" name="remove" id="${i}" aria-hidden="true" style="cursor:pointer; font-size:25px;" title="eliminar"></i>`+
                                        '</div>'+
                                    '</th>'+
                                '</tr>');

                    document.getElementById("cantidad").className = "form-control";
                    document.getElementById("proveedorOC").className = "form-control";
                    document.getElementById("producto").className = "form-control";
                    document.getElementById("formEditar").reset();
                    document.getElementById('noProduct').style.display="none";   
                    buscarHasPro(0);
                    $('#informationProducto').modal('hide');
                }
        }
        
    }); 
    
    $(document).on('click', '.btn_remove', function () {
            var id = $(this).attr('id');
            $('#btn-registrar').click(function(){
                $('#orden'+ id).remove();
                $('#modal-registrar').modal('hide');
                no--;
            });  
    });

   onSubmit = (event) => {
    event.preventDefault()
        if(no <= 0){
            document.getElementById('noProduct').style.display="block";    
        }else{
            document.getElementById('formRegistrar').submit();
        } 
    }

    $('#cancelar-oc').click(function(){
        document.getElementById("formEditar").reset();
        buscarProdProve(0);
        buscarHasPro(0);
    });  
    $('#cancelar').click(function(){
        location.href=`../routes/productos.php`;
    });  
    $('#close-oc').click(function(){
        document.getElementById("formEditar").reset();
        buscarProdProve(0);
        buscarHasPro(0);
    });  
});


</script>         
      </body>
</html>


