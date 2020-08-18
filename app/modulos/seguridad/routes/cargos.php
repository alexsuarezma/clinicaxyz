<?php
require '../../../../database.php';
require '../components/layout.php';
require '../../recursoshumanos/components/modal.php';
require '../controllers/functions/credenciales.php';

verificarAcceso("../../../../", "modulo_seguridad");

$actualizar = true;

  if(verificarAccion($conn, "modulo_seguridad", "actualizar") == false){
    $actualizar = false;
  }
  
  $credencial = $conn->query("SELECT * FROM credencial_base AS c, scope AS s WHERE (c.id_scope_credencial = s.id_scope) ORDER BY nombre_credencial ASC")->fetchAll(PDO::FETCH_OBJ);
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
    <title> Seguridad | Cargos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/dashboard/">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <!-- Bootstrap core CSS -->
    <link href="../assets/dist/css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../assets/styles/dashboard.css" rel="stylesheet">
    <style>
        #busqueda {
                background-image: url('/css/searchicon.png');
                background-position: 10px 12px;
                background-repeat: no-repeat;
                width: 100%;
                font-size: 16px;
                padding: 12px 20px 12px 40px;
                border: 1px solid #ddd;
                margin-bottom: 12px;
            }
    </style>
  </head>
  <body>
<?php
 printLayout('../index.php', '../../../../index.php', 'credencial.php', 'scopes.php', 'usuarios.php', 'cargos.php','auditoria.php','../controllers/logout.php',
 'perfil.php','../../recursoshumanos/','../../suministro/','../../contabilidad/','../../citasmedicas/','../../pacientes/','../../seguridad/',4);
?>
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">GESTIÓN CREDENCIALES DE CARGOS</h1>
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
      <div class="container mt-4">
        <input type="search" name="busqueda" id="busqueda" placeholder="Busca por areas, cargo, credenciales..." title="Type in a name">
      </div>
      <div class="container mt-5 mb-5">
            <div id="datosCargos"></div>
          <hr class="mb-4">       
      </div>
    </main>
    <?php 
        printModal('Credencial De Usuarios','btn-delete','modal-delete','¡Hey!. Estas apunto de editar la CREDENCIAL asignada a este CARGO. ¿Deseas continuar con la acción?');
    ?>
    <div class='modal fade' name='updateCredencialAsignada' id='updateCredencialAsignada' data-backdrop='static' data-keyboard='false' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabe' aria-hidden='true'>
        <div class='modal-dialog' style="max-width:600px;" >
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='staticBackdropLabel'>Cambia la credencial asociada a este cargo</h5>
                    <button type='button' id='close-update' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                  <form id="formCambiarCredencial" method="POST" onsubmit="onSubmit(event)" action="../controllers/cambiarCredencialCargo.php" class="ml-2 mr-2">
                      <label class="font-weight-bold mt-2">Credencial del Cargo</label>
                      <hr class="mt-1 mb-4 mr-5">
                      <div class="form-row">
                          <div class="form-group col-md-6">
                              <input id="idCargoAsociado" name="idCargoAsociado" type="hidden">
                              <label for="cargo">Cargo</label>
                              <input type="text" class="form-control" name="cargo" id="cargo" readonly>
                          </div>
                          <span style="margin-top:35px;">
                            -->
                          </span>
                          <div class="form-group col-md-5">
                            <input id="idCredencialAsociada" name="idCredencial" type="hidden">
                            <label for="credencialAsociada">Credencial Asociada</label>
                            <input type="text" class="form-control" name="credencialAsociada" id="credencialAsociada" readonly>
                          </div>
                      </div>
                      <label class="font-weight-bold mt-2 text-danger">Elige una nueva credencial en caso de requieras cambiar la credencial actual a este cargo</label>
                      <hr class="mt-1 mb-4 mr-5">
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
                          <div class="form-group col-md-6">
                          <label class="text-danger">Selecciona 'SI' Si deseas que el cambio afecte a los empleados antiguos. Y 'NO' si solo deseas que se afecten a los empleados que se registren despues de este cambio.</label>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline1" name="cambioGlobal" class="custom-control-input" value="si" required>
                                <label class="custom-control-label" for="customRadioInline1">SI</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline2" name="cambioGlobal" class="custom-control-input" value="no">
                                <label class="custom-control-label" for="customRadioInline2">NO</label>
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
<script src="../components/scripts/filtroCargos.js"></script>
<script src="../components/scripts/consulta.js"></script> 
<script>

  function cambiarCredencial(idCargo,idCredencial,nombreCargo,nombreCredencial){
    document.getElementById('idCargoAsociado').value = idCargo;
    document.getElementById('idCredencialAsociada').value = idCredencial;
    document.getElementById('credencialAsociada').value = nombreCredencial;
    document.getElementById('cargo').value = nombreCargo;
  }

  $(document).ready(function(){
        
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

    if(document.getElementById('credencial').value == document.getElementById('idCredencialAsociada').value){
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
