<?php
require '../components/LayoutAdmin.php';
require '../../../../database.php';
require '../../seguridad/controllers/functions/credenciales.php';

verificarAcceso("../../../../", "modulo_pacientes");
$paciente = $conn->query("SELECT * FROM pacientes ORDER BY idpacientes ASC")->fetchAll(PDO::FETCH_OBJ);
$tipoExamen = $conn->query("SELECT * FROM tipo_examen ORDER BY descripcion ASC")->fetchAll(PDO::FETCH_OBJ);

?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Modulo Pacientes | Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../../recursoshumanos/assets/styles/component/dashboard.css" rel="stylesheet">
    <script>
    UPLOADCARE_LOCALE= "es";
    UPLOADCARE_LIVE = false;
    UPLOADCARE_PUBLIC_KEY = '24db6afbb6723ce93852';
    UPLOADCARE_PREVIEW_STEP = true;
    UPLOADCARE_TABS = "file url";
  </script>

  <script src="https://ucarecdn.com/libs/widget/3.x/uploadcare.full.min.js"></script>

  </head>
  <body>
<?php
printLayout ('../index.php', '../../../../index.php', 'registrar.php', '../../citasmedicas/historial_clinico.php','../../citasmedicas/citas.php', 'visualizarPaciente.php', 'pacientesBaja.php', 'pagos.php','subirArchivo.php',
'../../seguridad/controllers/logout.php','../../seguridad/routes/perfil.php',
  '../../recursoshumanos/','../../suministro/','../../contabilidad/','../../citasmedicas/','../index.php','../../seguridad/',8);
?>
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Subida de Archivos</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        </div>
      </div>
      <div class="container mt-5">
        <div class="shadow-sm p-3 mb-5 bg-white rounded">
            <form id="upload-archivo" action="../controllers/insertArchivoPaciente.php" onsubmit="onSubmit(event)" method="post" autocomplete="off">
                <div class="form-group col-md-12 mt-5" style="margin-top:23px;" id="imageEdit">
                    <label class="font-weight-bold">Selecciona el archivo que deseas subir <span class="text-danger">*campo requerido</span></label>
                    <div class="custom-file" style="margin-top:13px;">
                        <input type="hidden"  name="archivo" id="archivo" role="uploadcare-uploader" data-crop="" data-clearable="true" data-file-types="pdf jpg jpeg png" data-input-accept-types=".pdf, .jpg, .jpeg, .png" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="search">Cedula</label>
                        <input type="text" class="form-control" name="search" id="search" placeholder="Busca por cedula" onkeypress="return soloNumeros(event)" maxlength="10" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6" id="print-paciente">
                        
                    </div>
                    <div class="form-group col-md-6">
                        <label for="tipo">Tipo</label>
                        <select id="tipo" name="tipo" class="form-control" required>
                          <option selected disabled value="">Seleccione...</option>
                          <?php
                            foreach ($tipoExamen as $Examenes):
                          ?>
                            <option value="<?php echo $Examenes->id_tipo_examen;?>"><?php echo utf8_encode($Examenes->descripcion);?></option>
                          <?php 
                            endforeach;
                          ?> 
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary" style="width:200px;">Subir</button>
                </div>
            </form>
        </div>
      </div>
    </main>
  </div>
</div>
<div class='modal fade' name='modal-success' id='modal-success' data-backdrop='static' data-keyboard='false' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabe' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                  <h5 class='modal-title' id='staticBackdropLabel'>REGISTRO SATISFACTORIO</h5>
                  
                </div>
                <div class='modal-body mb-5'>
                    <div class="container d-flex flex-column" style="width:100%;">
                        <div id="icon-message" class="container d-flex justify-content-center align-items-center mb-5 mt-4" style="width:100%;">
                            <!-- ICONO -->
                        </div>
                        <div class="container d-flex justify-content-center align-items-center" style="width:100%;">                            
                            <div id="message">
                                <!-- MESSAGE -->
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="../../recursoshumanos/components/scripts/dashboard.js"></script>    
<script src="../../seguridad/controllers/validations/validations.js"></script>    
<script src="../components/scripts/paciente.js"></script>    
<script>
function fileTypeLimit(types) {
  types = types.split(' ')

  return function(fileInfo) {
    if (fileInfo.name === null) {
      return
    }
    var extension = fileInfo.name.split('.').pop()

    if (types.indexOf(extension) == -1) {
      throw new Error('fileType')
    }
  }
}

$(function() {
  $('[role=uploadcare-uploader][data-file-types]').each(function() {
    var input = $(this)
    var widget = uploadcare.Widget(input)

    widget.validators.push(fileTypeLimit(input.data('file-types')))
  })
})

UPLOADCARE_LOCALE_TRANSLATIONS = {
  // messages for widget
  errors: {fileType: 'This type of files is not allowed.'},
  // messages for dialog’s error page
  dialog: {
    tabs: {
      preview: {
        error: {
          fileType: {
            title: 'Debes escoger solo archivos de tipo IMAGE o PDF.',
            text: 'Porfavor, vuelve a cargar un archivo distinto.',
            back: 'Atras',
          },
        },
      },
    },
  },
}

$(document).ready(()=>{
  $('#search').autocomplete({
      source: (request, response)=>{
        $.ajax({
            url: "../controllers/consultas/pacientes.php",
            dataType: "json",
            data: {q:request.term},
            success: (data)=>{
              response(data);
            }
        }) 
      },
      minLength: 1,
      select: (event,ui)=>{
          buscarPaciente(ui.item.label.substr(0,10))
      }
  });
})


</script>      
</body>
</html>
