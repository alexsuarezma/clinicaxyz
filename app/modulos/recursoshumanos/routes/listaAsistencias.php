<?php
require '../../../../database.php';
require '../components/layout.php';
require '../../seguridad/controllers/functions/credenciales.php';
require '../controllers/functions/getSemanas.php';
date_default_timezone_set('America/Guayaquil');
verificarAcceso("../../../../", "modulo_rrhh");
$today = date("Y-m-d");

$horasTrabajadas = "0000-00-00 00:00:00";
$horasRetraso = "0000-00-00 00:00:00";
$day=date('d');
$inicio="";
$fin="";
//TODAY
$asistencia = $conn->query("SELECT * FROM asistencia_empleado AS a, empleados AS e WHERE a.id_empleado_asis = e.id_empleados AND start = '$today' ORDER BY start ASC")->fetchAll(PDO::FETCH_OBJ);

if(isset($_POST['id'])){
    $name = $conn->query("SELECT nombres,apellidos,jornada,inicio,finalizacion FROM empleados AS e, cargo_empleados AS c, horario_empleado AS h, cargo_horario AS ch WHERE (e.id_cargo_horario_emp = ch.id_cargo_horario 
    AND ch.id_horario_ch = h.id_horario_empleado) AND id_empleados=".$_POST['id'])->fetchAll(PDO::FETCH_OBJ);
        if($_POST['rango']=='hoy' || $_POST['rango']=='ayer'){
            if($_POST['rango']=='ayer'){
                $day=$day-1;
            }

        }elseif($_POST['rango']=='semana' || $_POST['rango']=='mes' || $_POST['rango']=="anio"){
            $semanas=semanasMes(date("m"),date("Y"));
            //  TENGO QUE SABER EN QUE DIA ESTOY PARA SABER EN QUE SEMANA ESTOY
            if($_POST['rango']=='semana'){
                $i=0;
                $bool=true;
                while($bool){
                    if(date('d')>=$semanas[$i]['inicio'] && date('d')<=$semanas[$i]['fin']){
                        break;
                    }
                    $i++;
                }

                $inicio=$semanas[$i]['inicio'];
                $fin=$semanas[$i]['fin'];
            }

            if($_POST['rango']=='mes'){
                $count=sizeof(semanasMes(date("m"),date("Y")));
                $inicio=$semanas[0]['inicio'];
                $fin=$semanas[$count-1]['fin'];
            }

            $inicio=date('Y')."-".date('m')."-".$inicio;
            $fin=date('Y')."-".date('m')."-".$fin;

            if($_POST['rango']=='anio'){
                $inicio=date('Y')."-01-01";
                $fin=date('Y')."-12-31";
            }

        }

        if($_POST['estadoBusqueda']=="Indistinto"){
            if($_POST['rango']=='hoy' || $_POST['rango']=='ayer'){
            
                $day=date('Y')."-".date('m')."-".$day;
                $asistencia = $conn->query("SELECT * FROM asistencia_empleado AS a, empleados AS e WHERE a.id_empleado_asis = e.id_empleados AND id_empleado_asis=".$_POST['id']." AND start = '$day' ORDER BY start ASC")->fetchAll(PDO::FETCH_OBJ);

            }elseif($_POST['rango']=='semana' || $_POST['rango']=='mes' || $_POST['rango']=="anio"){
                

                $asistencia = $conn->query("SELECT * FROM asistencia_empleado AS a, empleados AS e WHERE a.id_empleado_asis = e.id_empleados AND id_empleado_asis=".$_POST['id']." AND start BETWEEN '$inicio' AND '$fin' ORDER BY start ASC")->fetchAll(PDO::FETCH_OBJ);
            }

        }else{

            $asistencia = $conn->query("SELECT * FROM asistencia_empleado AS a, empleados AS e WHERE a.id_empleado_asis = e.id_empleados AND id_empleado_asis=".$_POST['id']." AND title='".$_POST['estadoBusqueda']."' AND start BETWEEN '$inicio' AND '$fin' ORDER BY start ASC")->fetchAll(PDO::FETCH_OBJ);
        }
}


if(isset($_POST['jornada'])){
    $jornada='';
        if($_POST['rango']=='hoy' || $_POST['rango']=='ayer'){
            if($_POST['rango']=='ayer'){
                $day=$day-1;
            }

        }elseif($_POST['rango']=='semana' || $_POST['rango']=='mes' || $_POST['rango']=="anio"){
            $semanas=semanasMes(date("m"),date("Y"));
            //  TENGO QUE SABER EN QUE DIA ESTOY PARA SABER EN QUE SEMANA ESTOY
            if($_POST['rango']=='semana'){
                $i=0;
                $bool=true;
                while($bool){
                    if(date('d')>=$semanas[$i]['inicio'] && date('d')<=$semanas[$i]['fin']){
                        break;
                    }
                    $i++;
                }

                $inicio=$semanas[$i]['inicio'];
                $fin=$semanas[$i]['fin'];
            }

            if($_POST['rango']=='mes'){
                $count=sizeof(semanasMes(date("m"),date("Y")));
                $inicio=$semanas[0]['inicio'];
                $fin=$semanas[$count-1]['fin'];
            }

            $inicio=date('Y')."-".date('m')."-".$inicio;
            $fin=date('Y')."-".date('m')."-".$fin;

            if($_POST['rango']=='anio'){
                $inicio=date('Y')."-01-01";
                $fin=date('Y')."-12-31";
            }

        }

        if($_POST['jornada']!='Indistinto'){
            $jornada = "AND h.jornada='".$_POST['jornada']."'";
        }
//EDIT!!!
        if($_POST['estadoBusqueda']=="Indistinto"){
            if($_POST['rango']=='hoy' || $_POST['rango']=='ayer'){
            
                $day=date('Y')."-".date('m')."-".$day;
                $asistencia = $conn->query("SELECT * FROM empleados AS e, cargo_empleados AS c, cargo_horario AS ch, horario_empleado AS h, asistencia_empleado AS a  WHERE (a.id_empleado_asis = e.id_empleados AND e.id_cargo_horario_emp = ch.id_cargo_horario AND ch.id_horario_ch = h.id_horario_empleado) $jornada AND start = '$day' ORDER BY start ASC")->fetchAll(PDO::FETCH_OBJ);

            }elseif($_POST['rango']=='semana' || $_POST['rango']=='mes' || $_POST['rango']=="anio"){
                
                $asistencia = $conn->query("SELECT * FROM empleados AS e, cargo_empleados AS c, cargo_horario AS ch, horario_empleado AS h, asistencia_empleado AS a  WHERE (a.id_empleado_asis = e.id_empleados AND e.id_cargo_horario_emp = ch.id_cargo_horario AND ch.id_horario_ch = h.id_horario_empleado) $jornada  AND (start BETWEEN '$inicio' AND '$fin') ORDER BY start ASC")->fetchAll(PDO::FETCH_OBJ);
            }

        }else{

            $asistencia = $conn->query("SELECT * FROM empleados AS e, cargo_empleados AS c, cargo_horario AS ch, horario_empleado AS h, asistencia_empleado AS a  WHERE (a.id_empleado_asis = e.id_empleados AND e.id_cargo_horario_emp = ch.id_cargo_horario AND ch.id_horario_ch = h.id_horario_empleado) $jornada AND (title='".$_POST['estadoBusqueda']."' AND start BETWEEN '$inicio' AND '$fin') ORDER BY start ASC")->fetchAll(PDO::FETCH_OBJ);
        }
}

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
    printLayout('../index.php', '../../../../index.php', 'contrato.php', 'personal.php', 
    'reclutamiento.php', 'historialPersonal.php','listaAsistencias.php','../../seguridad/controllers/logout.php','../../seguridad/routes/perfil.php',
    '../index.php','../../suministro/','../../contabilidad/','../../citasmedicas/','../../pacientes/','../../seguridad/',4);
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
            <?php
                if(isset($_POST['id'])):
            ?>
                <h6 class="font-weight-bold">Empleado: </h6> <?php echo $name[0]->nombres." ".$name[0]->apellidos ?></br></br>
                <span class="font-weight-bold"><?php echo $name[0]->jornada ?></span></br>
                <?php echo $name[0]->inicio." - ".$name[0]->finalizacion ?>
            <?php
                endif;
            ?>
      <div class="float-right">
        <form action="listaAsistencias.php" method="post">
            <div class="form-row">
            <?php
                if(isset($_POST['id'])):
            ?>
                <input type="hidden" name="id" value="<?php echo $_POST['id']?>">
            <?php
                else:
            ?>
                <div class="form-group col-md-3">
                    <label for="jornada">Jornada</label>
                    <select class="custom-select" name="jornada" id="jornada" required>
                        <option selected disabled value="">Seleccione...</option>
                        <option value="Completa">Completa</option>
                        <option value="Matutino">Matutino</option>
                        <option value="Vespertino">Vespertino</option>
                        <option value="Indistinto">Indistinto</option>
                    </select>
                </div>
            <?php
                endif;
            ?>
                <div class="form-group col-md-3">
                    <label for="estadoBusqueda">Estado</label>
                    <select class="custom-select" name="estadoBusqueda" id="estadoBusqueda" required>
                    <?php
                        if(isset($_POST['estadoBusqueda'])):
                    ?>
                        <option selected disabled value=""><?php echo $_POST['estadoBusqueda']?></option>
                        <option disabled value="">Seleccione...</option>
                    <?php
                        else:
                    ?>
                        <option selected disabled value="">Seleccione...</option>
                    <?php
                        endif;
                    ?>

                        <option value="Puntual">Puntual</option>
                        <option value="Atrasado">Atrasado</option>
                        <option value="Indistinto">Indistinto</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="rango">Escoge el rango</label>
                    <select class="custom-select" name="rango" id="rango" required>
                    <?php
                        if(isset($_POST['rango'])):
                    ?>
                        <option selected disabled value=""><?php 
                            if($_POST['rango']=='anio'):
                                echo 'Este año';
                            else:
                                echo $_POST['rango'];
                            endif;    
                        ?></option>
                        <option disabled value="">Seleccione...</option>
                    <?php
                        else:
                    ?>
                        <option selected disabled value="">Seleccione...</option>
                    <?php
                        endif;
                    ?>
                        <option value="hoy">Hoy</option>
                        <option value="ayer">Ayer</option>
                        <option value="semana">Esta Semana</option>
                        <option value="mes">Este Mes</option>
                        <option value="anio">Este Año</option>
                    </select>
                </div>
                <div class="form-group col-md-2" style="margin-top:28px;">
            <button id='enviar' name='enviar' type='submit' class='btn btn-primary font-weight-bold' style="width:100px;">Buscar</button>
                </div>
            </div>
        </form>
        
      </div>
    </div>
        <div class="container mt-5" >
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
                                        <th>Total horas</th>
                                        <th>Tiempo de Atraso</th>
                                        <th>Tiempo Salida Anticipada</th>
                                        <th style="width:200px;">Nombres del Empleado</th>
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
                                        <td style="width:60px;">
                                            <?php 
                                                if($Asistencias->hora_salida == null):
                                                    echo '<span class="font-weight-bold text-danger">No Marco Salida</span>';
                                                else:
                                                    echo $Asistencias->hora_salida;
                                                endif;
                                            
                                            ?>
                                        </td>
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
                                        <td><?php 
                                            if($Asistencias->hora_salida != null):
                                                $totalDia = "00:00:00";
                                                $horaA= new DateTime($Asistencias->hora_entrada);
                                                $horaB= new DateTime($Asistencias->hora_salida);
                                                $diferent = $horaB->diff($horaA);
                                                $totalDia = strtotime( $diferent->format('%H hours %i minutes %s seconds'),strtotime( $totalDia));
                                                $totalDia   =  date ( 'H:i:s' , $totalDia );
                                                echo $totalDia;
                                            else:
                                                echo '<span class="text-danger ml-4">?</span>';
                                            endif;
                                            ?></td>
                                        <td><?php echo $Asistencias->atraso_asis?></td>
                                        <td><?php echo $Asistencias->salida_antes_asis?></td>
                                        <th style="width:200px;"><?php echo $Asistencias->nombres.' '.$Asistencias->apellidos;?></th>
                                    </tr>
                                <?php
                                        
                                            if(isset($_POST['id'])):
                                       
                                                    if($Asistencias->hora_salida != null){
                                                        $horaEntrada = new DateTime($Asistencias->hora_entrada);//horaEntrada
                                                        $horaSalida = new DateTime($Asistencias->hora_salida);//horaMarca

                                                        $diferencia = $horaSalida->diff($horaEntrada);
                                                        
                                                        $horasTrabajadas  = strtotime ( $diferencia->format('%H hours %i minutes %s seconds'), strtotime ( $horasTrabajadas ) ) ;  
                                                        $horasTrabajadas   =  date ( 'H:i:s' , $horasTrabajadas );
                                                    }
                                                    //ACUMULACIÓN DE ATRASOS
                                                    if($Asistencias->atraso_asis != null){
                                                        $horaEntradaRetraso = new DateTime($Asistencias->atraso_asis);//horaEntrada
                                                        $horaAux = new DateTime('00:00:00');//horaMarca
                                                        $diferencia = $horaAux->diff($horaEntradaRetraso);
                                                        $horasRetraso  = strtotime ( $diferencia->format('%H hours %i minutes %s seconds'), strtotime ( $horasRetraso ) ) ;  
                                                        $horasRetraso   =  date ( 'Y-m-d H:i:s' , $horasRetraso );
                                                    }
                                            endif;
                                            
                                    endforeach;
                                ?> 
                                </tbody>
                            </table>
                            <?php
                                if(isset($_POST['id'])):
                            ?>
                                <hr class="mt-1 mb-4 ml-5">
                                <div class="d-flex justify-content-end mr-5">
                                    <div class="mr-5"><span style="font-size:14px;" class="badge badge-danger">Horas de retraso: </span> <span ><?php echo substr($horasRetraso,-11);?></span></div>
                                    <div class="mr-5"><span style="font-size:14px;" class="badge badge-success">Horas Trabajadas: </span> <span ><?php echo substr($horasTrabajadas,-11);?></span></div>
                                </div>
                            <?php
                                endif;
                            ?>
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

