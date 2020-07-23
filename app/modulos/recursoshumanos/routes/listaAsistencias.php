<?php
require '../../../../database.php';
require '../components/layout.php';
require '../../seguridad/controllers/functions/credenciales.php';

verificarAcceso("../../../../", "modulo_rrhh");

    $asistencia = $conn->query("SELECT * FROM asistencia_empleado AS a, empleados AS e WHERE a.id_empleado_asis = e.id_empleados ORDER BY start ASC")->fetchAll(PDO::FETCH_OBJ);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link href="../assets/styles/component/dashboard.css" rel="stylesheet">
    <title>Recursos Humanos | Asistencias</title>
    <style>
            .project-list > tbody > tr > td {
            padding: 12px 8px;
            }

            .project-list > tbody > tr > td .avatar {
            
            border: 1px solid #CCC;
            }
    </style>
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

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">LISTA DE ASISTENCIA</h1>
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
    <div class="container mt-4 mb-5">
      <div class="float-right">
        <div style="width:200px;" class="mb-3">
            <select class="custom-select" name="area" id="area" required>
                <option selected disabled value="">Buscar...</option>
                <option value="Mes">Este mes</option>
                <option value="Semana">Esta semana</option>
                <option value="Total">Asistencia Total</option>
            </select>
        </div>
      </div>
    </div>
        <div style="max-width:1500px;" class="container mt-5" >
            <div class="container bootstrap snippet">
                    <div class="table-responsive">
                        <!-- PROJECT TABLE  -->
                            <table class="table colored-header datatable project-list">
                                <thead>
                                    <tr>
                                        <th style="width:100px;">Fecha</th>
                                        <th>Día</th>
                                        <th style="width:60px;">Hora/Marco Entrada</th>
                                        <th style="width:60px;">Hora/Marco Salida</th>
                                        <th>Jornada</th>
                                        <th>Estado</th>
                                        <th>Tiempo de Atraso</th>
                                        <th>Tiempo Salida Anticipada</th>
                                        <th>Nombres del Empleado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($asistencia as $Asistencias):
                                ?>
                                    <tr>
                                        <th style="width:100px;"><?php echo $Asistencias->start?></th>
                                        <td><?php echo $Asistencias->dia_semana?></td>
                                        <td style="width:60px;"><?php echo $Asistencias->hora_entrada?></td>
                                        <td style="width:60px;"><?php echo $Asistencias->hora_salida?></td>
                                        <td><?php echo $Asistencias->jornada?></td>
                                            <?php
                                                if($Asistencias->title == "Puntual"):
                                            ?>
                                                <td><span class="badge badge-success" style="font-size:14px;"><?php echo $Asistencias->title?></span></td>
                                            <?php
                                                elseif($Asistencias->title == "Atrasado"):
                                            ?>
                                                <td><span class="badge badge-danger" style="font-size:14px;"><?php echo $Asistencias->title?></span></td>
                                            <?php
                                                endif;
                                            ?>
                                        <td><?php echo $Asistencias->atraso_asis?></td>
                                        <td><?php echo $Asistencias->salida_antes_asis?></td>
                                        <th><?php echo $Asistencias->nombres.' '.$Asistencias->apellidos;?></th>
                                    </tr>
                                <?php
                                        // if($Asistencias->hora_salida != null){
                                        //     $horaEntrada = new DateTime($Asistencias->hora_entrada);//horaEntrada
                                        //     $horaSalida = new DateTime($Asistencias->hora_salida);//horaMarca

                                        //     $diferencia = $horaSalida->diff($horaEntrada);
                                            
                                        //     $horasTrabajadas  = strtotime ( $diferencia->format('%H hours %i minutes %s seconds'), strtotime ( $horasTrabajadas ) ) ;  
                                        //     $horasTrabajadas   =  date ( 'H:i:s' , $horasTrabajadas );
                                        // }
                                        // //ACUMULACIÓN DE ATRASOS
                                        // if($Asistencias->atraso_asis != null){
                                        //     $horaEntradaRetraso = new DateTime($Asistencias->atraso_asis);//horaEntrada
                                        //     $horaAux = new DateTime('00:00:00');//horaMarca
                                        //     $diferencia = $horaAux->diff($horaEntradaRetraso);

                                        //     $horasRetraso  = strtotime ( $diferencia->format('%H hours %i minutes %s seconds'), strtotime ( $horasRetraso ) ) ;  
                                        //     $horasRetraso   =  date ( 'H:i:s' , $horasRetraso );
                                        // }
                                        
                                    endforeach;
                                ?> 
                                </tbody>
                            </table>
                        <!-- END PROJECT TABLE -->
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