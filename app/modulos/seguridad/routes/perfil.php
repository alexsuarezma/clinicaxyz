<?php
session_start();
require '../../../../database.php';
$records = $conn->prepare("SELECT * FROM empleados WHERE id_usuario_emp = :id_usuario_emp");
$records->bindParam(':id_usuario_emp', $_SESSION['user_id']);
$records->execute();
$results = $records->fetch(PDO::FETCH_ASSOC); 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinica Vitalia | Perfil</title>
</head>
<body>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Clinica Vitalia</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="../assets/dist/css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    
    <link href="../../../../assets/styles/component/carousel.css" rel="stylesheet">
    <link rel="icon" href="clinicavitalia.ico">
  </head>
  <body>
    <header>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="../../../../index.php">
      <span style="font-weight:normal;">Clinica</span>
      <span style="font-weight:bold;">Vitalia</span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
      </ul>

      
          <span class="navbar-text mr-4"><?php echo $_SESSION['username']?></span>
          <a class='nav-link dropdown-toggle' style='color: white;' href='#' id='navbarDropdownMenuLink' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
            <i class="fas fa-th-large" ></i>
          </a>  
          <div class='dropdown-menu dropdown-menu-right mr-1 mb-2' style="width:400px;" aria-labelledby='navbarDropdownMenuLink'>
            <span class="dropdown-item font-weight-bold border-bottom border-info mb-2" style="text-align:center;"><?php echo $_SESSION['nombre_credencial']?></span>
            <?php
              if($_SESSION['modulo_rrhh'] == 1){
                echo "<a class='dropdown-item mt-2' href='app/modulos/recursoshumanos/'><i class='fas fa-people-carry mr-2'></i> Recursos Humanos</a>";
              }
              if($_SESSION['modulo_suministros'] == 1){
                echo "<a class='dropdown-item' href='app/modulos/suministro/index.php'><i class='fas fa-dolly-flatbed mr-2'></i> Suministros</a>";
              }
              if($_SESSION['modulo_contabilidad'] == 1){
                echo "<a class='dropdown-item' href='app/modulos/contabilidad/index.php'><i class='fas fa-balance-scale mr-2'></i> Contabilidad</a>";
              }
              if($_SESSION['modulo_ctas_medicas'] == 1){
                echo "<a class='dropdown-item' href='app/modulos/citasmedicas/index.php'><i class='fas fa-notes-medical mr-3'></i> Citas Medicas</a>";
              }
              if($_SESSION['modulo_pacientes'] == 1){
                echo "<a class='dropdown-item' href='app/modulos/pacientes/index copy 2.html'><i class='fas fa-procedures mr-2'></i> Modulo Pacientes</a>";
              }
              if($_SESSION['modulo_seguridad'] == 1){
                echo "<a class='dropdown-item' href='app/modulos/seguridad/'><i class='fas fa-user-shield mr-2'></i> Modulo Seguridad</a>";
              }
              if($_SESSION['paciente'] == 1){
                echo "<a class='dropdown-item' href='app/modulos/pacientes/index copy 2.html'><i class='fas fa-procedures mr-2'></i> Paciente</a>";
              }
              
            ?>            
            <!-- <a class='dropdown-item' href='#'><i class='fas fa-file-medical-alt mr-3'></i> Historial Clinico</a> -->
            <hr class="ml-4 mr-4 mt-2">
            <a class='dropdown-item mt-2' style="float:right;" href='app/modulos/seguridad/routes/perfil.php'><span class="float-right">Ajustes de Usuario</span></a>
            <a class='dropdown-item' style="float:right;" href='#'><span class="float-right">Another</span></a>
            <a class='dropdown-item' style="float:right;" href='app/modulos/seguridad/controllers/logout.php'><span class="float-right">Cerrar Sesión</span></a>
          </div>
       
      <!-- <li class='justify-content-end'>
        
      </li> -->
    </div>
  </nav>
</header>

<main role="main" class="mt-5">


    <div class="container mt-5">
<div class="row flex-lg-nowrap">
  <!-- <div class="col-12 col-lg-auto mb-3" style="width: 200px;">
    <div class="card p-3">
      <div class="e-navlist e-navlist--active-bg">
        <ul class="nav">
          <li class="nav-item"><a class="nav-link px-2 active" href="./overview.html"><i class="fa fa-fw fa-bar-chart mr-1"></i><span>Overview</span></a></li>
          <li class="nav-item"><a class="nav-link px-2" href="./users.html"><i class="fa fa-fw fa-th mr-1"></i><span>CRUD</span></a></li>
          <li class="nav-item"><a class="nav-link px-2" href="./settings.html"><i class="fa fa-fw fa-cog mr-1"></i><span>Settings</span></a></li>
        </ul>
      </div>
    </div>
  </div> -->

  <div class="col">
    <div class="row">
      <div class="col mb-3">
        <div class="card">
          <div class="card-body">
            <div class="e-profile">
              <div class="row">
                <div class="col-12 col-sm-auto mb-3">
                  <div class="mx-auto" style="width: 140px;">
                    <div class="d-flex justify-content-center align-items-center rounded" style="height: 140px; background-color: rgb(233, 236, 239);">
                      <span style="color: rgb(166, 168, 170); font: bold 8pt Arial;"><img src="<?php echo $results['profileimage']?>" alt=""></span>
                    </div>
                  </div>
                </div>
                <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                  <div class="text-center text-sm-left mb-2 mb-sm-0">
                    <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap"><?php echo $_SESSION['username']?></h4>
                    <p class="mb-0"><?php echo $results['email']?></p>
                    <div class="text-muted"><small>Last seen 2 hours ago</small></div>
                    <!-- <div class="mt-2">
                      <button class="btn btn-primary" type="button">
                        <i class="fa fa-fw fa-camera"></i>
                        <span>Change Photo</span>
                      </button>
                    </div> -->
                  </div>
                  <div class="text-center text-sm-right">
                    <span class="badge badge-secondary"><?php echo $_SESSION['nombre_credencial']?></span>
                    <div class="text-muted"><small>Ingresado desde <?php echo substr($results['created_at'],0,8)?></small></div>
                  </div>
                </div>
              </div>
              <ul class="nav nav-tabs">
                <li class="nav-item"><a href="" class="active nav-link">Configuración de cuenta</a></li>
              </ul>
              <div class="tab-content pt-3">
                <div class="tab-pane active">
                  <form class="form">
                  <hr class="mt-1 mb-4 mr-5">
                    <ul class="nav nav-pills p-3 bg-white rounded-pill align-items-center">
                        <li class="nav-item ml-auto">
                        <a href="#" id="btn-editar" title="Editar"><i class="fas fa-toggle-on" id="on" style="font-size:20px;"></i><i class="fas fa-toggle-off" id="off" style="font-size:20px;"></i></a> 
                        </li>
                    </ul>
                    <div class="row">
                      <div class="col">
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label>Nombres</label>
                              <input class="form-control" type="text" name="name" value="<?php echo $results['nombres']." ".$results['apellidos']?>" readonly>
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <label>Nombre de Usuario</label>
                              <input class="form-control" type="text" name="username" value="<?php echo $results['nacionalidad']?>" readonly>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12 col-sm-6 mb-3">
                        <div class="mb-2"><b>Cambiar Contraseña</b></div>
                        <div class="row">
                            <div class="col">
                            <div class="form-group">
                                <label>Nombre de Usuario</label>
                                <input class="form-control" type="text" name="username" value="<?php echo $_SESSION['username']?>">
                            </div>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label>Contraseña Antigua</label>
                              <input class="form-control" type="password" name="oldPassword" id="oldPassword" placeholder="••••••" required>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label>Contraseña Nueva</label>
                              <input class="form-control" type="password" name="newPassword" id="newPassword" placeholder="••••••" required>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label>Confirmar <span class="d-none d-xl-inline">Contraseña</span></label>
                              <input class="form-control" type="password" name="confirmNewPassword" id="confirmNewPassword" placeholder="••••••" required>
                            </div>
                          </div>
                        </div>
                      </div>
            
                    </div>
                    <div class="row">
                      <div class="col d-flex justify-content-end">
                        <!-- <button class="btn btn-primary" type="submit">Guardar Cambios</button> -->
                      </div>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-3 mb-3">
        <div class="card mb-3">
          <div class="card-body">
            <div class="px-xl-3">
              <button class="btn btn-block btn-secondary">
                <i class="fa fa-sign-out"></i>
                <span>Logout</span>
              </button>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <h6 class="card-title font-weight-bold">Support</h6>
            <p class="card-text">Get fast, free help from our friendly assistants.</p>
            <button type="button" class="btn btn-primary">Contact Us</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
</div>
</main>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>  <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="../assets/dist/js/bootstrap.bundle.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
    var edit = 0;
        $('#btn-editar').click(function(){
            edit++;
            if(edit==1){
                frm = document.forms['formEditar'];
                for(i=0; ele=frm.elements[i]; i++){
                    ele.disabled=false;
                }
                document.getElementById('on').style.display="block";    
                document.getElementById('off').style.display="none";    
            }
            if(edit==2){
                frm = document.forms['formEditar'];
                for(i=0; ele=frm.elements[i]; i++){
                    ele.disabled=true;
                }
                edit=0;
                document.getElementById('off').style.display="block";    
                document.getElementById('on').style.display="none";    
            }
        });  
        $('#btn-delete').click(function(){
            document.getElementById('formDelete').submit();
        });  
    });

</script>
</body>
</html>