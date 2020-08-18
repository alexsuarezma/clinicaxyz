<?php
require '../components/layout.php';
require '../../seguridad/controllers/functions/credenciales.php';

verificarAcceso("../../../../", "modulo_rrhh");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recursos Humanos | Personal</title>
    <link rel="stylesheet" href="../assets/styles/component/cards.css">
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
  '../index.php','../../suministro/','../../contabilidad/','../../citasmedicas/','../../pacientes/','../../seguridad/',3);
?>
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Personal</h1>
          
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
    <div class="container">
    <input type="text" name="busqueda" id="busqueda" placeholder="Busca por cedula, nombres, apellidos, cargo, personal, area..." title="Type in a name">
    </div>
        <div class="container page-container">
        <button type="button" class="btn btn-light mb-4" data-toggle="modal" data-target="#modal-reporte">Generar reporte de empleados</button>
            <div id="datos" class="row gutters">            
            </div>
        </div>
     </main>
   </div>
  </div>

  <div class='modal fade' name='modal-reporte' id='modal-reporte' data-backdrop='static' data-keyboard='false' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabe' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='staticBackdropLabel'>REPORTE DE EMPLEADOS</h5>
                    </button>
                </div>
                <div class='modal-body'>
                    <form method="POST" action="http://localhost:8000/reportes.php" class="ml-2 mr-2">
                        <label class="font-weight-bold">Seleccióna el tipo de reporte que deseas</label>
                        <input type="hidden" name="id" value="<?php echo $_SESSION['user_id']?>" required>
                        <hr class="mt-1 mb-4 mr-5">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="estadoBusqueda">Reporte</label>
                                <select class="custom-select" name="estadoBusqueda" id="estadoBusqueda" required>
                                <option selected disabled value="">Seleccione...</option>
                                    <option value="1">Reporte Todos los empleados</option>
                                    <option value="2">Reporte de Empleados por Área</option>
                                    <option value="3">Reporte de Empleados por Cargo</option>
                                </select>
                            </div>
                            <!-- <div class="form-group col-md-6">
                                <label for="rango">Escoge el rango</label>
                                <select class="custom-select" name="rango" id="rango" required>
                                <option selected disabled value="">Seleccione...</option>
                                    <option value="hoy">Hoy</option>
                                    <option value="ayer">Ayer</option>
                                    <option value="semana">Esta Semana</option>
                                    <option value="mes">Este Mes</option>
                                    <option value="Mes Anterior">Mes Anterior</option>
                                    <option value="anio">Este Año</option>
                                </select>
                            </div> -->
                        </div>
                        <div class='modal-footer mt-2'>
                            <button id="cancelar" type='button' class="btn btn-light border-secondary" data-dismiss='modal'>Cancelar</button>
                            <button id='enviar' name='enviar' type='submit' class='btn btn-primary font-weight-bold' style="width:200px;">Generar</button>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>  
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <script src="../components/scripts/dashboard.js"></script>      
  <script type="text/javascript" src="../components/scripts/jquery.min.js"></script>    
  <script type="text/javascript" src="../components/scripts/searchFilter.js"></script>      
  
</body>
</html>