<?php 
    require '../../../../database.php';
    require '../components/layout.php';
    require '../components/modal.php';
    require '../../seguridad/controllers/functions/credenciales.php';

    verificarAcceso("../../../../", "modulo_rrhh");
       $id=$_GET["id"];
       $horario = $conn->query("SELECT * FROM asistencia_empleado WHERE id_empleado_asis = $id")->rowCount();
       $_SESSION['cedula'] = $id;
            $records = $conn->prepare("SELECT * FROM empleados WHERE id_empleados = :cedula");
            $records->bindParam(':cedula', $id);
            $records->execute();
            $results = $records->fetch(PDO::FETCH_ASSOC);
     

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recursos Humanos | Perfil Empleado</title>
    <link rel="stylesheet" href="../assets/styles/component/profile.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet"> 
    <!-- Custom styles for this template -->
    <link href="../assets/styles/component/dashboard.css" rel="stylesheet">
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
                <h1 class="h2">Perfil</h1>
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
            
            
            <div style="max-width:1500px;" class="container mt-5">
            <div class="row">
                <div class="col-lg-4 pb-5">
                    <!-- Account Sidebar-->
                    <div class="author-card pb-3">
                        <div class="author-card-cover" style="background-image: url(https://demo.createx.studio/createx-html/img/widgets/author/cover.jpg);">
                            <a class="btn btn-style-1 btn-white btn-sm" href="#" data-toggle="tooltip" title="" data-original-title="You currently have 290 Reward points to spend">
                                <i class="fa fa-award text-md"></i>&nbsp;Disponible
                                <?php if($results['medico']==1): ?>  
                                    <span style="font-size:14px;" class="badge badge-info">#MEDICO</span>            
                                <?php endif; ?>
                            </a>
                        </div>
                        <div class="author-card-profile">
                            <div class="author-card-avatar"><img src=<?php echo $results['profileimage']?> alt=<?php echo $results['nombres']?>>
                            </div>
                            <div class="author-card-details">
                                <h5 class="author-card-name text-lg"><?php echo $results['nombres']?> <?php echo $results['apellidos'] ?> </h5><span class="author-card-position">Contratado desde el <?php echo $results["created_at"]?></span>
                                <h5 id="ocultCedula"style="display: none"><?php echo $results['id_empleados']?></h5>
                            </div>
                        </div>
                    </div>
                    <div class="wizard">
                        <nav class="list-group list-group-flush">
                            <a class="list-group-item active" id="informacion" href="#information"> 
                               <div class="d-flex justify-content-between align-items-center">
                                    <div><i class="fe-icon-shopping-bag mr-1 text-muted"></i>
                                        <div class="d-inline-block font-weight-medium text-uppercase">Información</div>
                                    </div>
                                </div>
                            </a>
                            <a class="list-group-item" id="horario" href="#horario">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div><i class="fe-icon-shopping-bag mr-1 text-muted"></i>
                                        <div class="d-inline-block font-weight-medium text-uppercase">Asistencias</div>
                                    </div><span class="badge badge-secondary"><?php echo $horario?></span>
                                </div>
                            </a>
                            <a class="list-group-item" id="actividades" href="#actividades">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div><i class="fe-icon-shopping-bag mr-1 text-muted"></i>
                                        <div class="d-inline-block font-weight-medium text-uppercase">Actividades</div>
                                    </div><span class="badge badge-secondary">6</span>
                                </div>
                            </a>
                            <a class="list-group-item" id="documentos" href="#documentos">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div><i class="fe-icon-shopping-bag mr-1 text-muted"></i>
                                        <div class="d-inline-block font-weight-medium text-uppercase">Documentos</div>
                                    </div><span class="badge badge-secondary">6</span>
                                </div>
                            </a>
                            <a class="list-group-item" id="contrato" href="#contrato">
                                <div class="d-flex justify-content-between align-items-center">
                                    <?php
                                         if($results['load_contrato'] == false):
                                    ?>
                                    <div><i class="fe-icon-heart mr-1 text-muted"></i>
                                        <div class="d-inline-block font-weight-medium text-uppercase">Contrato <span class="badge badge-danger"> ¡¡NO HAS GENERADO CONTRATO!!</span></div>
                                        </div><span class="badge badge-danger">?</span>
                                    <?php
                                        else:
                                    ?>
                                     <div><i class="fe-icon-heart mr-1 text-muted"></i>
                                        <div class="d-inline-block font-weight-medium text-uppercase">Contrato</div>
                                        </div><span class="badge badge-success">1</span>
                                    <?php
                                        endif;
                                    ?>
                                    
                                </div>
                            </a>
                            <a class="list-group-item" name="update" id="update" href="#update">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div><i class="fe-icon-heart mr-1 text-muted"></i>
                                        <div class="d-inline-block font-weight-medium text-uppercase">Actualizar Información</div>
                                    </div><span class="badge badge-secondary">3</span>
                                </div>
                            </a>
                            <a class="list-group-item" name="delete" id="delete" href="#">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div><i class="fe-icon-tag mr-1 text-muted"></i>
                                        <div class="d-inline-block font-weight-medium text-uppercase">Finalizar Contrato</div>
                                    </div><span class="badge badge-secondary">4</span>
                                </div>
                            </a>
                        </nav>
                    </div>
                </div>
                <!-- Profile Settings-->
                  <div id="section" class="col-lg-8 pb-5">
                       <!-- Render de settings-->
                  </div>
                  <!--Modal-->
                  <?php
                      
                        printModal('Actualizar Información','btn-update','modal-update','¡Hey!... Estas apunto de editar información sensible. ¿Deseas continuar?');
                        printModal('Finalizar Contrato','btn-delete','modal-delete','¡Hey!. Estas apunto de ELIMINAR información sensible. ¿Realmente desea FINALIZAR el contrato con este empleado?');
                  ?>
            
            </div>
        </div>
     </main>
   </div>
  </div>
  
  <script type="text/javascript" src="https://code.jquery.com/jquery.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <script src="../components/scripts/dashboard.js"></script>   
  <script src="../components/scripts/profile.js"></script>   
</body>
</html>