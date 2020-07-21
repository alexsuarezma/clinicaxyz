<?php
require '../../../../database.php';
require '../components/layout.php';
require '../../recursoshumanos/components/modal.php';
require '../controllers/functions/credenciales.php';


verificarAcceso("../../../../", "modulo_seguridad");
  
  $usuario = $conn->query("SELECT * FROM empleados AS e, usuario AS u, usuario_credencial AS uc, credencial_base AS c WHERE (uc.id_usuario_uc = u.id_usuario AND e.id_usuario_emp = u.id_usuario AND c.id_credencial = uc.id_credencialbase_uc) ORDER BY username ASC")->fetchAll(PDO::FETCH_OBJ);
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
    <title>Seguridad</title>
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
  printLayout('../index.php', '../../../../index.php', 'credencial.php', 'scopes.php', 'usuarios.php', 'cargos.php');
?>
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">LISTA DE USUARIOS</h1>
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
                  <th scope="col">Cedula</th>
                  <th scope="col">Nombre</th>
                  <th scope="col">Apellido</th>
                  <th scope="col">Cargo</th>
                  <th scope="col">Nombre Credencial</th>
                  <th scope="col">Nombre de Usuario</th>
                  <th scope="col"></th>

              </tr>
              </thead>
              <tbody>
              <?php
              foreach ($usuario as $Usuarios):
              ?>
                  <tr>
                      <th scope="row"><?php echo $Usuarios->id_empleados?></th>
                      <td><?php echo $Usuarios->nombres?></td>
                      <td><?php echo $Usuarios->apellidos?></td>
                      <td><?php echo $Usuarios->id_cargo_emp?></td>
                      <td><?php echo $Usuarios->nombre_credencial?></td>
                      <td><?php echo $Usuarios->username?></td>
                      <td>
                        <div class="d-flex justify-content-end">
                          <a class="text-secondary" href="../controllers/borrarCredencialUsuario.php?idUser=<?php echo $Usuarios->id_usuario_uc?>&idCredencial=<?php echo $Usuarios->id_credencial?>"><i class="fas fa-user-slash mr-2" style="font-size:20px;" title="Eliminar la credencial al usuario <?php echo $Usuarios->username?>"></i></a>
                          <a onclick="agregarCredencial('<?php echo $Usuarios->id_empleados?>','<?php echo $Usuarios->id_usuario_uc?>','<?php echo $Usuarios->id_usuario_credencial?>','<?php echo $Usuarios->id_credencial?>','<?php echo $Usuarios->nombre_credencial?>','<?php echo $Usuarios->nombres?>','<?php echo $Usuarios->apellidos?>','<?php echo $Usuarios->username?>')" class="text-secondary" data-toggle="modal" href="#agregarCredencial"><i class="fas fa-user-plus mr-2" style="font-size:20px;" title="Agrega una nueva credencial al usuario <?php echo $Usuarios->username?>"></i></a>
                          <a onclick="eliminarCredencial('<?php echo $Usuarios->id_empleados?>','<?php echo $Usuarios->id_usuario_uc?>','<?php echo $Usuarios->id_usuario_credencial?>','<?php echo $Usuarios->id_credencial?>','<?php echo $Usuarios->nombre_credencial?>','<?php echo $Usuarios->nombres?>','<?php echo $Usuarios->apellidos?>','<?php echo $Usuarios->username?>')" data-toggle="modal" href="#updateCredencialAsignada"><i class="fas fa-user-edit" style="color:red; font-size:20px;" title="Editar Credencial del usuario <?php echo $Usuarios->username?>"></i></a>
                        </div>                      
                      </td>
                  </tr>
                  <?php 
                  endforeach;
                ?>   
              </tbody>
          </table>
          <hr class="mb-4">       

            <div class='modal fade' name='agregarCredencial' id='agregarCredencial' data-backdrop='static' data-keyboard='false' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabe' aria-hidden='true'>
                <div class='modal-dialog' style="max-width:800px;" >
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='staticBackdropLabel'>Agrega una nueva credencial a este usuario</h5>
                            <button type='button' id='close' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                          <form id="form" method="POST" action="../controllers/agregarCredencialUsuario.php" class="ml-2 mr-2">
                              <label class="font-weight-bold">Credencial de usuario</label>
                              <hr class="mt-1 mb-4 mr-5">
                              <div class="form-row">
                              <input id="idUcActual" name="idUcActual" type="hidden">
                                  <input id="idUserCredencialUsuario" name="idUserCredencialUsuario" type="hidden">
                                  <div class="form-group col-md-6">
                                      <label for="usuario">Usuario</label>
                                      <input type="text" class="form-control" name="usuario" id="usuario" readonly required>
                                  </div>
                              </div>
                              <hr class="mt-1 mb-4 mr-5">
                              <div class="form-row">
                                  <div class="form-group col-md-6">
                                      <label for="cedulaUsuario">Cedula</label>
                                      <input type="text" class="form-control" name="cedulaUsuario" id="cedulaUsuario" readonly>
                                  </div>
                              </div>
                              <div class="form-row">
                                  <div class="form-group col-md-6">
                                      <label for="nombreEmpleadoUsuario">Nombres de empleado</label>
                                      <input type="text" class="form-control" name="nombreEmpleadoUsuario" id="nombreEmpleadoUsuario" readonly>
                                  </div>
                                  <div class="form-group col-md-6">
                                      <label for="apellidoEmpleadoUsuario">Apellidos de empleado</label>
                                      <input type="text" class="form-control" name="apellidoEmpleadoUsuario" id="apellidoEmpleadoUsuario" readonly>
                                  </div>
                              </div>
                              <div class="form-row">
                                  <div class="form-group col-md-6">
                                      <label for="nameCredencialUsuario">Credencial</label>
                                      <input type="text" class="form-control" name="nameCredencialUsuario" id="nameCredencialUsuario" readonly>
                                  </div>
                              </div>
                              <label class="font-weight-bold mt-4">Elige la nueva credencial para este usuario</label>
                              <hr class="mt-1 mb-4 mr-5">
                              <div class="form-row">               
                                  <div class="form-group col-md-6">
                                    <label for="credencialUsuario">Credenciales</label>
                                    <select id="credencialUsuario" name="credencialUsuario" class="form-control" required>
                                      <option selected disabled value="">Seleccione...</option>
                                      <?php
                                        foreach ($credencial as $credenciales):
                                      ?>
                                        <option value="<?php echo $credenciales->id_credencial;?>"><?php echo utf8_encode($credenciales->nombre_credencial);?></option>
                                      <?php 
                                        endforeach;
                                      ?> 
                                    </select>
                                  </div>
                              </div>
                              <div id='credencialesUsuario'>
                                          <!-- INFORMACIÓN DE LOS SCOPES -->
                              </div>
                              <div class='modal-footer mt-2'>
                                <button id="cancelar" type='button' class="btn btn-light border-secondary" data-dismiss='modal'>Cancelar</button>
                                <button id='confirmacion' name='confirmacion' type='submit' class='btn btn-primary font-weight-bold' style="width:200px;">Crear</button>
                              </div> 
                            </form>
                        </div>
                    </div>
                </div>
            </div>
      </div>
    </main>
    <?php 
        printModal('Credencial De Usuarios','btn-delete','modal-delete','¡Hey!. Estas apunto de editar la CREDENCIAL asignada a este USUARIO. ¿Deseas continuar con la acción?');
    ?>
    <div class='modal fade' name='updateCredencialAsignada' id='updateCredencialAsignada' data-backdrop='static' data-keyboard='false' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabe' aria-hidden='true'>
        <div class='modal-dialog' style="max-width:800px;" >
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='staticBackdropLabel'>Cambia o asigna otra credencial a este usuario</h5>
                    <button type='button' id='close-update' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                  <form id="formCambiarCredencial" method="POST" onsubmit="onSubmit(event)" action="../controllers/cambiarCredencial.php" class="ml-2 mr-2">
                      <label class="font-weight-bold mt-2">Credencial de Usuario</label>
                      <hr class="mt-1 mb-4 mr-5">
                      <div class="form-row">
                          <div class="form-group col-md-6">
                              <label for="cedula">Cedula</label>
                              <input type="text" class="form-control" name="cedula" id="cedula" readonly>
                          </div>
                      </div>
                      <div class="form-row">
                          <div class="form-group col-md-6">
                              <label for="nombreEmpleado">Nombres de empleado</label>
                              <input type="text" class="form-control" name="nombreEmpleado" id="nombreEmpleado" readonly>
                          </div>
                          <div class="form-group col-md-6">
                              <label for="apellidoEmpleado">Apellidos de empleado</label>
                              <input type="text" class="form-control" name="apellidoEmpleado" id="apellidoEmpleado" readonly>
                          </div>
                      </div>
                      <div class="form-row">
                          <div class="form-group col-md-6">
                              <label for="userName">Nombre de usuario</label>
                              <input type="text" class="form-control" name="userName" id="userName" readonly>
                          </div>
                          <div class="form-group col-md-6">
                              <label for="nameCredencial">Credencial</label>
                              <input type="text" class="form-control" name="nameCredencial" id="nameCredencial" readonly>
                          </div>
                      </div>
                      <label class="font-weight-bold mt-2 text-danger">Elige una nueva credencial en caso de requieras cambiar la credencial actual a este usuario</label>
                      <hr class="mt-1 mb-4 mr-5">
                      <input id="idCredencial" name="idCredencial" type="hidden">
                      <input id="idUserCredencial" name="idUserCredencial" type="hidden">
                      <input id="idUser" name="idUser" type="hidden">
                      <div class="form-row">               
                          <div class="form-group col-md-6">
                            <label for="credencial">Credenciales</label>
                            <select id="credencial" name="credencial" class="form-control" required>
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
                                Estas asignandole la misma credencial.
                            </div>
                          </div>
                      </div>
                      <div id='credenciales'>
                                  <!-- INFORMACIÓN DE LOS SCOPES -->
                      </div>
                      <div class='modal-footer mt-4'>
                        <button id="cancelar-update" type='button' class="btn btn-light border-secondary" data-dismiss='modal'>Cancelar</button>
                        <button id='confirmacion-update' name='confirmacion-update' type='submit' class='btn btn-primary font-weight-bold' style="width:200px;">Continuar</button>
                      </div> 
                      <span class="text-danger">Nota: No se pueden duplicar credenciales en caso de que selecciones una credencial que ya tiene asignada este usuario, se ELIMINARA la credencial actual. </span>
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
  function eliminarCredencial(id,idUser,idUc,idCredencial,nameCredencial,nombreEmpleado,apellidoEmpleado,userName){
    document.getElementById('cedula').value = id;
    document.getElementById('idUser').value = idUser;
    document.getElementById('idUserCredencial').value = idUc;
    document.getElementById('idCredencial').value = idCredencial;
    document.getElementById('nombreEmpleado').value = nombreEmpleado;
    document.getElementById('apellidoEmpleado').value = apellidoEmpleado;
    document.getElementById('userName').value = userName;
    document.getElementById('nameCredencial').value = nameCredencial;
  }
  
  function agregarCredencial(id,idUser,idUc,idCredencial,nameCredencial,nombreEmpleado,apellidoEmpleado,userName){
    document.getElementById('cedulaUsuario').value = id;
    document.getElementById('idUserCredencialUsuario').value = idUser;
    document.getElementById('idUcActual').value = idUc;
    document.getElementById('nombreEmpleadoUsuario').value = nombreEmpleado;
    document.getElementById('apellidoEmpleadoUsuario').value = apellidoEmpleado;
    document.getElementById('usuario').value = userName;
    document.getElementById('nameCredencialUsuario').value = nameCredencial;
  }
  $(document).ready(function(){
   
      $('#cancelar').click(function(){
          //accion 
          document.getElementById("form").reset();
          buscarCredencialesUsuario();
      });
      $('#close').click(function(){
          //accion 
          document.getElementById("form").reset();
          buscarCredencialesUsuario();
      });              
  
      
      $('#close-update').click(function(){
          //accion 
          document.getElementById("formCambiarCredencial").reset();
          buscarCredenciales();
      });  
      $('#cancelar-update').click(function(){
          //accion 
          document.getElementById("formCambiarCredencial").reset();
          buscarCredenciales();
      });  

  });

  onSubmit = (event) => {
    event.preventDefault()

    if(document.getElementById('credencial').value == document.getElementById('idCredencial').value){
        document.getElementById('credencial').className = "form-control is-invalid"
        document.getElementById('credencial').focus();
    }else{
      $('#updateCredencialAsignada').modal('hide')  
      $("#modal-delete").modal('show');
      $('#btn-delete').click(function(){
          //accion 
          document.getElementById('formCambiarCredencial').submit();
      });
        
    } 
  } 
</script>         
      </body>
</html>
