<?php
require '../../../../database.php';
require '../components/layout.php';
require '../../recursoshumanos/components/modal.php';
require '../controllers/functions/credenciales.php';

verificarAcceso("../../../../", "modulo_seguridad");
  $scopes = $conn->query("SELECT * FROM scope ORDER BY descripcion_rol ASC")->fetchAll(PDO::FETCH_OBJ);

        $records = $conn->prepare("SELECT * FROM credencial_base AS c, scope AS s WHERE (c.id_scope_credencial = s.id_scope) AND id_credencial = :id_credencial");
        $records->bindParam(':id_credencial', $_GET['id']);
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
        <h1 class="h2">EDITAR CREDENCIALES BASES</h1>
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
        <form id="form" method="POST" action="../controllers/actualizarCredencial.php" class="ml-2 mr-2">
            <label class="font-weight-bold">Credencial de usuario</label>
            <hr class="mt-1 mb-4 mr-5">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input id="idCredencial" name="idCredencial" type="hidden" value="<?php echo $_GET['id']?>">
                    <label for="nombreCredencial">Nombre de credencial</label>
                    <input type="text" class="form-control" name="nombreCredencial" id="nombreCredencial" value="<?php echo $results["nombre_credencial"]?>" required>
                </div>
            </div>
            <label class="font-weight-bold">Acceso a modulo</label>
            <hr class="mt-1 mb-4 mr-5">
            <div class="form-row">
            <div class="custom-control custom-radio custom-control-inline">
                <?php if($results['modulo_rrhh']==1): ?>  
                    <input type="radio" id="customRadioInline1" name="accessoModulo" class="custom-control-input" value="Humanos" checked="true" required>
                 <?php else: ?>
                    <input type="radio" id="customRadioInline1" name="accessoModulo" class="custom-control-input" value="Humanos" required>    
                <?php endif; ?>
                <label class="custom-control-label" for="customRadioInline1">R.R.H.H.</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <?php if($results['modulo_contabilidad']==1):
                ?>
                    <input type="radio" id="customRadioInline2" name="accessoModulo" class="custom-control-input" value="Contabilidad" checked="true"> 
                <?php else:?>
                    <input type="radio" id="customRadioInline2" name="accessoModulo" class="custom-control-input" value="Contabilidad">
                <?php endif;?>
                <label class="custom-control-label" for="customRadioInline2">Contabilidad</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <?php if($results['modulo_suministros']==1):
                ?>
                    <input type="radio" id="customRadioInline3" name="accessoModulo" class="custom-control-input" value="Suministros" checked="true">
                <?php else:?>
                    <input type="radio" id="customRadioInline3" name="accessoModulo" class="custom-control-input" value="Suministros">
                <?php endif;?>
                <label class="custom-control-label" for="customRadioInline3">Suministros</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <?php if($results['modulo_ctas_medicas']==1):
                ?>
                    <input type="radio" id="customRadioInline4" name="accessoModulo" class="custom-control-input" value="Citas" checked="true">
                <?php else:?>
                    <input type="radio" id="customRadioInline4" name="accessoModulo" class="custom-control-input" value="Citas">
                <?php endif;?>
                <label class="custom-control-label" for="customRadioInline4">Citas Medicas</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <?php if($results['modulo_pacientes']==1):
                ?>
                    <input type="radio" id="customRadioInline5" name="accessoModulo" class="custom-control-input" value="ModuloPacientes" checked="true">
                <?php else:?>
                    <input type="radio" id="customRadioInline5" name="accessoModulo" class="custom-control-input" value="ModuloPacientes">
                <?php endif;?>
                <label class="custom-control-label" for="customRadioInline5">Modulo Pacientes</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <?php if($results['modulo_seguridad']==1):
                ?>
                    <input type="radio" id="customRadioInline6" name="accessoModulo" class="custom-control-input" value="Seguridad" checked="true">
                <?php else:?>
                    <input type="radio" id="customRadioInline6" name="accessoModulo" class="custom-control-input" value="Seguridad">
                <?php endif;?>
                <label class="custom-control-label" for="customRadioInline6">Seguridad</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <?php if($results['paciente']==1):
                ?>
                    <input type="radio" id="customRadioInline7" name="accessoModulo" class="custom-control-input" value="Paciente" checked="true">
                <?php else:?>
                    <input type="radio" id="customRadioInline7" name="accessoModulo" class="custom-control-input" value="Paciente">
                <?php endif;?>
                <label class="custom-control-label" for="customRadioInline7">Paciente</label>
            </div>
            </div>

            <label class="font-weight-bold mt-4">Elige el scope de esta nueva credencial</label>
            <hr class="mt-1 mb-4 mr-5">
            <div class="form-row">               
                <div class="form-group col-md-6">
                <label for="scope">Scopes</label>
                <select id="scope" name="scope" class="form-control" required>
                    <option selected value="<?php echo $results["id_scope_credencial"]?>"><?php echo $results["descripcion_rol"]?></option>
                    <option disabled value="">Seleccione...</option>
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
            <a href="credencial.php" id="cancelar" type='button' class="btn btn-light border-secondary">Cancelar</a>
            <button id='btn' name='btn' type='button' class='btn btn-primary font-weight-bold' style="width:200px;">Guardar</button>
            </div> 
        </form>       
        
      </div>
    </main>
    <?php 
        printModal('Acualizar Credencial Base','btn-actualizar','modal-actualizar','¡Hey!. Estas apunto de ACTUALIZAR esta CREDECNIAL, esto podria afectar a usuarios asociados a esta. ¿Realmente desea ACTUALIZARLA la CREDENCIAL?');
    ?>
    
</div>
<script src="../components/scripts/jquery.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="../components/scripts/dashboard.js"></script> 
<script src="../components/scripts/consulta.js"></script>    
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
