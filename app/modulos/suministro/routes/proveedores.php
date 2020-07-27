<?php
require '../../../../database.php';
require '../components/layout.php';
require '../../recursoshumanos/components/modal.php';
require '../../seguridad/controllers/functions/credenciales.php';

verificarAcceso("../../../../", "modulo_suministros");
$ciudades = $conn->query("SELECT * FROM ciudades ORDER BY nombre ASC")->fetchAll(PDO::FETCH_OBJ);
$proveedor = $conn->query("SELECT * FROM proveedores WHERE deleted = 0 ORDER BY razon_social_empresa_pro ASC")->fetchAll(PDO::FETCH_OBJ);

?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title> Suministro | Proveedores</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link href="../assets/styles/dashboard.css" rel="stylesheet">
  </head>
  <style>

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #DCDCDC;
            background-clip: border-box;
            border: 0 solid transparent;
            border-radius: 0;
        }
        .card {
            margin-bottom: 30px;
        }
        .card-body {
            flex: 1 1 auto;
            padding: 1.57rem;
        }

        .note-has-grid .nav-link {
            padding: .5rem
        }

        .note-has-grid .single-note-item .card {
            border-radius: 10px
        }

        .note-has-grid .single-note-item .favourite-note {
            cursor: pointer
        }

        .note-has-grid .single-note-item .side-stick {
            position: absolute;
            width: 3px;
            height: 35px;
            left: 0;
            background-color: rgba(82, 95, 127, .5)
        }

        .note-has-grid .single-note-item .category-dropdown.dropdown-toggle:after {
            display: none
        }

        .note-has-grid .single-note-item .category [class*=category-] {
            height: 15px;
            width: 15px;
            display: none
        }

        .note-has-grid .single-note-item .category [class*=category-]::after {
            content: "\f0d7";
            font: normal normal normal 14px/1 FontAwesome;
            font-size: 12px;
            color: #fff;
            position: absolute
        }

        .note-has-grid .single-note-item .category .category-business {
            background-color: rgba(44, 208, 126, .5);
            border: 2px solid #2cd07e
        }

        .note-has-grid .single-note-item .category .category-social {
            background-color: rgba(44, 171, 227, .5);
            border: 2px solid #2cabe3
        }

        .note-has-grid .single-note-item .category .category-important {
            background-color: rgba(255, 80, 80, .5);
            border: 2px solid #ff5050
        }

        .note-has-grid .single-note-item.all-category .point {
            color: rgba(82, 95, 127, .5)
        }

        .note-has-grid .single-note-item.note-business .point {
            color: rgba(44, 208, 126, .5)
        }

        .note-has-grid .single-note-item.note-business .side-stick {
            background-color: rgba(44, 208, 126, .5)
        }

        .note-has-grid .single-note-item.note-business .category .category-business {
            display: inline-block
        }

        .note-has-grid .single-note-item.note-favourite .favourite-note {
            color: #ffc107
        }

        .note-has-grid .single-note-item.note-social .point {
            color: rgba(44, 171, 227, .5)
        }

        .note-has-grid .single-note-item.note-social .side-stick {
            background-color: rgba(44, 171, 227, .5)
        }

        .note-has-grid .single-note-item.note-social .category .category-social {
            display: inline-block
        }

        .note-has-grid .single-note-item.note-important .point {
            color: rgba(255, 80, 80, .5)
        }

        .note-has-grid .single-note-item.note-important .side-stick {
            background-color: rgba(255, 80, 80, .5)
        }

   



        @media (max-width:767.98px) {
            .note-has-grid .single-note-item {
                max-width: 100%
            }
        }

        @media (max-width:991.98px) {
            .note-has-grid .single-note-item {
                max-width: 216px
            }
        }
  </style>
  <body>
<?php
    printLayout ('../ico/farma.ico','../index.php', '../../../../index.php','inventario.php','productos.php', 'nuevoProducto.php',
    'historialProductos.php','#','nuevaOrdenCompra.php','listaOrdenesCompra.php','proveedores.php','../../seguridad/controllers/logout.php','../../seguridad/routes/perfil.php',
    '../../recursoshumanos/','../index.php','../../contabilidad/','../../citasmedicas/','../../pacientes/','../../seguridad/',2);
?>
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">PROVEEDORES DE PRODUCTOS</h1>
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
    <ul class="nav nav-pills p-3 bg-white mb-3 rounded-pill align-items-center">
        <li class="nav-item ml-auto">
            <a href="#" class="text-secondary d-flex align-items-center px-3" id="agregar" name="agregar" title="Agrega un nuevo provedoor para que se reflejen en las nuevas Ordenes de Compra"><i class="fas fa-plus-circle" style="font-size:30px;"></i></a>
        </li>
    </ul>
    <div class="tab-content bg-transparent">
        <form id="formDelete" action="../controllers/deleteProveedor.php" method="post">
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
                        
                        <div class="note-content">
                            <p class="note-inner-content text-muted" data-notecontent="Blandit tempus porttitor aasfs. Integer posuere erat a ante venenatis.">
                                <?php echo $Proveedores->direccion_pro?>. <?php echo $Proveedores->ciudad_pro?>
                            </p>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="mr-1"><a onclick="editarProveedor('<?php echo $Proveedores->idproveedor?>','<?php echo $Proveedores->numero_identificacion_pro?>','<?php echo $Proveedores->razon_social_empresa_pro?>','<?php echo $Proveedores->nombre_representante_legal_pro?>','<?php echo $Proveedores->direccion_pro?>','<?php echo $Proveedores->ciudad_pro?>','<?php echo $Proveedores->telefono_1_pro?>','<?php echo $Proveedores->telefono_2_pro?>','<?php echo $Proveedores->email_1_pro?>','<?php echo $Proveedores->email_2_pro?>')" data-toggle="modal" href="#informationProveedor"><i class="fas fa-edit text-info" style="font-size:20px;" title="Ver información del PROVEEDOR"></i></a></span>
                            <span class="mr-1"><a  onclick="eliminarProveedor('<?php echo $Proveedores->idproveedor?>')" data-toggle="modal" href="#modal-delete"><i class="fa fa-trash remove-note" style="color:red; font-size:20px;" title="Eliminar PROOVEDOR"></i></a></span>
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
           
            <div class='modal fade' name='agregarCredencial' id='agregarCredencial' data-backdrop='static' data-keyboard='false' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabe' aria-hidden='true'>
                <div class='modal-dialog' style="max-width:800px;">
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='staticBackdropLabel'>Registra un nuevo PROVEEDOR</h5>
                            <button type='button' id='close' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                          <form id="form" method="POST" action="../controllers/insertProveedor.php" class="ml-2 mr-2">
                              <label class="font-weight-bold">Nuevo Proveedor</label>
                              <hr class="mt-1 mb-4 mr-5">
                              <div class="form-row">
                                  <div class="form-group col-md-6">
                                      <label for="numeroIdentificacion">Numero identificación</label>
                                      <input type="text" class="form-control" name="numeroIdentificacion" id="numeroIdentificacion"onkeypress="return soloNumeros(event)" onchange="verificarCedula(this);" maxlength="10" required>
                                  </div>
                                  <div class="form-group col-md-6">
                                      <label for="razonSocial">Razon social de la empresa</label>
                                      <input type="text" class="form-control" name="razonSocial" id="razonSocial" required>
                                  </div>
                              </div>
                              <div class="form-row">
                                  <div class="form-group col-md-6">
                                      <label for="direccionProveedor">Dirección</label>
                                      <input type="text" class="form-control" name="direccionProveedor" id="direccionProveedor" required>
                                  </div>
                                  <div class="col-md-6 mb-3">
                                    <label for="validationServer14">Ciudad</label>
                                    <select class="custom-select" name="ciudad" id="validationServer08" required>
                                    <option selected disabled value="">Seleccione...</option>
                                        <?php
                                        foreach ($ciudades as $ciudadesAspirante):
                                        ?>
                                        <option value="<?php echo $ciudadesAspirante->idciudades;?>"><?php echo utf8_encode($ciudadesAspirante->nombre);?></option>
                                        <?php 
                                        endforeach;
                                        ?>  
                                    </select>
                                </div>
                              </div>
                              <label class="font-weight-bold">Agrega información de contacto</label>
                              <hr class="mt-1 mb-4 mr-5">
                              <div class="form-row">
                                  <div class="form-group col-md-6">
                                      <label for="nombreRepresentante">Nombre de representante legal</label>
                                      <input type="text" class="form-control" name="nombreRepresentante" id="nombreRepresentante" onkeypress="return soloLetras(event)" required>
                                  </div>
                              </div>
                              <div class="form-row">
                                  <div class="form-group col-md-6">
                                      <label for="telefonoUno">Primer telefono de contacto</label>
                                      <input type="text" class="form-control" name="telefonoUno" id="telefonoUno" onchange="validarTelefono(this);" onkeypress="return soloNumeros(event)" maxlength="7" required>
                                  </div>
                                  <div class="form-group col-md-6">
                                      <label for="telefonoDos">Segundo telefono de contacto</label>
                                      <input type="text" class="form-control" name="telefonoDos" id="telefonoDos" onchange="validarTelefono(this);" onkeypress="return soloNumeros(event)" maxlength="7" required>
                                  </div>
                              </div>
                              <div class="form-row">
                                  <div class="form-group col-md-6">
                                    <label for="emailUno">Primer E-mail de contacto</label>
                                    <input type="email" class="form-control" name="emailUno" id="emailUno" onchange="validarEmail(this);" required>
                                    <div class="invalid-feedback">
                                        Correo electrónico inválido.
                                    </div>
                                    <div class="valid-feedback">
                                        Correo electrónico válido.
                                    </div>
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="emailDos">Segundo E-mail de contacto</label>
                                    <input type="email" class="form-control" name="emailDos" id="emailDos" onchange="validarEmail(this);" required>
                                    <div class="invalid-feedback">
                                        Correo electrónico inválido.
                                    </div>
                                    <div class="valid-feedback">
                                        Correo electrónico válido.
                                    </div>
                                  </div>
                              </div>                        
                              <div class='modal-footer mt-2'>
                                <button id="cancelar" type='button' class="btn btn-light border-secondary" data-dismiss='modal'>Cancelar</button>
                                <button id='confirmacion' name='confirmacion' type='submit' class='btn btn-primary font-weight-bold' style="width:200px;">Registrar</button>
                              </div> 
                            </form>
                        </div>
                    </div>
                </div>
            </div>
      </div>
    </main>
    <?php 
        printModal('Dar de baja al PROVEEDOR','btn-delete','modal-delete','¡Hey!. Estas apunto de DAR DE BAJA a este PROVEEDOR, estas apunto de ELIMINARLO de la lista en nuevas Ordenes de Compra. ¿Realmente desea continuar con el proceso?');
    ?>
    <div class='modal fade' name='informationProveedor' id='informationProveedor' data-backdrop='static' data-keyboard='false' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabe' aria-hidden='true'>
        <div class='modal-dialog' style="max-width:800px;" >
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='staticBackdropLabel'>Edita la información de este PROVEEDOR</h5>
                    <button type='button' id='close' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                    <form method="POST" action="../controllers/updateProveedor.php" class="ml-2 mr-2">
                    <label class="font-weight-bold text-danger mt-2">Si editas la información de este PROVEEDOR se reflejara en los registros de Ordenes de Compras en los que este asociado </label>
                      <hr class="mt-1 mb-4 mr-5">
                      <div class="form-row">
                            <input type="hidden" name="idProveedorEdit" id="idProveedorEdit">
                            <div class="form-group col-md-6">
                                <label for="numeroIdentificacionEdit">Numero identificación</label>
                                <input type="text" class="form-control" name="numeroIdentificacionEdit" id="numeroIdentificacionEdit"onkeypress="return soloNumeros(event)" onchange="verificarCedula(this);" maxlength="10" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="razonSocialEdit">Razon social de la empresa</label>
                                <input type="text" class="form-control" name="razonSocialEdit" id="razonSocialEdit" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="direccionProveedorEdit">Dirección</label>
                                <input type="text" class="form-control" name="direccionProveedorEdit" id="direccionProveedorEdit" required>
                            </div>
                            <div class="col-md-6 mb-3">
                            <label for="validationServer14">Ciudad</label>
                            <select class="custom-select" name="ciudadEdit" id="ciudadEdit" required>
                            <option disabled value="">Seleccione...</option>
                                <?php
                                foreach ($ciudades as $ciudadesAspirante):
                                ?>
                                <option value="<?php echo $ciudadesAspirante->idciudades;?>"><?php echo utf8_encode($ciudadesAspirante->nombre);?></option>
                                <?php 
                                endforeach;
                                ?>  
                            </select>
                        </div>
                        </div>
                        <label class="font-weight-bold">Agrega información de contacto</label>
                        <hr class="mt-1 mb-4 mr-5">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nombreRepresentanteEdit">Nombre de representante legal</label>
                                <input type="text" class="form-control" name="nombreRepresentanteEdit" id="nombreRepresentanteEdit" onkeypress="return soloLetras(event)" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="telefonoUnoEdit">Primer telefono de contacto</label>
                                <input type="text" class="form-control" name="telefonoUnoEdit" id="telefonoUnoEdit" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="telefonoDosEdit">Segundo telefono de contacto</label>
                                <input type="text" class="form-control" name="telefonoDosEdit" id="telefonoDosEdit" onchange="validarTelefono(this);" onkeypress="return soloNumeros(event)" maxlength="7" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                            <label for="emailUnoEdit">Primer E-mail de contacto</label>
                            <input type="email" class="form-control" name="emailUnoEdit" id="emailUnoEdit" onchange="validarEmail(this);" required>
                            <div class="invalid-feedback">
                                Correo electrónico inválido.
                            </div>
                            <div class="valid-feedback">
                                Correo electrónico válido.
                            </div>
                            </div>
                            <div class="form-group col-md-6">
                            <label for="emailDosEdit">Segundo E-mail de contacto</label>
                            <input type="email" class="form-control" name="emailDosEdit" id="emailDosEdit" onchange="validarEmail(this);" required>
                            <div class="invalid-feedback">
                                Correo electrónico inválido.
                            </div>
                            <div class="valid-feedback">
                                Correo electrónico válido.
                            </div>
                            </div>
                        </div>  
                      <div class='modal-footer mt-2'>
                        <button id="cancelar-update" type='button' class="btn btn-light border-secondary" data-dismiss='modal'>Cancelar</button>
                        <button id='confirmacion-update' name='confirmacion-update' type='submit' class='btn btn-primary font-weight-bold' style="width:200px;">Continuar</button>
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
      $('#agregar').click(function(){
          $('#agregarCredencial').modal('show');
          $('#cancelar').click(function(){
              //accion 
              document.getElementById("form").reset();
          });
          $('#close').click(function(){
              //accion 
              document.getElementById("form").reset();
          });              
      });
      $('#btn-delete').click(function(){
            document.getElementById('formDelete').submit();
        });  
  });



</script>         
      </body>
</html>

