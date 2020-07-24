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
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
    <title> Seguridad | Acciones</title>
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
  'perfil.php','../../recursoshumanos/','../../suministro/','../../contabilidad/','../../citasmedicas/','../../pacientes/','../../seguridad/');
?>
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">GESTIÓN SCOPES</h1>
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
                  <th scope="col">Descripcion</th>
                  <th scope="col">Nivel Scope</th>
                  <th scope="col">Lectura</th>
                  <th scope="col">Insertar</th>
                  <th scope="col">Actualizar</th>
                  <th scope="col">Actualizar Información Sensible</th>
                  <th scope="col">Borrado Logico</th>
                  <th scope="col">Borrado Fisico</th>
                  <th scope="col">Crear Usuarios</th>
                  <th scope="col"></th>
              </tr>
              </thead>
              <tbody>
              <?php
                if($_SESSION['insertar'] == false || $_SESSION['actualizar'] == false):
              ?>
                  <?php
                    foreach ($scopes as $Scopes):
                  ?>
                      <tr>
                          <th scope="row"><?php echo $Scopes->descripcion_rol?></th>
                          <td><?php echo $Scopes->nivel_scope?></td>
                          <td><?php echo $Scopes->lectura?></td>
                          <td><?php echo $Scopes->insertar?></td>
                          <td><?php echo $Scopes->actualizar?></td>
                          <td><?php echo $Scopes->actualizar_informacion?></td>
                          <td><?php echo $Scopes->borrado_logico?></td>
                          <td><?php echo $Scopes->borrado_fisico?></td>
                          <td><?php echo $Scopes->crear_usuarios?></td>
                          <td></td>
                      </tr>
                  <?php 
                    endforeach;
                  ?>  
              <?php 
                else:
              ?>

                <?php
                foreach ($scopes as $Scopes):
                ?>
                  <tr>
                      <th scope="row"><?php echo $Scopes->descripcion_rol?></th>
                      <td><?php echo $Scopes->nivel_scope?></td>
                      <td><?php echo $Scopes->lectura?></td>
                      <td><?php echo $Scopes->insertar?></td>
                      <td><?php echo $Scopes->actualizar?></td>
                      <td><?php echo $Scopes->actualizar_informacion?></td>
                      <td><?php echo $Scopes->borrado_logico?></td>
                      <td><?php echo $Scopes->borrado_fisico?></td>
                      <td><?php echo $Scopes->crear_usuarios?></td>
                      <?php
                        if($Scopes->id_scope != 5):
                      ?>
                          <td>
                            <div class="d-flex justify-content-end">
                              <a href="actualizarScope.php?id=<?php echo $Scopes->id_scope?>" ><i class="far fa-edit mr-2" style="color:blue; font-size:20px;" title="Editar Scope"></i></a>
                            <?php
                              if($_SESSION['borrado_fisico'] == true):
                            ?>
                                <a onclick="eliminarScope('<?php echo $Scopes->id_scope?>','<?php echo $Scopes->descripcion_rol?>')" data-toggle="modal" href="#modal-delete"><i class="fas fa-trash-alt" style="color:red; font-size:20px;" title="Eliminar Scope"></i></a>
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
                  <a href="#" class="text-secondary" id="agregar" name="agregar" title="Agrega un nuevo scope"><i class="fas fa-plus-circle" style="font-size:35px;"></i></a>
              </div>
          <?php
            endif;
          ?>  
          

            <div class='modal fade' name='agregarScope' id='agregarScope' data-backdrop='static' data-keyboard='false' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabe' aria-hidden='true'>
                <div class='modal-dialog' style="max-width:800px;" >
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='staticBackdropLabel'>Agrega un nuevo scope</h5>
                            <button type='button' id='close' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                          <form id="form" method="POST" action="../controllers/crearScope.php" class="ml-2 mr-2">
                              <label class="font-weight-bold">SCOPES</label>
                              <hr class="mt-1 mb-4 mr-5">
                              <div class="form-row">
                                  <div class="form-group col-md-6">
                                      <label for="descripcionRol">Descripción del Scope</label>
                                      <input type="text" class="form-control" name="descripcionRol" id="descripcionRol" required>
                                  </div>
                                  <div class="form-group col-md-6">
                                      <label for="nivelScope">Nivel del Scope</label>
                                      <select id="nivelScope" name="nivelScope" class="form-control" required>
                                      <option selected disabled value="">Seleccione...</option>
                                        <option value="Alto">Alto</option>
                                        <option value="Medio">Medio</option>
                                        <option value="Bajo">Bajo</option>
                                    </select>
                                  </div>
                              </div>
                              <label class="font-weight-bold">Acceso a modulo</label>
                              <hr class="mt-1 mb-4 mr-5">
                              <div class="form-row">
                                <div class="custom-control custom-checkbox custom-control-inline">
                                  <input type="checkbox" id="customCheckboxInline1" name="accion[]" class="custom-control-input" value="lectura">
                                  <label class="custom-control-label" for="customCheckboxInline1">Lectura</label>
                                </div>
                                <div class="custom-control custom-checkbox custom-control-inline">
                                  <input type="checkbox" id="customCheckboxInline2" name="accion[]" class="custom-control-input" value="escritura">
                                  <label class="custom-control-label" for="customCheckboxInline2">Escritura</label>
                                </div>
                                <div class="custom-control custom-checkbox custom-control-inline">
                                  <input type="checkbox" id="customCheckboxInline3" name="accion[]" class="custom-control-input" value="actualizar">
                                  <label class="custom-control-label" for="customCheckboxInline3">Actualizar</label>
                                </div>
                                <div class="custom-control custom-checkbox custom-control-inline">
                                  <input type="checkbox" id="customCheckboxInline4" name="accion[]" class="custom-control-input" value="actSensible">
                                  <label class="custom-control-label" for="customCheckboxInline4">Act.Informacion Sensible</label>
                                </div>
                                <div class="custom-control custom-checkbox custom-control-inline">
                                  <input type="checkbox" id="customCheckboxInline5" name="accion[]" class="custom-control-input" value="borradoLogico">
                                  <label class="custom-control-label" for="customCheckboxInline5">Borrado Logico</label>
                                </div>
                                <div class="custom-control custom-checkbox custom-control-inline">
                                  <input type="checkbox" id="customCheckboxInline6" name="accion[]" class="custom-control-input" value="borradoFisico">
                                  <label class="custom-control-label" for="customCheckboxInline6">Borrado Fisico</label>
                                </div>
                                <div class="custom-control custom-checkbox custom-control-inline">
                                  <input type="checkbox" id="customCheckboxInline7" name="accion[]" class="custom-control-input" value="crearUsuario">
                                  <label class="custom-control-label" for="customCheckboxInline7">Crear Usuarios</label>
                                </div>
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
        printModal('Borrar Scope','btn-delete','modal-delete','¡Hey!. Esta SCOPE esta asignada a USUARIOS y CREDENCIALES, estas apunto de ELIMINARLO. ¿Realmente desea ELIMINAR el SCOPE?');
    ?>
    <div class='modal fade' name='updateScopeAsignada' id='updateScopeAsignada' data-backdrop='static' data-keyboard='false' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabe' aria-hidden='true'>
        <div class='modal-dialog' style="max-width:600px;" >
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='staticBackdropLabel'>Agrega un nuevo scope a usuarios y credenciales afectados</h5>
                    <button type='button' id='close' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                  <form id="formBorrarScope" method="POST" onsubmit="onSubmit(event)" action="../controllers/borrarScope.php" class="ml-2 mr-2">
                      <div class="form-row">
                          <div class="form-group col-md-6">
                              <label class="text-danger" for="scopeBorrar">Nombre de scope afectado</label>
                              <input type="text" style="text-decoration: line-through;" class="form-control text-danger" name="scopeBorrar" id="scopeBorrar" readonly>
                          </div>
                      </div>
                      <label class="font-weight-bold mt-2">Elige nuevo scope para asignar a los usuarios y credenciales afectadas</label>
                      <hr class="mt-1 mb-4 mr-5">
                      <input id="idScope" name="idScope" type="hidden">
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
                            <div class="invalid-feedback">
                              No puedes asignar un scope que vas a ELIMINAR. 
                            </div>
                          </div>
                          <div id="objeto">
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
<script>
  function eliminarScope(id,name){
    document.getElementById('idScope').value = id;
    document.getElementById('scopeBorrar').value = name;
  }
  $(document).ready(function(){
      $('#agregar').click(function(){
          $("#agregarScope").modal('show');
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
          $("#updateScopeAsignada").modal('show');
      }); 
  });

  onSubmit = (event) => {
    event.preventDefault()

    if(document.getElementById('scope').value == document.getElementById('idScope').value){
        document.getElementById('scope').className = "form-control is-invalid"
        document.getElementById('scope').focus();
    }else{
        document.getElementById('formBorrarScope').submit();
    } 
  } 
</script>         
      </body>
</html>
