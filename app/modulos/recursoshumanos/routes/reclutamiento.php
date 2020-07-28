<?php 
require '../../../../database.php'; 
require '../components/layout.php';
require '../components/modal.php';
require '../../seguridad/controllers/functions/credenciales.php';

    verificarAcceso("../../../../", "modulo_rrhh");
        $results = $conn->query("SELECT * FROM aspirantes")->fetchAll(PDO::FETCH_OBJ);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recursos Humanos | Reclutamiento</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet"> 
    <!-- Custom styles for this template -->
    <link href="../assets/styles/component/dashboard.css" rel="stylesheet">
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
    // printLayout ($route, $homePage, $createPage, $personalPage, $reclutamiento, $historialPersonal, $asistencia,
    // $logout,$ajuste,$rrhh,$suministro,$contabilidad,$ctas_medicas,$paciente,$seguridad);
    printLayout('../index.php', '../../../../index.php', 'contrato.php', 'personal.php', 
    'reclutamiento.php', 'historialPersonal.php','listaAsistencias.php','../../seguridad/controllers/logout.php','../../seguridad/routes/perfil.php',
    '../index.php','../../suministro/','../../contabilidad/','../../citasmedicas/','../../pacientes/','../../seguridad/',5);
?>
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Perfil de Aspirantes </h1>
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
      <input type="search" name="busqueda" id="busqueda" placeholder="Busca por cedula, nombres, apellidos, cargo al que postula..." title="Type in a name">
    </div>
            <div class="container mt-5" >
                <ul class="list-group">
          
                      <?php
                        foreach ($results as $aspirante):?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span id="cedulaAspirante"><?php echo $aspirante->id_aspirante?></span>
                        <span class='font-weight-bold'>Aspirante: <span class="font-weight-light"><?php echo $aspirante->nombres?> <?php echo $aspirante->apellidos?></span></span>
                        <span>
                          <span class='font-weight-bold'>Cargo al que postula: <span class="font-weight-light"><?php echo $aspirante->cargo_postula?></span></span>
                        </span>
                        <span class='font-weight-bold'>|Enviado desde: <span class="font-weight-light"><?php echo $aspirante->created_at?></span>|</span>
                        <span>
                        <a href="../components/viewDocuments.php?contrato=<?php echo $aspirante->fileDocument?>" ><i class="fas fa-file-contract" style="color:black;" title="Ver Curriculum" ></i></a>
                        <a href="../components/viewAspirante.php?id=<?php echo $aspirante->id_aspirante?>" ><i class="fas fa-external-link-alt" style="color:blue;" title="Ver Informacion"></i></a>
                        <a id="delete" href="#"><i class="fas fa-trash-alt" style="color:red;" title="Eliminar Aspirante"></i></a>
                        </span>
                        </li>
                      <?php 
                        endforeach;
                      ?>    
                </ul>
            </div>
            <?php          
                      printModal('Eliminar Aspirante','btn-delete','modal-delete','¡Hey!. Estas apunto de ELIMINAR información sensible. ¿Realmente desea ELIMINAR los datos de este aspirante?');
            ?>
     </main>
   </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <script src="../components/scripts/dashboard.js"></script>      
  <!-- <script type="text/javascript" src="../components/scripts/jquery.min.js"></script>    
  <script type="text/javascript" src="../components/scripts/searchFilter.js"></script>       -->
  <script>
    $(document).ready(function(){
        $('#delete').click(function(){
            $("#modal-delete").modal('show');
            $('#btn-delete').click(function(){
              location.href=`../controllers/deleteFisic.php?id=${$('#cedulaAspirante').text()}&aspirante=si`;
            });
            
        });
     });
  </script>
</body>
</html>