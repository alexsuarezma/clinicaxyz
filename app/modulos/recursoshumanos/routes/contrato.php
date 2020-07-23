<?php
  require '../components/layout.php';
  require '../../seguridad/controllers/functions/credenciales.php';

  verificarAcceso("../../../../", "modulo_rrhh");
  
  ?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Recursos Humanos | Contrato</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">    
    <!-- Custom styles for this template -->
    <link href="../assets/styles/component/dashboard.css" rel="stylesheet">
    <link href="../assets/styles/component/contrato.css" rel="stylesheet">
</head>
  <body>
<?php          
  // printLayout ($route, $homePage, $createPage, $personalPage, $reclutamiento, $historialPersonal, $asistencia,
  // $logout,$ajuste,$rrhh,$suministro,$contabilidad,$ctas_medicas,$paciente,$seguridad);
  printLayout('../index.php', '../../../../index.php', 'contrato.php', 'personal.php', 
  'reclutamiento.php', 'historialPersonal.php','listaAsistencias.php','../../seguridad/controllers/logout.php','../../seguridad/routes/perfil.php',
  '../index.php','../../suministro/','../../contabilidad/','../../citasmedicas/','../../pacientes/','../../seguridad/');
?>
<div class="container-fluid">
  <div class="row">
     <main role="main" style="" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="container mt-5" >
          <div class="widget mt-5" style="display: flex; align-items: center; justify-content: center;">
              <div class="card">
                  <div class="face face1">
                      <div class="content">
                          <div class="icon">
                              <i class="fa fa-address-book" aria-hidden="true"></i>
                          </div>
                      </div>
                  </div>
                  <div class="face face2">
                      <div class="content">
                          <h3>
                              <a href="create.php">Registro de empleado</a>
                          </h3>                     
                      </div>
                  </div>
              </div>
          </div>
        </div>
    </main>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="../components/scripts/dashboard.js"></script>      
</body>
</html>




