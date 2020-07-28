<?php
require '../../../../database.php';
require '../components/layout.php';
require '../../recursoshumanos/components/modal.php';
require '../../seguridad/controllers/functions/credenciales.php';

verificarAcceso("../../../../", "modulo_suministros");
$q=$_GET['id'];
$categoria = $conn->query("SELECT * FROM categoria ORDER BY nombre_cate ASC")->fetchAll(PDO::FETCH_OBJ);
$producto = $conn->query("SELECT * FROM productos AS p, categoria AS c WHERE p.idcategoria_pr=c.idcategoria AND idproducto=".$_GET['id'])->fetchAll(PDO::FETCH_OBJ);
$proveedorHasProduct = $conn->query("SELECT * FROM producto_has_proveedor AS has, proveedores AS p, ciudades AS c WHERE (has.idproveedor_has=p.idproveedor AND c.idciudades=p.ciudad_pro) AND idproducto_has=$q AND (has.deleted = 0 AND p.deleted=0)")->fetchAll(PDO::FETCH_OBJ);
$proveedor = $conn->query("SELECT * FROM proveedores WHERE deleted = 0 ORDER BY razon_social_empresa_pro ASC")->fetchAll(PDO::FETCH_OBJ);

?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title> Suministro | Productos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link href="../assets/styles/dashboard.css" rel="stylesheet">
  </head>
  <body>
<?php
printLayout ('../ico/farma.ico','../index.php', '../../../../index.php','inventario.php','productos.php', 'nuevoProducto.php',
'historialProductos.php','historialOrdenCompra.php','nuevaOrdenCompra.php','listaOrdenesCompra.php','proveedores.php','../../seguridad/controllers/logout.php','../../seguridad/routes/perfil.php',
'../../recursoshumanos/','../index.php','../../contabilidad/','../../citasmedicas/','../../pacientes/','../../seguridad/',4);
?>
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 mb-5">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">PROVEEDORES DE ESTE PRODUCTO</h1>
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
      <form id="formDelete" action="../controllers/deleteProductHasProveedor.php" method="post">
            <input type="hidden" name="idProveedor" id="idProveedor">
            <input type="hidden" name="idProducto" id="idProducto" value="<?php echo $_GET['id'];?>">
        </form>
    <div class="d-flex justify-content-end mt-5">
        <span class="mt-2 mr-5 text-info font-weight-bold">
            Agrega un nuevo proveedor para este producto
        </span>
        <a class="text-secondary px-3 mr-5" id="agregar" name="agregar" data-toggle="modal" href="#agregarProveedor" title="Agrega un nuevo provedoor para que se reflejen en las nuevas Ordenes de Compra"><i class="fas fa-plus-circle" style="font-size:30px;"></i></a>
    </div>
    
        <a class="ml-5" href="#" id="btn-editar" title="HABILITA LA EDICIÓN DE ESTE PRODUCTO"><i class="fas fa-toggle-on" id="on" style="font-size:30px;"></i><i class="fas fa-toggle-off" id="off" style="font-size:30px;"></i></a> 
    
    <div class="container mt-5 mb-5">
        <hr class="mb-4">
        <form  name="formEditar" method="POST" action="../controllers/updateProduct.php" class="ml-2 mr-2" enctype="multipart/form-data">
            <label class="font-weight-bold">Producto</label>
                <img src="<?php echo $producto[0]->img_pr?>" id="imgProducto" alt="194x228" class="rounded mx-auto d-block"> 
            <hr class="mt-1 mb-4 mr-5">
            <label class="font-weight-bold">Cambia la imagen del producto si deseas<span class="text-warning">campo no requerido</span></label>
            <div class="form-row">
                <div class="form-group col-md-6 mt-2">
                    <div class="custom-file" style="margin-top:13px;">
                        <input name="img_Product" id="img_Product" type="file" class="form-control mt-2" onchange="return validarExtImg(this);" accept="image/jpg, image/jpeg, image/png" aria-describedby="inputGroupFileAddon01">
                    </div>
                </div>
            </div>
            <hr class="mt-1 mb-4 mr-5">
            <div class="form-row">
            <input type="hidden" name="type" value="1">
            <input type="hidden" name="idproducto" id="idproducto" value="<?php echo $_GET['id']?>">
                <div class="form-group col-md-6">
                    <label for="codigoBarra">Código de barra</label>
                    <input type="text" class="form-control" name="codigoBarra" id="codigoBarra" value="<?php echo $producto[0]->codigo_barra_pr?>" onkeypress="return soloNumeros(event)" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="nombreProducto">Nombre del producto</label>
                    <input type="text" class="form-control" name="nombreProducto" id="nombreProducto" value="<?php echo $producto[0]->nombre_pr?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="fechaElaboracion">Fecha de Elaboracion</label>
                    <input type="date" class="form-control" name="fechaElaboracion" id="fechaElaboracion" value="<?php echo $producto[0]->fecha_elaboracion_pr?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="fechaCaducidad">Fecha de Caducidad</label>
                    <input type="date" class="form-control" name="fechaCaducidad" id="fechaCaducidad" value="<?php echo $producto[0]->fecha_caducidad_pr?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="precio">Precio</label>
                    <input type="text" class="form-control" name="precio" id="precio" maxlength="7" onkeypress="return filterFloat(event,this)" value="<?php echo $producto[0]->precio_unitario_pr?>" required>
                </div>
            </div>
            <label class="font-weight-bold">Agrega información</label>
            <hr class="mt-1 mb-4 mr-5">
            <div class="form-row">
                <div class="col-md-6 mb3">
                    <label for="descripcion">Descripcion del producto</label>
                    <textarea rows="2" class="form-control" name="descripcion" id="descripcion" required> <?php echo $producto[0]->descripcion_pr?></textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationServer14">Categoria</label>
                    <select class="custom-select" name="categoria" id="validationServer08" required>
                    <option selected value="<?php echo $producto[0]->idcategoria_pr?>"><?php echo $producto[0]->nombre_cate?></option>
                    <option disabled value="">Seleccione...</option>
                        <?php
                        foreach ($categoria as $Categorias):
                        ?>
                        <option value="<?php echo $Categorias->idcategoria;?>"><?php echo utf8_encode($Categorias->nombre_cate);?></option>
                        <?php 
                        endforeach;
                        ?>  
                    </select>
                </div>
            </div>                            
            <div class='modal-footer mt-2'>
            <button id='confirmacion' name='confirmacion' type='submit' class='btn btn-primary font-weight-bold' style="width:200px;">Guardar</button>
            </div> 
        </form>
        <hr class="mt-3 mr-5">
            <label class="font-weight-bold text-info mt-4">PROVEEDORES que surten este PRODUCTO</label>
            <hr class="mt-1 mb-4 mr-5">
            <div class="container bootstrap snippet">
                    <div class="table-responsive">
                        <!-- PROJECT TABLE  -->
                            <table class="table colored-header datatable project-list">
                                <thead>
                                    <tr>
                                        <th style="width:100px;">Numero Identificación</th>
                                        <th>Numero Social</th>
                                        <th>Nombre Representante Legal</th>
                                        <th>Ciudad</th>
                                        <th>Dirección</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($proveedorHasProduct as $ProveedorHasProducto):
                                ?>
                                    <tr>
                                        <th style="width:100px;"><?php echo $ProveedorHasProducto->numero_identificacion_pro?></th>
                                        <td><?php echo $ProveedorHasProducto->razon_social_empresa_pro?></td>
                                        <td><?php echo $ProveedorHasProducto->nombre_representante_legal_pro?></td>
                                        <td><?php echo utf8_encode($ProveedorHasProducto->nombre)?></td>
                                        <td><?php echo $ProveedorHasProducto->direccion_pro?></td>
                                        <td>
                                           <a onclick="eliminarProveedor('<?php echo $ProveedorHasProducto->idproveedor?>')" data-toggle="modal" href="#modal-registrar" title="Eliminar a provedor asociado a este producto"><i class="far fa-trash-alt" style="font-size:20px;"></i></a>
                                        </td>
                                    </tr>
                                <?php                                       
                                    endforeach;
                                ?> 
                                </tbody>
                            </table>
                        <!-- END PROJECT TABLE -->
                    </div>
                </div>
            </div>
      </div>
    </main>

    <div class='modal fade' name='agregarProveedor' id='agregarProveedor' data-backdrop='static' data-keyboard='false' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabe' aria-hidden='true'>
                <div class='modal-dialog' style="max-width:800px;">
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='staticBackdropLabel'>Agregale un nuevo PROVEEDOR que te surte este PRODUCTO</h5>
                            <button type='button' id='close-form' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                          <form id="form" method="POST" action="../controllers/insertProductHasProveedor.php" class="ml-2 mr-2">
                              <label class="font-weight-bold">Escoje el nuevo PROVEEDOR para este PRODUCTO</label>
                              <hr class="mt-1 mb-4 mr-5">
                              <div class="form-row mt-3">
                                    <div class="col-md-8 mb-3">
                                        <input type="hidden" name="idProductoinsert" id="idProductoinsert" value="<?php echo $_GET['id'];?>">
                                        <label for="proveedor">Proveedores de Producto Registrados</label>
                                        <select class="custom-select" name="proveedor" id="proveedor" required>
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
                              </div>
                            <div id="objeto">
                             
                            </div>
                                                   
                              <div class='modal-footer mt-2'>
                                <button id="cancelar-form" type='button' class="btn btn-light border-secondary" data-dismiss='modal'>Cancelar</button>
                                <button id='confirmacion' name='confirmacion' type='submit' class='btn btn-primary font-weight-bold' style="width:200px;">Registrar</button>
                              </div> 
                            </form>
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
                    ¡Hey!. ¿Estas seguro de eliminar al PROVEEDOR <span>AA</span> de este producto?. </br> ¿Realmente desea continuar con el proceso?
                </div>
                <div class='modal-footer mt-2'>
                    <button id="btn-cancelar" type='button' class="btn btn-light border-secondary" data-dismiss='modal'>Cancelar</button>
                    <button id='btn-registrar' class='btn btn-primary font-weight-bold' style="width:200px;">Continuar</button>
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
    var edit = 0;
    document.getElementById('off').style.display="block";    
    document.getElementById('on').style.display="none";  
    frm = document.forms['formEditar'];
    for(i=0; ele=frm.elements[i]; i++){
        ele.disabled=true;
    }
      $('#btn-editar').click(function(){
            edit++;
            if(edit==1){
                
                for(i=0; ele=frm.elements[i]; i++){
                    ele.disabled=false;
                }
                document.getElementById('on').style.display="block";    
                document.getElementById('off').style.display="none";    
            }
            if(edit==2){
                
                for(i=0; ele=frm.elements[i]; i++){
                    ele.disabled=true;
                }
                edit=0;
                document.getElementById('off').style.display="block";    
                document.getElementById('on').style.display="none";    
            }
        });  
    $('#btn-registrar').click(function(){
        document.getElementById('formDelete').submit();
    });  
    $('#cancelar-form').click(function(){
        document.getElementById('form').reset();
        buscarProveedores_informacion();
    });  
    $('#close-form').click(function(){
        document.getElementById('form').reset();
        buscarProveedores_informacion();
    });  
  });
  function eliminarProveedor(idProv){
        document.getElementById('idProveedor').value=idProv;
  }
  function validarExtImg(input)
{
    var archivoRuta = input.value;
    var extPermitidas = /(.png|.PNG|.jpg|.JPG|.jpeg|.JPEG)$/i;
    if(!extPermitidas.exec(archivoRuta)){
        alert('Asegurese de haber seleccionado una imagen con extension ".png, .jpg ó .jpeg" ');
        input.value = '';
        return false;
    }
}


</script>         
      </body>
</html>


