<?php
require '../../../../database.php';
require '../components/layout.php';
require '../../recursoshumanos/components/modal.php';
require '../controllers/functions/credenciales.php';

verificarAcceso("../../../../", "modulo_seguridad");

$_SESSION['insertar'] = verificarAccion($conn, "modulo_seguridad", "insertar");
$_SESSION['actualizar'] = verificarAccion($conn, "modulo_seguridad", "actualizar");
$_SESSION['borrado_fisico'] = verificarAccion($conn, "modulo_seguridad", "borrado_fisico");

  $scopes = $conn->query("SELECT * FROM scope ORDER BY descripcion_rol ASC")->fetchAll(PDO::FETCH_OBJ);
  $credencial = $conn->query("SELECT * FROM credencial_base AS c, scope AS s WHERE (c.id_scope_credencial = s.id_scope) ORDER BY nombre_credencial ASC")->fetchAll(PDO::FETCH_OBJ);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
    <title> Seguridad | Credenciales</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/dashboard/">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <!-- Bootstrap core CSS -->
    <link href="../assets/dist/css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../assets/styles/dashboard.css" rel="stylesheet">
  </head>
  <body>
<?php
  printLayout('../index.php', '../../../../index.php', 'credencial.php', 'scopes.php', 'usuarios.php', 'cargos.php','../controllers/logout.php',
  'perfil.php','../../recursoshumanos/','../../suministro/','../../contabilidad/','../../citasmedicas/','../../pacientes/','../../seguridad/',3);
?>
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">GESTIÓN CREDENCIALES BASES</h1>
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

            <table class="table">
              <thead class="thead-dark">
              <tr>
                  <th scope="col">Nombre Credencial</th>
                  <th scope="col">Modulo RRHH</th>
                  <th scope="col">Modulo Contabilidad</th>
                  <th scope="col">Modulo Suministros</th>
                  <th scope="col">Modulo Ctas Medicas</th>
                  <th scope="col">Modulo Pacientes</th>
                  <th scope="col">Modulo Seguridad</th>
                  <th scope="col">Paciente</th>
                  <th scope="col">Scope Asignado</th>
                  <th scope="col"></th>
              </tr>
              </thead>
              <tbody>

              <?php
                if($_SESSION['insertar'] == false || $_SESSION['actualizar'] == false):
              ?>
                  <?php
                      foreach ($credencial as $credenciales):
                  ?>
                      <tr>
                          <th scope="row"><?php echo $credenciales->nombre_credencial?></th>
                          <td><?php echo $credenciales->modulo_rrhh?></td>
                          <td><?php echo $credenciales->modulo_contabilidad?></td>
                          <td><?php echo $credenciales->modulo_suministros?></td>
                          <td><?php echo $credenciales->modulo_ctas_medicas?></td>
                          <td><?php echo $credenciales->modulo_pacientes?></td>
                          <td><?php echo $credenciales->modulo_seguridad?></td>
                          <td><?php echo $credenciales->paciente?></td>
                          <td><?php echo $credenciales->descripcion_rol?></td>
                          <td></td>
                      </tr>
                  <?php 
                      endforeach;
                  ?>  
              <?php 
                else:
              ?>

                  <?php
                      foreach ($credencial as $credenciales):
                  ?>
                        <tr>
                            <th scope="row"><?php echo $credenciales->nombre_credencial?></th>
                            <td><?php echo $credenciales->modulo_rrhh?></td>
                            <td><?php echo $credenciales->modulo_contabilidad?></td>
                            <td><?php echo $credenciales->modulo_suministros?></td>
                            <td><?php echo $credenciales->modulo_ctas_medicas?></td>
                            <td><?php echo $credenciales->modulo_pacientes?></td>
                            <td><?php echo $credenciales->modulo_seguridad?></td>
                            <td><?php echo $credenciales->paciente?></td>
                            <td><?php echo $credenciales->descripcion_rol?></td>
                            <?php
                              if($credenciales->id_credencial != 18 && $credenciales->id_credencial != 19):
                            ?>
                            <td>
                              <div class="d-flex justify-content-end">
                                <a href="actualizarCredencial.php?id=<?php echo $credenciales->id_credencial?>" ><i class="far fa-edit mr-2" style="color:blue; font-size:20px;" title="Editar Credencial"></i></a>
                                  <?php
                                      if($_SESSION['borrado_fisico'] == true):
                                  ?>
                                    <a onclick="eliminarCredencial('<?php echo $credenciales->id_credencial?>','<?php echo $credenciales->nombre_credencial?>')" data-toggle="modal" href="#modal-delete"><i class="fas fa-trash-alt" style="color:red; font-size:20px;" title="Eliminar Credencial"></i></a>
                                  <?php
                                    endif;
                                  ?>
                              </div>                      
                            </td>
                            <?php
                              else:
                            ?>
                                <td></td>
                            <?php
                              endif;
                            ?>
                        </tr>
                  <?php 
                    endforeach;
                  ?>
              <?php 
                endif;
              ?>   
              </tbody>
          </table>
          <hr class="mb-4">
          <?php
                if($_SESSION['insertar'] != false):
          ?>
              <div class="d-flex justify-content-center">
                  <a href="#" class="text-secondary" id="agregar" name="agregar" title="Agrega una nueva credencial"><i class="fas fa-plus-circle" style="font-size:35px;"></i></a>
              </div>
          <?php 
            endif;
          ?>   
            <div class='modal fade' name='agregarCredencial' id='agregarCredencial' data-backdrop='static' data-keyboard='false' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabe' aria-hidden='true'>
                <div class='modal-dialog' style="max-width:800px;" >
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='staticBackdropLabel'>Agrega una nueva credencial</h5>
                            <button type='button' id='close' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                          <form id="form" method="POST" action="../controllers/crearCredencial.php" class="ml-2 mr-2">
                              <label class="font-weight-bold">Credencial de usuario</label>
                              <hr class="mt-1 mb-4 mr-5">
                              <div class="form-row">
                                  <div class="form-group col-md-6">
                                      <label for="nombreCredencial">Nombre de credencial</label>
                                      <input type="text" class="form-control" name="nombreCredencial" id="nombreCredencial" required>
                                  </div>
                              </div>
                              <label class="font-weight-bold">Acceso a modulo</label>
                              <hr class="mt-1 mb-4 mr-5">
                              <div class="form-row">
                                <div class="custom-control custom-radio custom-control-inline">
                                  <input type="radio" id="customRadioInline1" name="accessoModulo" class="custom-control-input" value="Humanos" required>
                                  <label class="custom-control-label" for="customRadioInline1">R.R.H.H.</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                  <input type="radio" id="customRadioInline2" name="accessoModulo" class="custom-control-input" value="Contabilidad">
                                  <label class="custom-control-label" for="customRadioInline2">Contabilidad</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                  <input type="radio" id="customRadioInline3" name="accessoModulo" class="custom-control-input" value="Suministros">
                                  <label class="custom-control-label" for="customRadioInline3">Suministros</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                  <input type="radio" id="customRadioInline4" name="accessoModulo" class="custom-control-input" value="Citas">
                                  <label class="custom-control-label" for="customRadioInline4">Citas Medicas</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                  <input type="radio" id="customRadioInline5" name="accessoModulo" class="custom-control-input" value="ModuloPacientes">
                                  <label class="custom-control-label" for="customRadioInline5">Modulo Pacientes</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                  <input type="radio" id="customRadioInline6" name="accessoModulo" class="custom-control-input" value="Seguridad">
                                  <label class="custom-control-label" for="customRadioInline6">Seguridad</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                  <input type="radio" id="customRadioInline7" name="accessoModulo" class="custom-control-input" value="Paciente">
                                  <label class="custom-control-label" for="customRadioInline7">Paciente</label>
                                </div>
                              </div>
                        
                              <label class="font-weight-bold mt-4">Elige el scope de esta nueva credencial</label>
                              <hr class="mt-1 mb-4 mr-5">
                              <div class="form-row">               
                                  <div class="form-group col-md-6">
                                    <label for="scope">Scopes</label>
                                    <select id="scope" name="scope" class="form-control" required>
                                      <option selected disabled value="">Seleccione...</option>
                                      <?php
                                        foreach ($scopes as $Scopes):
                                      ?>
                                        <option value="<?php echo $Scopes->id_scope;?>"><?php echo utf8_encode($Scopes->descripcion_rol);?></option>
                                      <?php 
                                        endforeach;
                                      ?> 
                                    </select>
                                  </div>
                              </div>
                              
                              <div id='objeto'>
                                  <!-- INFORMACIÓN DE LOS SCOPES -->
                              </div>
                              <div class='modal-footer mt-2'>
                                <button id="cancelar" type='button' class="btn btn-light border-secondary" data-dismiss='modal'>Cancelar</button>
                                <button id='confirmacion' name='confirmacion' type='submit' class='btn btn-primary font-weight-bold' style="width:200px;">Guardar</button>
                              </div> 
                            </form>
                        </div>
                    </div>
                </div>
            </div>
      </div>
    </main>
    <?php 
        printModal('Borrar Credencial Base','btn-delete','modal-delete','¡Hey!. Esta CREDECNIAL esta asignada a USUARIOS, estas apunto de ELIMINARLA. ¿Realmente desea ELIMINAR la CREDENCIAL?');
    ?>
    <div class='modal fade' name='updateCredencialAsignada' id='updateCredencialAsignada' data-backdrop='static' data-keyboard='false' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabe' aria-hidden='true'>
        <div class='modal-dialog' style="max-width:600px;" >
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='staticBackdropLabel'>Agrega una nueva credencial a usuarios afectas</h5>
                    <button type='button' id='close' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                  <form id="formBorrarCredencial" method="POST" onsubmit="onSubmit(event)" action="../controllers/borrarCredencial.php" class="ml-2 mr-2">
                      <div class="form-row">
                          <div class="form-group col-md-6">
                              <label class="text-danger" for="credencialBorrar">Nombre de credencial afectada</label>
                              <input type="text" style="text-decoration: line-through;" class="form-control text-danger" name="credencialBorrar" id="credencialBorrar" readonly>
                          </div>
                      </div>
                      <label class="font-weight-bold mt-2">Elige la nueva credencial a asignar a los usuarios afectados</label>
                      <hr class="mt-1 mb-4 mr-5">
                      <input id="idCredencial" name="idCredencial" type="hidden">
                      <div class="form-row">               
                          <div class="form-group col-md-6">
                            <label for="credenciales">Credenciales</label>
                            <select id="credenciales" name="credenciales" class="form-control" required>
                              <option selected disabled value="">Seleccione...</option>
                              <?php
                                foreach ($credencial as $credenciales):
                              ?>
                                <option value="<?php echo $credenciales->id_credencial;?>"><?php echo utf8_encode($credenciales->nombre_credencial);?></option>
                              <?php 
                                endforeach;
                              ?> 
                            </select>
                            <div class="invalid-feedback">
                              No puedes asignar una credencial que vas a ELIMINAR. 
                            </div>
                          </div>
                          <span class="mt-4">
                            -->
                          </span>
                          <div id="inputCargo" class="form-group col-md-5">
                              <!-- CARGOO -->
                          </div>
                      </div>
                      <span class="text-danger">
                          NOTA: Recuerde que estas CREDENCIALES BASES estan asociadas a CARGOS de empleados, este cambio tambien sera reflejado en los CARGOS. 
                      </span>
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
<script>
  function eliminarCredencial(id,name){
    document.getElementById('idCredencial').value = id;
    document.getElementById('credencialBorrar').value = name;
  }
  $(document).ready(function(){
      $('#agregar').click(function(){
          $("#agregarCredencial").modal('show');
          $('#cancelar').click(function(){
              //accion 
              document.getElementById("form").reset();
              buscarScopes();
          });
          $('#close').click(function(){
              //accion 
              document.getElementById("form").reset();
              buscarScopes();
          });              
      });

      $('#btn-delete').click(function(){
          $("#updateCredencialAsignada").modal('show');
      }); 
  });

  onSubmit = (event) => {
    event.preventDefault()

    if(document.getElementById('credenciales').value == document.getElementById('idCredencial').value){
        document.getElementById('credenciales').className = "form-control is-invalid"
        document.getElementById('credenciales').focus();
    }else{
        document.getElementById('formBorrarCredencial').submit();
    } 
  } 
</script>         
      </body>
</html>
