<?php
require '../../../../database.php';
require '../components/layout.php';
require '../../recursoshumanos/components/modal.php';
require '../../seguridad/controllers/functions/credenciales.php';

verificarAcceso("../../../../", "modulo_suministros");

$categoria = $conn->query("SELECT * FROM categoria ORDER BY nombre_cate ASC")->fetchAll(PDO::FETCH_OBJ);
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
'historialProductos.php','#','nuevaOrdenCompra.php','listaOrdenesCompra.php','proveedores.php','../../seguridad/controllers/logout.php','../../seguridad/routes/perfil.php',
'../../recursoshumanos/','../index.php','../../contabilidad/','../../citasmedicas/','../../pacientes/','../../seguridad/',4);
?>
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">NUEVO PRODUCTOS</h1>
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
           

        <form id="formRegistrar" method="POST" onsubmit="onSubmit(event)" action="../controllers/insertProduct.php" class="ml-2 mr-2" enctype="multipart/form-data">
            <label class="font-weight-bold">Nuevo Producto</label>
            <hr class="mt-1 mb-4 mr-5">
            <label class="font-weight-bold">Selecciona una imagen del producto <span class="text-warning">campo no requerido</span></label>
            <div class="form-row">
                <div class="form-group col-md-6 mt-2">
                    <div class="custom-file" style="margin-top:13px;">
                        <input name="img_Product" id="img_Product" type="file" class="form-control mt-2" onchange="return validarExtImg(this);" accept="image/jpg, image/jpeg, image/png" aria-describedby="inputGroupFileAddon01">
                    </div>
                    <div class="invalid-feedback">
                        Estas asignandole la misma credencial.
                    </div>
                </div>
            </div>
            <hr class="mt-1 mb-4 mr-5">
            <div class="form-row">
                <div class="form-group col-md-6">
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
                    <label for="validationServer14">Categoria</label>
                    <select class="custom-select" name="categoria" id="validationServer08" required>
                    <option selected disabled value="">Seleccione...</option>
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
            <div class="form-row mt-3">
                <div class="col-md-6 mb-3">
                    <label for="proveedor">Proveedor del Producto</label>
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
                            
            <div class='modal-footer mt-2'>
            <button id="cancelar" type='button' class="btn btn-light border-secondary" data-dismiss='modal'>Cancelar</button>
            <button id='confirmacion' name='confirmacion' type='submit' class='btn btn-primary font-weight-bold' style="width:200px;">Registrar</button>
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
                    ¡Hey!. ¿Estas seguro de registrar este nuevo producto?. ¿Realmente desea continuar con el proceso?
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
<script src="../../recursoshumanos/controllers/validation/validation.js"></script> 
<script>
  onSubmit = (event) => {
    event.preventDefault()
        $('#modal-registrar').modal('show');
            $('#btn-registrar').click(function(){
                document.getElementById('formRegistrar').submit();
            });  
            $('#btn-cancelar').click(function(){
                document.getElementById("formRegistrar").reset();
                location.href=`productos.php`;
            });  
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


