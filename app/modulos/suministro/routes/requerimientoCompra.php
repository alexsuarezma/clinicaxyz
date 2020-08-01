<?php
require '../../../../database.php';
require '../components/layout.php';
require '../../recursoshumanos/components/modal.php';
require '../../seguridad/controllers/functions/credenciales.php';

verificarAcceso("../../../../", "modulo_suministros");
$orden = $conn->query("SELECT * FROM orden_compra as o, detalle_orden_compra AS de, producto_has_proveedor AS has, proveedores AS pr, productos AS pd WHERE (de.id_orden_compra_dt =o.id_orden_compra AND de.id_prod_has_prov=has.idproducto_has_proveedor AND has.idproveedor_has=pr.idproveedor AND has.idproducto_has=pd.idproducto) AND id_orden_compra=".$_GET['id'])->fetchAll(PDO::FETCH_OBJ);

?>

<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title> Suministro | Requerimiento de Compra</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link href="../assets/styles/dashboard.css" rel="stylesheet">
  </head>
  <body>
<?php
printLayout ('../ico/farma.ico','../index.php', '../../../../index.php','inventario.php','productos.php', 'nuevoProducto.php',
'historialProductos.php','historialOrdenCompra.php','nuevaOrdenCompra.php','listaOrdenesCompra.php','proveedores.php','../../seguridad/controllers/logout.php','../../seguridad/routes/perfil.php',
'../../recursoshumanos/','../index.php','../../contabilidad/','../../citasmedicas/','../../pacientes/','../../seguridad/',6);
?>
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">INFORMACION DE ORDEN DE COMPRA GENERADA |ÁREA DE SUMINISTROS|</h1>
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
    <form id="formRegistrar" action="../controllers/registrarInventario.php" method="POST" class="ml-2 mr-2">
            <div class="">
            
                <p style="font-size:15px;" class="text-break font-weight-bold badge-pill badge-info">
                <i class="fas fa-info-circle mr-5" style="font-size:28px;"></i>
                    Departamento de suministro solicito una Orden de Requerimiento, necesitas generar una acción en ella.
                </p>
         
            </div>
            <label class="font-weight-bold">INFORMACION SOLICITUD PARA ORDEN DE COMPRA</label>
            <hr class="mt-1 mb-4 mr-5">
            <div class="form-row">
                <div class="form-group col-md-6">
                <input type="hidden" name="idOrden" value="<?php echo $orden[0]->id_orden_compra?>">
                    <label for="fechaPedido">Fecha de pedido de la Orden</label>
                    <input type="text" class="form-control" name="fechaPedido" id="fechaPedido" value="<?php echo $orden[0]->fecha_pedido?>" readonly required>
                </div>
                <div class="form-group col-md-6">
                    <label for="fechaPago">Fecha de pago de la Orden</label>
                    <input type="input" class="form-control" name="fechaPago" value="<?php echo $orden[0]->fecha_pago?>" id="fechaPago" readonly required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="estadoPedido">Estado <span class="text-warning font-weight-bold" style="font-size:12px;">Porfavor Seleciona un estado para concluir el proceso de esta orden de requerimiento</span> </label>
                    <select class="custom-select" name="estadoPedido" id="estadoPedido" required>
                    <option selected disabled value="<?php echo $orden[0]->estado?>">En espera</option>
                    <option disabled value="">Seleccione...</option>
                        <option value="aceptado">Aceptar</option>
                        <option value="rechazado">Denegado</option>
                    </select>
                </div>
            </div>
            <div class="form-row" id="comentarioBox" style="display:none;">
                <div class="col-md-6 mb3">
                    <label for="comentario">Porfavor, agrega un comentario </label>
                    <textarea rows="2" class="form-control" name="comentario" id="comentario" disabled required></textarea>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <label class="font-weight-bold mt-3">Productos de esta Orden</label>
            </div>
            <hr class="mt-1 mb-4 mr-5">
            <table class="table table-bordered" id="dynamic_field">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th style="width:250px;">Proveedor</th>
                        <th style="width:250px;">Articulo</th>
                        <th>Cantidad</th>
                        <th style="width:150px;">Precio Unitario</th>
                        <th style="width:150px;">Precio total</th>
                        <th style="width:50px;">
                        
                        </th>
                    </tr>
                </thead>
                <tbody >
                <?php
                    $count=0;
                    $total=0;
                    $cantidad=0;
                     foreach ($orden as $ordenDetalle): 
                            $count++;                   
                ?>
                    <tr>
                        <th style="width:70px;"> 
                            <div class="form-group">
                                <input type="text" class="form-control" name="idHas" id="idHas" value="<?php echo $count?>" readonly required>
                            </div>
                        </th>
                        <th style="width:250px;">
                            <div class="form-group">
                                <input type="text" class="form-control" value="<?php echo $ordenDetalle->razon_social_empresa_pro?>" readonly required>
                            </div>
                        </th>
                        <th style="width:250px;">
                            <div class="form-group">
                                <input type="text" class="form-control" value="<?php echo $ordenDetalle->nombre_pr?>" readonly required>
                            </div>
                        </th>
                        <th>
                            <div class="form-group">
                                <input type="number" class="form-control" name="cantOc[]" id="cantOc" value="<?php echo $ordenDetalle->cantidad?>" readonly required>
                            </div>
                        </th>
                        <th style="width:150px;">
                            <div class="form-group">
                                <input type="text" class="form-control" name="precioUniOc[]" id="precioUniOc" value="<?php echo $ordenDetalle->precio_unitario?>" readonly required>
                            </div>
                        </th>
                        <th style="width:150px;">
                            <div class="form-group">
                                <input type="text" class="form-control" value="<?php echo ($ordenDetalle->cantidad * $ordenDetalle->precio_unitario)?>" readonly required>
                            </div>
                        </th>
                    </tr>
                <?php 
                        $cantidad += $ordenDetalle->cantidad;
                        $total += $ordenDetalle->cantidad * $ordenDetalle->precio_unitario;
                    endforeach;
                ?>
                 <tr>
                        <th></th>
                        <th style="width:250px;"></th>
                        <th style="width:250px;"></th>
                        <th><?php echo ($cantidad)?></th>
                        <th style="width:150px;"></th>
                        <th style="width:150px;">Precio total</th>
                        <th style="width:50px;">
                            <?php echo ($total)?>
                        </th>
                    </tr> 
                </tbody>
            </table>
                <div class='modal-footer mt-2'>
                    <a id="cancelar" href="historialOrdenCompra.php" type='button' class="btn btn-light border-secondary" data-dismiss='modal'>Cancelar</a>
                    <button id='confirmacion' name='confirmacion' type='submit' class='btn btn-primary font-weight-bold' style="width:200px;">Enviar Respuesta</button>
                </div> 

        </form>
      </div>

    </main>
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
                    ¡Hey!. Estas apunto de enviar la respuesta a esta Orden de Requerimiento. ¿Realmente deseas continuar con el proceso?.
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
    
    $(document).on('change', '#estadoPedido', function() {
            if ($(this).val() == "rechazado") {
                $("#comentarioBox").css("display", "block")  
                document.getElementById('comentario').disabled=false;    
            }else{
                $("#comentarioBox").css("display", "none")
                document.getElementById('comentario').disabled=true;    
            }
    });

</script>
      </body>
</html>


