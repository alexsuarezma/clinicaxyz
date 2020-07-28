<?php
require '../../../../database.php';
require '../components/layout.php';
require '../../recursoshumanos/components/modal.php';
require '../../seguridad/controllers/functions/credenciales.php';

verificarAcceso("../../../../", "modulo_suministros");

$categoria = $conn->query("SELECT * FROM categoria ORDER BY nombre_cate ASC")->fetchAll(PDO::FETCH_OBJ);
$producto = $conn->query("SELECT * FROM productos AS p, categoria AS c WHERE (p.idcategoria_pr = c.idcategoria) AND deleted = 0 ORDER BY nombre_pr ASC")->fetchAll(PDO::FETCH_OBJ);

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
    <link href="../assets/styles/cardProduct.css" rel="stylesheet">
  </head>
  <body>
<?php
printLayout ('../ico/farma.ico','../index.php', '../../../../index.php','inventario.php','productos.php', 'nuevoProducto.php',
'historialProductos.php','historialOrdenCompra.php','nuevaOrdenCompra.php','listaOrdenesCompra.php','proveedores.php','../../seguridad/controllers/logout.php','../../seguridad/routes/perfil.php',
'../../recursoshumanos/','../index.php','../../contabilidad/','../../citasmedicas/','../../pacientes/','../../seguridad/',3);
?>
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">PRODUCTOS</h1>
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
        <form id="formDelete" action="../controllers/deleteProduct.php" method="post">
            <input type="hidden" name="idProduct" id="idProduct">
        </form>
    <div class="container d-flex flex-wrap">
            <?php
                foreach ($producto as $Productos):
            ?>
        <div class="col-xs-12 col-md-6 bootstrap snippets">
        <!-- product -->
            <div class="product-content product-wrap clearfix">
                <div class="row">
                    <div class="col-md-5 col-sm-12 col-xs-12">
                        <div class="product-image"> 
                            <img src="<?php echo $Productos->img_pr?>" alt="194x228" class="img-thumbnail"> 
                        </div>
                    </div>
                    <div class="col-md-7 col-sm-12 col-xs-12">
                        <div class="product-deatil">
                                <h5 class="name">
                                    <a href="#">
                                        <?php echo $Productos->nombre_pr?> <span><?php echo $Productos->nombre_cate?></span>
                                    </a>
                                    <p class="text-right"><a style="font-size:12px;" href="informacionProducto.php?id=<?php echo $Productos->idproducto?>" title="Ver PROVEEDORES de este PRODUCTO">VER PROVEEDORES <i class="fas fa-arrow-right"></i></a></p>
                                  
                                </h5>
                                <span class="font-weight-bold">Precio Unitario:</span> 
                                <p class="price-container">
                                    <span>$<?php echo $Productos->precio_unitario_pr?></span>
                                </p>
                                <span class="tag1"></span> 
                        </div>
                        <div class="description">
                            <p><?php echo $Productos->descripcion_pr?> </p>
                        </div>
                        <div class="product-info smart-form">
                            <div class="row">
                                <div class="col-md-8 col-sm-6 col-xs-6"> 
                                   <span class="font-weight-bold">Elab:</span> <span><?php echo $Productos->fecha_elaboracion_pr?></span></br>
                                   <span class="font-weight-bold">Caduc:</span> <span><?php echo $Productos->fecha_caducidad_pr?></span>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-6">
                                    <div class="mt-3">
                                        <span class="mr-1"><a onclick="editarProducto('<?php echo $Productos->idproducto?>','<?php echo $Productos->codigo_barra_pr?>','<?php echo $Productos->nombre_pr?>','<?php echo $Productos->descripcion_pr?>','<?php echo $Productos->precio_unitario_pr?>','<?php echo $Productos->fecha_elaboracion_pr?>','<?php echo $Productos->fecha_caducidad_pr?>','<?php echo $Productos->idcategoria?>','<?php echo $Productos->img_pr?>')" data-toggle="modal" href="#informationProducto"><i class="fas fa-info-circle" style="font-size:20px;" title="Editar información del producto"></i></a></span>
                                        <span class="mr-1"><a  onclick="eliminarProducto('<?php echo $Productos->idproducto?>')" data-toggle="modal" href="#modal-delete"><i class="fa fa-trash remove-note" style="color:red; font-size:20px;" title="Eliminar PROOVEDOR"></i></a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end product -->
        </div>
        <?php
            endforeach;
        ?>
</div>
          <hr class="mb-4">
      </div>
    </main>
    <?php 
        printModal('Dar de baja al PRODUCTO','btn-delete','modal-delete','¡Hey!. Estas apunto de DAR DE BAJA a este producto, se ELIMINARAN de la lista para futuras Ordenes de Compra.</br> ¿Realmente desea continuar con el proceso?');
    ?>
    <div class='modal fade' name='informationProducto' id='informationProducto' data-backdrop='static' data-keyboard='false' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabe' aria-hidden='true'>
        <div class='modal-dialog' style="max-width:800px;" >
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='staticBackdropLabel'>Edita la información de este PRODUCTO</h5>
                    <button type='button' id='close' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>               
                <form name="formEditar" method="POST" action="../controllers/updateProduct.php" class="ml-2 mr-2">
                    <label class="font-weight-bold text-danger mt-2">Al editar información del PRODUCTO podria afectar a registros de Ordenes de Compras en los que este asociado </label>
                    <hr class="mt-1 mb-4 mr-5">
                    <ul class="nav nav-pills p-3 bg-white rounded-pill align-items-center">
                    <li class="nav-item ml-auto">
                    <a href="#" id="btn-editar" title="HABILITA LA EDICIÓN DE ESTE PRODUCTO"><i class="fas fa-toggle-on" id="on" style="font-size:30px;"></i><i class="fas fa-toggle-off" id="off" style="font-size:30px;"></i></a> 
                    </li>
                </ul>
                    <input type="hidden" name="idproducto" id="idproducto">
                    <img src="" id="imgProducto" alt="194x228" class="rounded mx-auto d-block"> 
                    <hr class="mt-1 mb-4 mr-5">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="hidden" name="type" value="2">
                            <label for="codigoBarra">Código de barra</label>
                            <input type="text" class="form-control" name="codigoBarra" id="codigoBarra" onkeypress="return soloNumeros(event)" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nombreProducto">Nombre del producto</label>
                            <input type="text" class="form-control" name="nombreProducto" id="nombreProducto" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="fechaElaboracion">Fecha de Elaboracion</label>
                            <input type="date" class="form-control" name="fechaElaboracion" id="fechaElaboracion" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="fechaCaducidad">Fecha de Caducidad</label>
                            <input type="date" class="form-control" name="fechaCaducidad" id="fechaCaducidad" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="precio">Precio</label>
                            <input type="text" class="form-control" name="precio" id="precio" maxlength="7" onkeypress="return filterFloat(event,this)" required>
                        </div>
                    </div>
                    <label class="font-weight-bold">Agrega información</label>
                    <hr class="mt-1 mb-4 mr-5">
                    <div class="form-row">
                        <div class="col-md-6 mb3">
                            <label for="descripcion">Descripcion del producto</label>
                            <textarea rows="2" class="form-control" name="descripcion" id="descripcion" required></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="categoria">Categoria</label>
                            <select class="custom-select" name="categoria" id="categoria" required>
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
                        <button id='confirmacion-update' name='confirmacion-update' type='submit' class='btn btn-primary font-weight-bold' style="width:200px;">Guardar Cambios</button>
                      </div> 
                    </form>
                    <hr class="mt-3 mr-5">
                    <label class="font-weight-bold text-info mt-4">PROVEEDORES que surten este PRODUCTO</label>
                    <hr class="mt-1 mb-4 mr-5">
                    <div id="objeto">
                                <!-- PROVEEDORES DE ESTE PRODUCTO -->
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
<script src="../../seguridad/controllers/validations/validations.js"></script> 
<script src="../../recursoshumanos/controllers/validation/validation.js"></script>    
<script>

  function editarProducto(id,codigoBarra,nombre,descripcion,precioUnitario,fechaElaboracion,fechaCaducidad,idCategoria,img){
    document.getElementById('idproducto').value = id;
    document.getElementById('codigoBarra').value = codigoBarra;
    document.getElementById('nombreProducto').value = nombre;
    document.getElementById('descripcion').value = descripcion;
    document.getElementById('precio').value = precioUnitario;
    document.getElementById('fechaElaboracion').value = fechaElaboracion;
    document.getElementById('fechaCaducidad').value = fechaCaducidad;
    document.getElementById('categoria').value = idCategoria;
    document.getElementById('imgProducto').src = img;
    buscarProveedores(id)
    frm = document.forms['formEditar'];
    for(i=0; ele=frm.elements[i]; i++){
        ele.disabled=true;
    }
    document.getElementById('off').style.display="block";    
    document.getElementById('on').style.display="none";  
  }

function eliminarProducto(idProd){
    document.getElementById('idProduct').value = idProd;
  }

$(document).ready(function(){
 var edit = 0;
      $('#btn-editar').click(function(){
            edit++;
            if(edit==1){
                frm = document.forms['formEditar'];
                for(i=0; ele=frm.elements[i]; i++){
                    ele.disabled=false;
                }
                document.getElementById('on').style.display="block";    
                document.getElementById('off').style.display="none";    
            }
            if(edit==2){
                frm = document.forms['formEditar'];
                for(i=0; ele=frm.elements[i]; i++){
                    ele.disabled=true;
                }
                edit=0;
                document.getElementById('off').style.display="block";    
                document.getElementById('on').style.display="none";    
            }
        });  
        $('#btn-delete').click(function(){
            document.getElementById('formDelete').submit();
        });  
  });


</script>         
      </body>
</html>


