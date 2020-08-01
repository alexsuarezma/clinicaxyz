<?php
require '../../../../database.php';
session_start();
$id = $_SESSION['cedula'];  
    $asistencia = $conn->query("SELECT * FROM asistencia_empleado WHERE id_empleado_asis = $id ORDER BY start ASC")->fetchAll(PDO::FETCH_OBJ);
    $horasTrabajadas = "00:00:00";
    $horasRetraso = "00:00:00";
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/moment.min.js"></script>

    <link rel="stylesheet" href="../assets/css/fullcalendar.min.css">
    <script src="../assets/js/fullcalendar.min.js"></script>
    <script src="../assets/js/es.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>
<body>
  <h1>ASISTENCIA</h1>
  <input type="hidden" id="cedula" value="<?php echo $_SESSION['cedula']?>">
    <div class="container mt-5">
        <div class="row">
            <div class="col"></div>
            <div class="col-10">
                <div id="calendar">

                </div>
            </div>
            <div class="col"></div>
        </div>
    </div>
      <?php
          foreach ($asistencia as $Asistencias):
      
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

                  $horasRetraso = strtotime ( $diferencia->format('%H hours %i minutes %s seconds'), strtotime ( $horasRetraso ) ) ;  
                  $horasRetraso = date ( 'H:i:s' , $horasRetraso );
              }
              
          endforeach;
      ?> 
      <!-- END PROJECT TABLE -->
      <hr class="mt-1 mb-4 ml-5">
      <div class="d-flex justify-content-end mr-5">
          <div class="mr-5"><span style="font-size:14px;" class="badge badge-danger">Horas de retraso: </span> <span ><?php echo $horasRetraso;?></span></div>
          <div class="mr-5"><span style="font-size:14px;" class="badge badge-success">Horas Trabajadas: </span> <span ><?php echo $horasTrabajadas;?></span></div>
      </div>
    <script>
        $(document).ready(function(){
            //AGREGAR BOTONES Y POSICIONAMIENTO
            $('#calendar').fullCalendar({
                header: {
                    left:'today,prev,next,Miboton',
                    center:'title',
                    right:'month,basicWeek,basicDay'
                },
                customButtons:{
                    Miboton:{
                        text:"Buscar",
                        click:function(){
                            $("#busqueda").modal();
                        }
                    }  
                }, 
                    //MARCAR EVENTOS
                events:`../controllers/consultaAsistencia.php?cedula=${$('#cedula').val()}`,
                eventClick:function(calEvent,jsEvent,view){
                    $('#tituloEvento').html(`${calEvent.nombres} ${calEvent.apellidos}`);
                    $('#horaEntrada').html(calEvent.hora_entrada);
                    $('#horaSalida').html(calEvent.hora_salida);
                    $('#dia').html(calEvent.dia_semana);
                    $('#jornada').html(calEvent.jornada);
                    $('#estado').html(calEvent.title);
                    $('#atraso').html(calEvent.atraso_asis);
                    $('#salidaAnticipada').html(calEvent.salida_antes_asis);
                    $("#datosAsistencia").modal();
                }
            });
        });
    </script>

<div class='modal fade' name='busqueda' id='busqueda' data-backdrop='static' data-keyboard='false' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabe' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='staticBackdropLabel'>Busqueda </h5>
                    </button>
                </div>
                <div class='modal-body'>
                    <form method="POST" action="listaAsistencias.php" class="ml-2 mr-2">
                        <label class="font-weight-bold">Selección a tu busqueda</label>
                        <input type="hidden" name="id" value="<?php echo $_SESSION['cedula']?>" required>
                        <hr class="mt-1 mb-4 mr-5">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="estadoBusqueda">Estado</label>
                                <select class="custom-select" name="estadoBusqueda" id="estadoBusqueda" required>
                                <option selected disabled value="">Seleccione...</option>
                                    <option value="Puntual">Puntual</option>
                                    <option value="Atrasado">Atrasado</option>
                                    <option value="Indistinto">Indistinto</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="rango">Escoge el rango</label>
                                <select class="custom-select" name="rango" id="rango" required>
                                <option selected disabled value="">Seleccione...</option>
                                    <option value="hoy">Hoy</option>
                                    <option value="ayer">Ayer</option>
                                    <option value="semana">Esta Semana</option>
                                    <option value="mes">Esta Mes</option>
                                    <option value="anio">Este Año</option>
                                </select>
                            </div>
                        </div>
                        <div class='modal-footer mt-2'>
                            <button id="cancelar" type='button' class="btn btn-light border-secondary" data-dismiss='modal'>Cancelar</button>
                            <button id='enviar' name='enviar' type='submit' class='btn btn-primary font-weight-bold' style="width:200px;">Buscar</button>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>


<div class="modal fade" id="datosAsistencia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tituloEvento">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="ml-2 mr-2 mb-5">
              <label class="font-weight-bold">CONTROL DE ASISTENCIA</label>
              <hr class="mt-1 mb-4 mr-5">
              <div class="form-row">
                  <div class="form-group col-md-6">
                      <label class="text-info font-weight-bold">Hora marca entrada</label>
                      <span style="border:none;" class="form-control border-bottom" id="horaEntrada"></span>
                  </div>
                  <div class="form-group col-md-6">
                    <label class="text-info font-weight-bold">Hora marca salida</label>
                    <span style="border:none;" class="form-control border-bottom" id="horaSalida"></span>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="text-info font-weight-bold">Día</label>
                    <span style="border:none;" class="form-control border-bottom" id="dia"></span>
                </div>
                <div class="form-group col-md-6">
                    <label class="text-info font-weight-bold">Jornada</label>
                    <span style="border:none;" class="form-control border-bottom" id="jornada"></span>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="text-info font-weight-bold">Estado</label>
                    <span style="border:none;" class="form-control border-bottom" id="estado"></span>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="text-info font-weight-bold">Atraso</label>
                    <span style="border:none;" class="form-control border-bottom" id="atraso"></span>
                </div>
                <div class="form-group col-md-6">
                  <label class="text-info font-weight-bold">Salida anticipada</label>
                  <span style="border:none;" class="form-control border-bottom" id="salidaAnticipada"></span>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>