<?php 
    require '../../../../database.php'; 
    require '../components/layout.php';
    require '../components/modal.php';
    require '../../seguridad/controllers/functions/credenciales.php';

    verificarAcceso("../../../../", "modulo_rrhh");
        $results = $conn->query("SELECT * FROM empleados AS e, cargo_empleados AS c, horario_empleado AS h, cargo_horario AS ch, area_empleados AS a, ciudades AS ci WHERE (e.id_cargo_horario_emp = ch.id_cargo_horario 
        AND ch.id_horario_ch = h.id_horario_empleado AND ch.id_cargo_ch = c.id_cargo AND c.id_area_cargo = a.id_area AND ci.idciudades = e.id_ciudad_emp) AND (deleted=1) ORDER By id_empleados LIMIT 25")->fetchAll(PDO::FETCH_OBJ);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recursos Humanos | Historial</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

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
  '../index.php','../../suministro/','../../contabilidad/','../../citasmedicas/','../../pacientes/','../../seguridad/',6);
?>
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Historial de personal contratado</h1>
            <h5 id="personal" style="display: none"><?php echo $_GET["pers"] ?></h5>
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
        <input type="text" name="busqueda" id="busqueda" placeholder="Busca por cedula, nombres, apellidos, cargo, personal, area..." title="Type in a name">
    </div>
            <div class="container mt-5" >
                <ul class="list-group">
                      <?php
                        foreach ($results as $empleados):?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span id="cedula"><?php echo $empleados->id_empleados?></span>
                        <span style="text-decoration: line-through;"><?php echo $empleados->nombres?> <?php echo $empleados->apellidos?></span>
                        <span>
                          <span class='font-weight-bold'>Cargo: <span class="font-weight-light"><?php echo $empleados->nombre_cargo?></span>-</span>
                          <span class='font-weight-bold'>Personal: <span class="font-weight-light"><?php echo $empleados->jornada?></span>-</span>
                          <span class='font-weight-bold'>Area: <span class="font-weight-light"><?php echo $empleados->nombre_area?></span></span>
                        </span>
                        <span class='font-weight-bold'>|Descontratado desde: <span class="font-weight-light"><?php echo $empleados->update_at?></span>|</span>
                        <span>
                        <a href="../components/viewEmpleado.php?id=<?php echo $empleados->id_empleados?>" ><i class="fas fa-external-link-alt" style="color:blue;" title="Ver Informacion"></i></a>
                        <?php if(verificarAccion($conn, "modulo_rrhh", "borrado_logico") == true):?>
                          <a name="delete-fisic" id="delete-fisic" href="#" ><i class="fas fa-trash-alt" style="color:red;" title="Eliminar Registro Fisicamente"></i></a>
                        <?php endif;?>
                        </span>
                        </li>
                      <?php 
                        endforeach;
                      ?>    
                    
                    
                    
                </ul>
            </div>
            <?php
                printModal('Borrar registro fisicamente','btn-delete-fisic','modal-delete-fisic','¡Hey!. Estas apunto de ELIMINAR información sensible. ¿Realmente desea eliminar todo los historial de registros fisicos del empleado?');
            ?>
          
     </main>
   </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <script src="../components/scripts/dashboard.js"></script>
  <script>
    $(document).ready(function(){
          $('#delete-fisic').click(function(){
            $("#modal-delete-fisic").modal('show');
            $('#btn-delete-fisic').click(function(){
              location.href=`../controllers/deleteFisic.php?id=${$('#cedula').text()}`;
            });  
        });
    });
  </script>         
  <!-- <script type="text/javascript" src="../components/scripts/jquery.min.js"></script>    
  <script type="text/javascript" src="../components/scripts/searchFilter.js"></script>       -->
  
</body>
</html>