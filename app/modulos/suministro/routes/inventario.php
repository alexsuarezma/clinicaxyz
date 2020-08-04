<?php
require '../../../../database.php';
require '../components/layout.php';
require '../../recursoshumanos/components/modal.php';
require '../../seguridad/controllers/functions/credenciales.php';

verificarAcceso("../../../../", "modulo_suministros");
$inventario = $conn->query("SELECT * FROM inventario_productos AS ip, productos AS pd, categoria AS ca WHERE (ip.idproducto_inventario=pd.idproducto AND pd.idcategoria_pr=ca.idcategoria) ORDER BY nombre_pr ASC")->fetchAll(PDO::FETCH_OBJ);

?>

<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title> Suministro | Inventario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link href="../assets/styles/dashboard.css" rel="stylesheet">
  </head>
  <body>
<?php
printLayout ('../ico/farma.ico','../index.php', '../../../../index.php','inventario.php','productos.php', 'nuevoProducto.php',
'historialProductos.php','historialOrdenCompra.php','nuevaOrdenCompra.php','listaOrdenesCompra.php','proveedores.php','../../seguridad/controllers/logout.php','../../seguridad/routes/perfil.php',
'../../recursoshumanos/','../index.php','../../contabilidad/','../../citasmedicas/','../../pacientes/','../../seguridad/',9);
?>
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">INVENTARIO DE PRODUCTOS</h1>
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
          <!-- PROJECT TABLE  -->
          <table class="table colored-header datatable project-list">
            <thead>
                <tr>
                    <th>Codigo De Barra</th>
                    <th>Producto</th>
                    <th>En Stock</th>
                    <th>Precio Unitario</th>
                    <th>Categoria</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ($inventario as $Inventarios):
            ?>
                <tr>
                    <th><?php echo $Inventarios->codigo_barra_pr?></th>
                    <td><?php echo $Inventarios->nombre_pr?></td>
                    <td><?php echo $Inventarios->stock?></td>
                    <td><?php echo $Inventarios->precio_unitario_pr?></td>
                    <td>
                    <span class="mr-1"><a onclick="informacion('<?php echo $Inventarios->idproducto?>','<?php echo $Inventarios->codigo_barra_pr?>','<?php echo $Inventarios->nombre_pr?>','<?php echo $Inventarios->descripcion_pr?>','<?php echo $Inventarios->precio_unitario_pr?>','<?php echo $Inventarios->fecha_elaboracion_pr?>','<?php echo $Inventarios->fecha_caducidad_pr?>','<?php echo $Inventarios->idcategoria?>','<?php echo $Inventarios->img_pr?>')" data-toggle="modal" href="#informationProducto"><i class="fas fa-info-circle" style="font-size:20px;" title="Visualizar información del producto"></i></a></span>
                    </td>
                </tr>
            <?php 
                endforeach;
            ?> 
            </tbody>
        </table>
      </div>

    </main>

    <div class='modal fade' name='informationProducto' id='informationProducto' data-backdrop='static' data-keyboard='false' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabe' aria-hidden='true'>
        <div class='modal-dialog modal-xl' >
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='staticBackdropLabel'>Información de este PRODUCTO</h5>
                    <button type='button' id='close' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>               
                    <div class="row">
                      <div class="col">
                          <!-- <form name="formEditar" method="POST" action="../controllers/updatePvp.php" class="ml-2 mr-2">
                              <label class="font-weight-bold text-danger mt-2">Si deseas, solo puedes editar el precio de venta al público PVP.</label>
                              <hr class="mt-1 mr-5">
                              <ul class="nav nav-pills p-3 bg-white rounded-pill align-items-center">
                                  <li class="nav-item ml-auto">
                                      <a href="#" id="btn-editar" title="HABILITA LA EDICIÓN DE ESTE PRODUCTO"><i class="fas fa-toggle-on" id="on" style="font-size:30px;"></i><i class="fas fa-toggle-off" id="off" style="font-size:30px;"></i></a> 
                                  </li>
                              </ul>
                              <label class="font-weight-bold">Información de venta</label>
                              <hr class="mt-1 mr-5">
                              <div class="form-row">  
                                  <div class="col-md-6 mb-3">
                                      <input type="hidden" name="idproductoInv" id="idproductoInv">
                                      <label for="precioPvp">Precio PVP</label>
                                      <input type="text" class="form-control" name="precioPvp" id="precioPvp" maxlength="7" onkeypress="return filterFloat(event,this)" disabled required>
                                  </div>
                              </div>
                              <div class='modal-footer mt-2'>
                                  <button id='confirmacion-update' name='confirmacion-update' type='submit' class='btn btn-primary font-weight-bold' style="width:200px;">Guardar Cambios</button>
                              </div> 
                          </form> -->
                          <hr class="mt-5 mr-5">
                          <form class="ml-2 mr-2">
                              <img src="" id="imgProducto" alt="194x228" class="rounded mx-auto d-block"> 
                              <hr class="mt-1 mb-4 mr-5">
                              <div class="form-row">
                                  <div class="form-group col-md-6">
                                      <label for="codigoBarra">Código de barra</label>
                                      <input type="text" class="form-control" id="codigoBarra" readonly>
                                  </div>
                                  <div class="form-group col-md-6">
                                      <label for="nombreProducto">Nombre del producto</label>
                                      <input type="text" class="form-control" id="nombreProducto" readonly>
                                  </div>
                              </div>
                              <div class="form-row">
                                  <div class="form-group col-md-4">
                                      <label for="fechaElaboracion">Fecha de Elaboracion</label>
                                      <input type="text" class="form-control" id="fechaElaboracion" readonly>
                                  </div>
                                  <div class="form-group col-md-4">
                                      <label for="fechaCaducidad">Fecha de Caducidad</label>
                                      <input type="text" class="form-control" id="fechaCaducidad" readonly>
                                  </div>
                                  <div class="form-group col-md-4">
                                      <label for="precio">Precio Unid.</label>
                                      <input type="text" class="form-control" id="precio" readonly>
                                  </div>
                              </div>
                              <label class="font-weight-bold">Información adicional del producto</label>
                              <hr class="mt-1 mb-4 mr-5">
                              <div class="form-row">
                                  <div class="col-md-6 mb3">
                                      <label for="descripcion">Descripcion del producto</label>
                                      <input type="text" class="form-control" id="descripcion" readonly>
                                  </div>
                                  <div class="col-md-6 mb-3">
                                      <label for="categoria">Categoria</label>
                                      <input type="text" class="form-control" id="categoria" readonly>
                                      </div>
                                  </div>
                              </form>
                              <hr class="mt-3 mr-5">
                              
                          </div>
                          <div class="col">
                          <label class="font-weight-bold text-info mt-4">PROVEEDORES que surten este PRODUCTO</label>
                          <div id="provedores" style="width:500px; height:300px; overflow: scroll; overflow-x: hidden;">
                            
                          </div>
                          <label class="font-weight-bold text-info mt-4">Historial de Registros en Inventario Ord. Compra</label>
                          <div id="ordenesCompra" style="width:500px; height:300px; overflow: scroll; overflow-x: hidden;">
                             
                          </div>
                      </div>
                  </div>        
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
<script>
  
  function informacion(id,codigoBarra,nombre,descripcion,precioUnitario,fechaElaboracion,fechaCaducidad,idCategoria,img){
    // document.getElementById('idproductoInv').value = id;
    document.getElementById('codigoBarra').value = codigoBarra;
    document.getElementById('nombreProducto').value = nombre;
    document.getElementById('descripcion').value = descripcion;
    document.getElementById('precio').value = precioUnitario;
    document.getElementById('fechaElaboracion').value = fechaElaboracion;
    document.getElementById('fechaCaducidad').value = fechaCaducidad;
    document.getElementById('categoria').value = idCategoria;
    document.getElementById('imgProducto').src = img;
    inventarioProv(id);
    inventarioOrdenes(id);
  }
</script>
      </body>
</html>
