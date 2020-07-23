<?php
require '../../../../database.php';
require '../components/layout.php';
require '../../recursoshumanos/components/modal.php';
require '../controllers/functions/credenciales.php';

verificarAcceso("../../../../", "modulo_seguridad");
    if($_GET['id'] == 5){
        header("Location: scopes.php");
    }
    if(verificarAccion($conn, "modulo_seguridad", "insertar") == false){
        header("Location: credencial.php");
    }
    if(verificarAccion($conn, "modulo_seguridad", "actualizar") == false){
        header("Location: credencial.php");
    }
        $credencial = $conn->query("SELECT * FROM credencial_base AS c, scope AS s WHERE (c.id_scope_credencial = s.id_scope) AND (id_scope_credencial=".$_GET['id'].")ORDER BY nombre_credencial ASC")->fetchAll(PDO::FETCH_OBJ);
        $records = $conn->prepare("SELECT * FROM scope WHERE id_scope = :id_scope");
        $records->bindParam(':id_scope', $_GET['id']);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);
  
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
    <title> Seguridad | Actualizar Acción</title>
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
        <h1 class="h2">EDITAR SCOPES</h1>
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
        <form id="form" method="POST" action="../controllers/actualizarScope.php" class="ml-2 mr-2">
            <label class="font-weight-bold">Scopes de usuario</label>
            <hr class="mt-1 mb-4 mr-5">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input id="idScope" name="idScope" type="hidden" value="<?php echo $_GET['id']?>">
                    <label for="descripcionRol">Descripcion de rol</label>
                    <input type="text" class="form-control" name="descripcionRol" id="descripcionRol" value="<?php echo $results["descripcion_rol"]?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="nivelScope">Nivel del Scope</label>
                    <select id="nivelScope" name="nivelScope" class="form-control" required>
                    <option selected value="<?php echo $results["nivel_scope"]?>"><?php echo $results["nivel_scope"]?></option>
                    <option disabled value="">Seleccione...</option>
                    <option value="Alto">Alto</option>
                    <option value="Medio">Medio</option>
                    <option value="Bajo">Bajo</option>
                    </select>
                </div>
            </div>
            <label class="font-weight-bold">Acciones de Scope</label>
            <hr class="mt-1 mb-4 mr-5">
            <div class="form-row">
            <div class="custom-control custom-checkbox custom-control-inline">
                <?php if($results['lectura']==1): ?>  
                    <input type="checkbox" id="customCheckboxInline1" name="accion[]" class="custom-control-input" value="lectura" checked="true">
                 <?php else: ?>
                    <input type="checkbox" id="customCheckboxInline1" name="accion[]" class="custom-control-input" value="lectura">    
                <?php endif; ?>
                <label class="custom-control-label" for="customCheckboxInline1">Lectura</label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
                <?php if($results['insertar']==1):
                ?>
                    <input type="checkbox" id="customCheckboxInline2" name="accion[]" class="custom-control-input" value="escritura" checked="true"> 
                <?php else:?>
                    <input type="checkbox" id="customCheckboxInline2" name="accion[]" class="custom-control-input" value="escritura">
                <?php endif;?>
                <label class="custom-control-label" for="customCheckboxInline2">Escritura</label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
                <?php if($results['actualizar']==1):
                ?>
                    <input type="checkbox" id="customCheckboxInline3" name="accion[]" class="custom-control-input" value="actualizar" checked="true">
                <?php else:?>
                    <input type="checkbox" id="customCheckboxInline3" name="accion[]" class="custom-control-input" value="actualizar">
                <?php endif;?>
                <label class="custom-control-label" for="customCheckboxInline3">Actualizar</label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
                <?php if($results['actualizar_informacion']==1):
                ?>
                    <input type="checkbox" id="customCheckboxInline4" name="accion[]" class="custom-control-input" value="actSensible" checked="true">
                <?php else:?>
                    <input type="checkbox" id="customCheckboxInline4" name="accion[]" class="custom-control-input" value="actSensible">
                <?php endif;?>
                <label class="custom-control-label" for="customCheckboxInline4">Act. Inform. Sensible</label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
                <?php if($results['borrado_logico']==1):
                ?>
                    <input type="checkbox" id="customCheckboxInline5" name="accion[]" class="custom-control-input" value="borradoLogico" checked="true">
                <?php else:?>
                    <input type="checkbox" id="customCheckboxInline5" name="accion[]" class="custom-control-input" value="borradoLogico">
                <?php endif;?>
                <label class="custom-control-label" for="customCheckboxInline5">Borrado Logico</label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
                <?php if($results['borrado_fisico']==1):
                ?>
                    <input type="checkbox" id="customCheckboxInline6" name="accion[]" class="custom-control-input" value="borradoFisico" checked="true">
                <?php else:?>
                    <input type="checkbox" id="customCheckboxInline6" name="accion[]" class="custom-control-input" value="borradoFisico">
                <?php endif;?>
                <label class="custom-control-label" for="customCheckboxInline6">Borrado Fisico</label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
                <?php if($results['crear_usuarios']==1):
                ?>
                    <input type="checkbox" id="customCheckboxInline7" name="accion[]" class="custom-control-input" value="crearUsuario" checked="true">
                <?php else:?>
                    <input type="checkbox" id="customCheckboxInline7" name="accion[]" class="custom-control-input" value="crearUsuario">
                <?php endif;?>
                <label class="custom-control-label" for="customCheckboxInline7">Crear Usuario</label>
            </div>
            </div>
            <div class='modal-footer mt-2'>
            <a href="scopes.php" id="cancelar" type='button' class="btn btn-light border-secondary">Cancelar</a>
            <button id='btn' name='btn' type='button' class='btn btn-primary font-weight-bold' style="width:200px;">Guardar</button>
            </div> 
        </form>         
      </div>
      <div class="container">
      <h4 class="mb-3">Credenciales Afectadas</h4>
      <table class="table mb-4">
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
                  </tr>
                  <?php 
                  endforeach;
                ?>   
              </tbody>
          </table>
      </div>

    </main>
    <?php 
        printModal('Acualizar Scope','btn-actualizar','modal-actualizar','¡Hey!. Estas apunto de ACTUALIZAR este SCOPE, esto podria afectar a usuarios asociados a este SCOPE. ¿Realmente deseas ACTUALIZARLO?');
    ?>
    
</div>
<script src="../components/scripts/jquery.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="../components/scripts/dashboard.js"></script> 
<script>
      $(document).ready(function(){
        $('#btn').click(function(){
            $("#modal-actualizar").modal('show');
            $('#btn-actualizar').click(function(){
                document.getElementById('form').submit();
            })
        }); 
    });
</script>  
      </body>
</html>
