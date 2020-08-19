<?php
require '../../../../database.php';
require '../components/layout.php';
require '../../recursoshumanos/components/modal.php';
require '../../seguridad/controllers/functions/credenciales.php';

verificarAcceso("../../../../", "modulo_suministros");
$ciudades = $conn->query("SELECT * FROM ciudades ORDER BY nombre ASC")->fetchAll(PDO::FETCH_OBJ);
$proveedor = $conn->query("SELECT * FROM proveedores WHERE deleted = 1 ORDER BY razon_social_empresa_pro ASC")->fetchAll(PDO::FETCH_OBJ);

?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title> Suministro | Proveedores Eliminados</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link href="../assets/styles/dashboard.css" rel="stylesheet">
    <link href="../assets/styles/cardProvedores.css" rel="stylesheet">
  </head>
  <body>
<?php
    printLayout ('../ico/farma.ico','../index.php', '../../../../index.php','inventario.php','productos.php', 'nuevoProducto.php',
    'historialProductos.php','historialOrdenCompra.php','nuevaOrdenCompra.php','listaOrdenesCompra.php','proveedores.php','historialDistribucion.php','../../seguridad/controllers/logout.php','../../seguridad/routes/perfil.php',
    '../../recursoshumanos/','../index.php','../../contabilidad/','../../citasmedicas/','../../pacientes/','../../seguridad/',2);
?>
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">HISTORIAL DE PROVEEDORES DE PRODUCTOS |ELIMINADOS|</h1>
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
           
<div class="page-content container note-has-grid">
    <div class="tab-content bg-transparent">
        <form id="formDelete" action="../controllers/publicarProveedor.php" method="post">
            <input type="hidden" name="idProveedor" id="idProveedor">
        </form>
        <div id="note-full-container" class="note-has-grid row">
            <?php
                foreach ($proveedor as $Proveedores):
            ?>
                <div class="col-md-4 single-note-item all-category note-social">
                    <div class="card card-body" style="max-width:400px;">
                        <span class="side-stick"></span>
                        <h5 class="note-title mb-0"><?php echo $Proveedores->razon_social_empresa_pro?></h5>
                        <p class="note-date font-12 text-muted"><?php echo $Proveedores->numero_identificacion_pro?></br> <?php echo $Proveedores->nombre_representante_legal_pro?></p>
                        <?php if(verificarAccion($conn, "modulo_suministros", "insertar") == true):?>
                            <p class="text-right" style="font-size:14px;"><button type="button" style="width:80px; font-size:10px;" class="btn btn-light" data-toggle="modal" data-target="#modal-delete" onclick="eliminarProveedor('<?php echo $Proveedores->idproveedor?>')">PUBLICAR DE NUEVO</button></p>
                        <?php endif;?>
                        
                        <div class="note-content">
                            <p class="note-inner-content text-muted" data-notecontent="Blandit tempus porttitor aasfs. Integer posuere erat a ante venenatis.">
                                <?php echo $Proveedores->direccion_pro?>. <?php echo $Proveedores->ciudad_pro?>
                            </p>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="mr-1"><a onclick="editarProveedor('<?php echo $Proveedores->idproveedor?>','<?php echo $Proveedores->numero_identificacion_pro?>','<?php echo $Proveedores->razon_social_empresa_pro?>','<?php echo $Proveedores->nombre_representante_legal_pro?>','<?php echo $Proveedores->direccion_pro?>','<?php echo $Proveedores->ciudad_pro?>','<?php echo $Proveedores->telefono_1_pro?>','<?php echo $Proveedores->telefono_2_pro?>','<?php echo $Proveedores->email_1_pro?>','<?php echo $Proveedores->email_2_pro?>')" data-toggle="modal" href="#informationProveedor"><i class="fas fa-info-circle text-info" style="font-size:20px;" title="Ver información del PROVEEDOR"></i></a></span>
                        </div>
                    </div>
                </div>
            <?php 
                endforeach;
            ?>  

                </div>
            </div>
        </div>
    </div>
</div>
          <hr class="mb-4">
           
            
      </div>
    </main>
    <?php 
        printModal('Publicar de nuevo este PROVEEDOR','btn-delete','modal-delete','Estas seguro que quieres publicar de nuevo a este PROVEEDOR para futuras Ordenes de Compra.</br> ¿Realmente desea continuar con el proceso?');
    ?>
    <div class='modal fade' name='informationProveedor' id='informationProveedor' data-backdrop='static' data-keyboard='false' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabe' aria-hidden='true'>
        <div class='modal-dialog' style="max-width:800px;" >
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='staticBackdropLabel'>Información de este PROVEEDOR</h5>
                    <button type='button' id='close' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                    <form class="ml-2 mr-2">
                    <label class="font-weight-bold text-danger mt-2">Informacíon de PROVEEDOR fuera de catalogo.</label>
                      <hr class="mt-1 mb-4 mr-5">
                      <div class="form-row">
                            <input type="hidden" name="idProveedorEdit" id="idProveedorEdit">
                            <div class="form-group col-md-6">
                                <label for="numeroIdentificacionEdit">Numero identificación</label>
                                <input type="text" class="form-control" name="numeroIdentificacionEdit" id="numeroIdentificacionEdit" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="razonSocialEdit">Razon social de la empresa</label>
                                <input type="text" class="form-control" name="razonSocialEdit" id="razonSocialEdit" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="direccionProveedorEdit">Dirección</label>
                                <input type="text" class="form-control" name="direccionProveedorEdit" id="direccionProveedorEdit" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                            <label for="validationServer14">Ciudad</label>
                            <input class="form-control" name="ciudadEdit" id="ciudadEdit" readonly>
                        </div>
                        </div>
                        <label class="font-weight-bold">Agrega información de contacto</label>
                        <hr class="mt-1 mb-4 mr-5">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nombreRepresentanteEdit">Nombre de representante legal</label>
                                <input type="text" class="form-control" name="nombreRepresentanteEdit" id="nombreRepresentanteEdit" onkeypress="return soloLetras(event)" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="telefonoUnoEdit">Primer telefono de contacto</label>
                                <input type="text" class="form-control" name="telefonoUnoEdit" id="telefonoUnoEdit" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="telefonoDosEdit">Segundo telefono de contacto</label>
                                <input type="text" class="form-control" name="telefonoDosEdit" id="telefonoDosEdit" onchange="validarTelefono(this);" onkeypress="return soloNumeros(event)" maxlength="7" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                            <label for="emailUnoEdit">Primer E-mail de contacto</label>
                            <input type="email" class="form-control" name="emailUnoEdit" id="emailUnoEdit" onchange="validarEmail(this);" readonly>
                            <div class="invalid-feedback">
                                Correo electrónico inválido.
                            </div>
                            <div class="valid-feedback">
                                Correo electrónico válido.
                            </div>
                            </div>
                            <div class="form-group col-md-6">
                            <label for="emailDosEdit">Segundo E-mail de contacto</label>
                            <input type="email" class="form-control" name="emailDosEdit" id="emailDosEdit" onchange="validarEmail(this);" readonly>
                            <div class="invalid-feedback">
                                Correo electrónico inválido.
                            </div>
                            <div class="valid-feedback">
                                Correo electrónico válido.
                            </div>
                            </div>
                        </div>  
                    </form>
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
<script>
  function editarProveedor(id,identificador,razonSocial,representante,direccion,ciudad,telefono1,telefono2,email1,email2){
    document.getElementById('idProveedorEdit').value = id;
    document.getElementById('numeroIdentificacionEdit').value = identificador;
    document.getElementById('razonSocialEdit').value = razonSocial;
    document.getElementById('nombreRepresentanteEdit').value = representante;
    document.getElementById('direccionProveedorEdit').value = direccion;
    document.getElementById('telefonoUnoEdit').value = telefono1;
    document.getElementById('telefonoDosEdit').value = telefono2;
    document.getElementById('emailUnoEdit').value = email1;
    document.getElementById('emailDosEdit').value = email2;
    document.getElementById('ciudadEdit').value = ciudad;
  }

  function eliminarProveedor(idProv){
    document.getElementById('idProveedor').value = idProv;
  }

  $(document).ready(function(){
       $('#btn-delete').click(function(){
            document.getElementById('formDelete').submit();
        });  
  });



</script>         
      </body>
</html>

