<?php
session_start();
require '../../../../database.php';
if(!$_SESSION['user_id']){
  header('Location: ../../../../index.php');
}

$message='';
$pacient = false;
$consulta = $conn->prepare("SELECT * FROM empleados WHERE id_usuario_emp = :id_usuario_emp");
$consulta->bindParam(':id_usuario_emp', $_SESSION['user_id']);
$consulta->execute();
$resultado = $consulta->fetch(PDO::FETCH_ASSOC); 


if(!$resultado){
  
  $afiliacionPublica= '';
  $afiliacionPrivada= '';
  $carnetConadis = '';
  $consulta = $conn->prepare("SELECT * FROM pacientes AS p, profesion_paciente AS pp, ciudades AS c WHERE (p.ocupacion_paciente=pp.idprofesion_paciente AND p.ciudad=c.idciudades) AND id_usuario_pac = :id_usuario_pac");
  $consulta->bindParam(':id_usuario_pac', $_SESSION['user_id']);
  $consulta->execute();
  $resultado = $consulta->fetch(PDO::FETCH_ASSOC); 

  if($resultado['afiliacion_publica']!= null){
    $afiliacionPublica = $conn->query("SELECT * FROM seguro_publico WHERE idseguro_publico=".$resultado['afiliacion_publica'])->fetchAll(PDO::FETCH_OBJ);
  }
  
  if($resultado['afiliacion_privada']!= null){
    $afiliacionPrivada = $conn->query("SELECT * FROM seguro_privado WHERE idseguro_privado=".$resultado['afiliacion_privada'])->fetchAll(PDO::FETCH_OBJ);
  }
  
  $carnetConadis =  $conn->query("SELECT * FROM conadis AS c, discapacidades AS d WHERE (c.discapacidad=d.iddiscapacidad) AND paciente='".$resultado['idpacientes']."'")->fetchAll(PDO::FETCH_OBJ);
  
  if(!$carnetConadis){
    $carnetConadis = '';
  }

  $pacient = true;

  $direccion = $conn->query("SELECT * FROM direccion_paciente WHERE id_pacientes_de=".$resultado['idpacientes']." ORDER BY tipo ASC")->fetchAll(PDO::FETCH_OBJ);

  $profesion = $conn->query("SELECT * FROM profesion_paciente ORDER BY profesion ASC")->fetchAll(PDO::FETCH_OBJ);
  $seguroPublico = $conn->query("SELECT * FROM seguro_publico ORDER BY descripcion ASC")->fetchAll(PDO::FETCH_OBJ);
  $seguroPrivado = $conn->query("SELECT * FROM seguro_privado ORDER BY descripcion ASC")->fetchAll(PDO::FETCH_OBJ);
  $discapacidad = $conn->query("SELECT * FROM discapacidades ORDER BY descripcion ASC")->fetchAll(PDO::FETCH_OBJ);
  $provincias = $conn->query("SELECT * FROM provincias ORDER BY nombre ASC")->fetchAll(PDO::FETCH_OBJ);
  $ciudades = $conn->query("SELECT * FROM ciudades ORDER BY nombre ASC")->fetchAll(PDO::FETCH_OBJ);
}

  if(isset($_POST['changedUserName'])){
    $sql = "UPDATE usuario SET username=:username WHERE id_usuario=:id_usuario";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $_POST['username']);
    $stmt->bindParam(':id_usuario',  $_SESSION['user_id']);
    
    if($stmt->execute()){
      $_SESSION['username']= $_POST['username'];
    }
  }

  //CAMBIAR CONTRASEÑA
  if(isset($_POST['oldPassword'])){
    
    $records = $conn->prepare("SELECT password FROM usuario WHERE id_usuario = :id_usuario");
    $records->bindParam(':id_usuario', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC); 
    
    if(password_verify($_POST['oldPassword'],$results['password'])){
        $sql = "UPDATE usuario SET password=:password WHERE id_usuario = :id_usuario";
        $stmt = $conn->prepare($sql);
        $password = password_hash($_POST['newPassword'], PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':id_usuario',  $_SESSION['user_id']);
        if($stmt->execute()){
          header("Location: ../../../../");
        }
    }else{
      $message='Hey, la contraseña antigua no es correcta. Porfavor escribela nuevamente';
    }
  }

$stmt=null;
$conn=null;

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
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
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
                echo "<a class='dropdown-item mt-2' href='../../recursoshumanos/'><i class='fas fa-people-carry mr-2'></i> Recursos Humanos</a>";
              }
              if($_SESSION['modulo_suministros'] == 1){
                echo "<a class='dropdown-item' href='../../suministro/index.php'><i class='fas fa-dolly-flatbed mr-2'></i> Suministros</a>";
              }
              if($_SESSION['modulo_contabilidad'] == 1){
                echo "<a class='dropdown-item' href='../../contabilidad/index.php'><i class='fas fa-balance-scale mr-2'></i> Contabilidad</a>";
              }
              if($_SESSION['modulo_ctas_medicas'] == 1){
                echo "<a class='dropdown-item' href='../../citasmedicas/index.php'><i class='fas fa-notes-medical mr-3'></i> Citas Medicas</a>";
              }
              if($_SESSION['modulo_pacientes'] == 1){
                echo "<a class='dropdown-item' href='../../pacientes/'><i class='fas fa-procedures mr-2'></i> Modulo Pacientes</a>";
              }
              if($_SESSION['modulo_seguridad'] == 1){
                echo "<a class='dropdown-item' href='../'><i class='fas fa-user-shield mr-2'></i> Modulo Seguridad</a>";
              }
              if($_SESSION['paciente'] == 1){
                echo "<a class='dropdown-item' href='../../pacientes/home.php'><i class='fas fa-procedures mr-2'></i> Paciente</a>";
              }
              
            ?>            
            <!-- <a class='dropdown-item' href='#'><i class='fas fa-file-medical-alt mr-3'></i> Historial Clinico</a> -->
            <hr class="ml-4 mr-4 mt-2">
            <a class='dropdown-item mt-2' style="float:right;" href='perfil.php'><span class="float-right">Ajustes de Usuario</span></a>
            <a class='dropdown-item' style="float:right;" href='#'><span class="float-right">Another</span></a>
            <a class='dropdown-item' style="float:right;" href='../controllers/logout.php'><span class="float-right">Cerrar Sesión</span></a>
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
                      <span style="color: rgb(166, 168, 170); font: bold 8pt Arial;"><img src="<?php echo $resultado['profileimage']?>" alt=""></span>
                    </div>
                  </div>
                </div>
                <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                  <div class="text-center text-sm-left mb-2 mb-sm-0">
                    <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap"><?php echo $_SESSION['username']?></h4>
                    <?php if(!$pacient):?>     
                      <p class="mb-0"><?php echo $resultado['email']?></p>
                    <?php else:?>
                      <p class="mb-0"><?php echo $resultado['correo']?></p>
                    <?php endif;?>
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
                    <div class="text-muted"><small>Ingresado desde <?php echo substr($resultado['created_at'],0,8)?></small></div>
                  </div>
                </div>
              </div>
              <ul class="nav nav-tabs">
                <li class="nav-item"><a href="" class="active nav-link">Configuración de cuenta</a></li>
              </ul>
              <div class="tab-content pt-3">
                <div class="tab-pane active">
                <?php if(!$pacient):?>
                <form class="form">
                  <div class="row">
                    <div class="col">
                      <div class="row">
                        <div class="col">
                          <div class="form-group">
                            <label>Nombres</label>
                            <input class="form-control" type="text" name="name" value="<?php echo $resultado['nombres']." ".$resultado['apellidos']?>" readonly>
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-group">
                            <label>Nombre de Usuario</label>
                            <input class="form-control" type="text" name="username" value="<?php echo $resultado['nacionalidad']?>" readonly>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
                <?php else:?>
                  
              <form method="POST" action="../controllers/actualizarPaciente.php" class="ml-4 mr-4 mb-5">
        
                <label class="font-weight-bold mt-4">Información personal del paciente</label>
                <hr class="mt-1 mb-4 mr-5">
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="cedula">Cedula/Pasaporte</label>
                    <input type="hidden" name="type" value="1">
                    <input type="hidden" name="cedula" value="<?php echo $resultado['idpacientes']?>">
                    <input type="text" class="form-control" readonly value="<?php echo $resultado['idpacientes']?>" required>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="name">Nombres</label>
                    <input type="text" class="form-control" onkeypress="return soloLetras(event)" name="name" id="name" value="<?php echo $resultado['nombres']?>" readonly required>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="apellidoPaterno">Apellido Paterno</label>
                    <input type="text" class="form-control" onkeypress="return soloLetras(event)" name="apellidoPaterno" id="apellidoPaterno" value="<?php echo $resultado['ape_paterno']?>" readonly required>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="apellidoMaterno">Apellido Materno</label>
                    <input type="text" class="form-control" onkeypress="return soloLetras(event)" name="apellidoMaterno" id="apellidoMaterno" value="<?php echo $resultado['ape_mat']?>" readonly required>
                  </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control"  onchange="validarEmail(this);" name="email" id="email" placeholder="ejemplo@gmail.com" value="<?php echo $resultado['correo']?>" readonly required>
                        <div class="invalid-feedback">
                            Correo electrónico inválido.
                        </div>
                        <div class="valid-feedback">
                            Correo electrónico válido.
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="ocupacion">Ocupación</label>
                        <select id="ocupacion" name="ocupacion" class="form-control">
                          <option selected value="<?php echo $resultado['idprofesion_paciente']?>"><?php echo utf8_encode($resultado['profesion'])?></option>
                          <option disabled value=""> Seleccione...</option>
                          <?php
                            foreach ($profesion as $Ocupaciones):
                          ?>
                            <option value="<?php echo $Ocupaciones->idprofesion_paciente;?>"><?php echo utf8_encode($Ocupaciones->profesion);?></option>
                          <?php 
                            endforeach;
                          ?> 
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="fechaNacimiento">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" name="fechaNacimiento" id="fechaNacimiento" value="<?php echo $resultado['f_nacimiento']?>" readonly required>
                    </div>
                    <div class="form-group col-md-4">
                    <label class="font-weight-bold">Sexo</label>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="sexo1" name="sexo" class="custom-control-input" checked>
                            <label class="custom-control-label" for="sexo1">
                              <?php if($resultado['sexo']=='V'):?>
                                Varón
                              <?php elseif($resultado['sexo']=='M'):?>
                                Mujer
                              <?php elseif($resultado['sexo']=='I'):?>
                                Indefinido
                              <?php endif;?>
                            </label>
                        </div>
                    </div>              
                </div>
                <div class="form-row mb-3">
                  <div class="form-group col-md-4">
                    <label for="provincia">Provincia</label>
                    <select id="provincia" name="provincia" class="form-control" required>
                      <?php
                        foreach ($provincias as $provinciasPaciente):
                          ?>
                          <?php if($provinciasPaciente->idprovincias==$resultado['provincia']):?>
                            <option selected value="<?php echo $provinciasPaciente->idprovincias;?>"><?php echo utf8_encode($provinciasPaciente->nombre);?></option>
                          <?php else:?>
                            <option value="<?php echo $provinciasPaciente->idprovincias;?>"><?php echo utf8_encode($provinciasPaciente->nombre);?></option>
                          <?php endif;?>
                      <?php 
                        endforeach;
                        ?> 
                    </select>
                  </div>
                  <div class="form-group col-md-4" id="print-ciudades">
                    <label for='ciudad'>Ciudad</label>
                    <select id='ciudad' name='ciudad' class='form-control' required>
                    <option selected value="<?php echo $resultado['ciudad']?>"><?php echo $resultado['nombre']?></option>
                    <option disabled value=""> Seleccione...</option>
                      <?php foreach ($ciudades as $ciudadesPaciente):?>
                        <option value='<?php echo $ciudadesPaciente->idciudades?>'><?php echo utf8_encode($ciudadesPaciente->nombre)?></option>
                      <?php  endforeach;?>
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="zona">Zona</label>
                    <input type="text" class="form-control" onkeypress="return soloLetras(event)" id="zona" name="zona" value="<?php echo $resultado['zona']?>" required>
                  </div>
                </div>
                <label class="font-weight-bold">Información de ubicación</label>
                <hr class="mt-1 mb-4 mr-5">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="direccionDomicilio">Dirección del domicilio</label>
                        <input type="text" class="form-control" id="direccionDomicilio" name="direccionDomicilio" value="<?php echo $direccion[1]->direccion?>" required>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="telefonoDomicilio">Telefono</label>
                      <input type="text" class="form-control"  onchange="validarTelefono(this);" onkeypress="return soloNumeros(event)" maxlength="7" id="telefonoDomicilio" name="telefonoDomicilio" value="<?php echo $direccion[1]->tlno_particular?>" required>
                      <div class="invalid-feedback">
                        Número fijo inválido. </br>
                        ¡Debe ser un número teléfonico, tiene que tener 7 dígitos!
                      </div>
                      <div class="valid-feedback">
                        Número fijo válido.
                      </div>
                  </div>
                  <div class="form-group col-md-3">
                      <label for="celularDomicilio">Celular</label>
                      <input type="text" class="form-control"  onchange="validarCelular(this);" onkeypress="return soloNumeros(event)" maxlength="10" id="celularDomicilio" name="celularDomicilio" value="<?php echo $direccion[1]->tlno_personal?>"  required>
                      <div class="invalid-feedback">
                          Número celular inválido.</br>
                          ¡El celular debe comenzar en 0, y contener 10 dígitos!
                      </div>
                      <div class="valid-feedback">
                        Número celular válido.
                      </div>
                  </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-9">
                        <label for="direccionTrabajo">Dirección del lugar de trabajo</label>
                        <input type="text" class="form-control" id="direccionTrabajo" name="direccionTrabajo" value="<?php echo $direccion[2]->direccion?>"  required>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="telefonoTrabajo">Telefono</label>
                      <input type="text" class="form-control"  onchange="validarTelefono(this);" onkeypress="return soloNumeros(event)" maxlength="7" id="telefonoTrabajo" name="telefonoTrabajo" value="<?php echo $direccion[2]->tlno_particular?>"  required>
                      <div class="invalid-feedback">
                        Número fijo inválido. </br>
                        ¡Debe ser un número teléfonico, tiene que tener 7 dígitos!
                      </div>
                      <div class="valid-feedback">
                        Número fijo válido.
                      </div>
                  </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-9">
                        <label for="direccionAtencion">Dirección de atención medica</label>
                        <input type="text" class="form-control" id="direccionAtencion" name="direccionAtencion" value="<?php echo $direccion[0]->direccion?>" required>
                    </div>
                  <div class="form-group col-md-3">
                      <label for="telefonoAtencion">Telefono</label>
                      <input type="text" class="form-control"  onchange="validarTelefono(this);" onkeypress="return soloNumeros(event)" maxlength="7" id="telefonoAtencion" name="telefonoAtencion" value="<?php echo $direccion[0]->tlno_particular?>"  required>
                      <div class="invalid-feedback">
                        Número fijo inválido. </br>
                        ¡Debe ser un número teléfonico, tiene que tener 7 dígitos!
                      </div>
                      <div class="valid-feedback">
                        Número fijo válido.
                      </div>
                  </div>
                </div>
                <hr class="mt-1 mb-4 mr-5">
                <label class="font-weight-bold">¿Posee Afiliación?</label>
                <?php if($resultado['afiliacion_privada'] == null && $resultado['afiliacion_publica'] == null):?>
                    <div class="form-row">
                      <div class="form-group col-md-4 mt-4 ml-2">
                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" id="afiliado1" name="afiliado" class="custom-control-input" onchange="esAfiliado(this,'afiliaciones');" value="si">
                          <label class="custom-control-label" for="afiliado1">Si</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" id="adiliado2" name="afiliado" class="custom-control-input" onchange="esAfiliado(this,'afiliaciones');" value="no" checked>
                          <label class="custom-control-label" for="adiliado2">No</label>
                        </div>
                      </div>                  
                    </div>
                    <div id="afiliaciones" style="display:none;">
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <div class="form-check form-check-inline mr-5 mt-4">
                            <input class="form-check-input" type="checkbox" id="publica" value="publica" onchange="afiliacion(this,'afiliacionPublica');">
                            <label class="form-check-label" for="publica">Afiliación Pública</label>
                          </div>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="afiliacionPublica">Afiliación Pública</label>
                          <select id="afiliacionPublica" name="afiliacionPublica" class="form-control" disabled required>
                              <option selected disabled value="">Seleccione...</option>                         
                              <?php
                              foreach ($seguroPublico as $ListaPublico):
                                ?>
                              <option value="<?php echo $ListaPublico->idseguro_publico;?>"><?php echo utf8_encode($ListaPublico->descripcion);?></option>
                            <?php 
                              endforeach;
                            ?> 
                          </select>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <div class="form-check form-check-inline mt-4">
                            <input class="form-check-input" type="checkbox" id="privada" value="privada" onchange="afiliacion(this,'afiliacionPrivada');">
                            <label class="form-check-label" for="privada">Afiliación Privada</label>
                          </div>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="afiliacionPrivada">Afiliación Privada</label>
                          <select id="afiliacionPrivada" name="afiliacionPrivada" class="form-control" disabled required>
                          <option selected disabled value="">Seleccione...</option>                         
                            <?php
                              foreach ($seguroPrivado as $ListaPrivado):
                                ?>
                              <option value="<?php echo $ListaPrivado->idseguro_privado;?>"><?php echo utf8_encode($ListaPrivado->descripcion);?></option>
                            <?php 
                              endforeach;
                              ?> 
                          </select>
                        </div>
                      </div>      
                    </div>   
                <?php else:?> 
                    <div class="form-row">
                      <div class="form-group col-md-5">
                        <div class="form-check form-check-inline mr-5 mt-4">
                        <?php if($resultado['afiliacion_publica'] == null):?>
                          <input class="form-check-input" type="checkbox" id="publica" value="publica" onchange="afiliacion(this,'afiliacionPublica');">
                        <?php endif;?>
                          <label class="form-check-label" for="publica">Afiliación Pública</label>
                        </div>
                      </div>
                      <div class="form-group col-md-5">
                        <label for="afiliacionPublica">Afiliación Pública</label>
                        <?php if($resultado['afiliacion_publica'] == null):?>
                          <select id="afiliacionPublica" name="afiliacionPublica" class="form-control" disabled required>
                          <option selected disabled value="">Seleccione...</option>                 
                        <?php else: ?> 
                          <select id="afiliacionPublica" name="afiliacionPublica" class="form-control" required>
                          <option selected value="<?php echo $afiliacionPublica[0]->idseguro_publico?>"><?php echo utf8_encode($afiliacionPublica[0]->descripcion)?></option>                 
                          <option disabled value="">Seleccione...</option>                 
                        <?php endif;?>
                                    
                            <?php
                            foreach ($seguroPublico as $ListaPublico):
                              ?>
                            <option value="<?php echo $ListaPublico->idseguro_publico;?>"><?php echo utf8_encode($ListaPublico->descripcion);?></option>
                          <?php 
                            endforeach;
                          ?> 
                        </select>
                      </div>
                      <?php if($resultado['afiliacion_publica'] != null):?>
                        <div class="form-group col-md-2">
                          <a href="../controllers/borrarSeguro.php?type=publico&cedula=<?php echo $resultado['idpacientes']?>&tipo=1"><i class="fas fa-minus-circle" title="Elimina la credencial" style="color:black; font-size:18px; margin-left:40px; margin-top:40px;"></i></a>
                        </div>
                      <?php endif;?>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-5">
                        <div class="form-check form-check-inline mt-4">
                        <?php if($resultado['afiliacion_privada'] == null):?>
                          <input class="form-check-input" type="checkbox" id="privada" value="privada" onchange="afiliacion(this,'afiliacionPrivada');">
                        <?php endif;?>
                          <label class="form-check-label" for="privada">Afiliación Privada</label>
                        </div>
                      </div>
                      <div class="form-group col-md-5">
                        <label for="afiliacionPrivada">Afiliación Privada</label>
                        <?php if($resultado['afiliacion_privada'] == null):?>
                        <select id="afiliacionPrivada" name="afiliacionPrivada" class="form-control" disabled required>
                        <option selected disabled value="">Seleccione...</option>                         
                        <?php else:?>
                          <select id="afiliacionPrivada" name="afiliacionPrivada" class="form-control" required>
                          <option selected value="<?php echo $afiliacionPrivada[0]->idseguro_privado?>"><?php echo utf8_encode($afiliacionPrivada[0]->descripcion)?></option>                        
                          <option disabled value="">Seleccione...</option>                 
                        <?php endif;?>
                          <?php
                            foreach ($seguroPrivado as $ListaPrivado):
                              ?>
                            <option value="<?php echo $ListaPrivado->idseguro_privado;?>"><?php echo utf8_encode($ListaPrivado->descripcion);?></option>
                          <?php 
                            endforeach;
                            ?> 
                        </select>
                      </div>
                      <?php if($resultado['afiliacion_privada'] != null):?>
                          <div class="form-group col-md-2">
                            <a href="../controllers/borrarSeguro.php?type=privado&cedula=<?php echo $resultado['idpacientes']?>&tipo=1"><i class="fas fa-minus-circle" title="Eliminar seguro" style="color:black; font-size:18px; margin-left:40px; margin-top:40px;"></i></a>
                          </div>
                      <?php endif; ?>
                    </div>      
                <?php endif; ?>

                <hr class="mt-1 mb-4 mr-5">
                <label class="font-weight-bold">¿Posee alguna discapacidad?</label>
                <?php if(!$carnetConadis):?>
                  <div class="form-row">
                      <div class="form-group col-md-4 mt-2 ml-2">
                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" id="discapacidad1" name="poseeDiscapacidad" class="custom-control-input" onchange="esDiscapacitado(this,'carnetConadis', 'discapacidad', 'grado')" value="si">
                          <label class="custom-control-label" for="discapacidad1">Si</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" id="discapacidad2" name="poseeDiscapacidad" class="custom-control-input" onchange="esDiscapacitado(this,'carnetConadis', 'discapacidad', 'grado')" value="no" checked>
                          <label class="custom-control-label" for="discapacidad2">No</label>
                        </div>
                      </div>                  
                  </div>      
                  <div class="form-row">
                      <div class="form-group col-md-3">
                          <label for="carnetConadis">Carnet Conadis</label>
                          <input type="text" class="form-control" id="carnetConadis" name="carnetConadis" onchange="validarConadis(this);" onkeypress="return soloNumerosConadis(event);" maxLength="5" required disabled="true">
                      </div>
                      <div class="form-group col-md-6">
                          <label for="discapacidad">Discapacidad</label>
                          <select id="discapacidad" name="discapacidad" class="form-control" disabled required>
                        <option selected disabled value="">Seleccione...</option>
                        <?php
                          foreach ($discapacidad as $Discapacidad):
                            ?>
                          <option value="<?php echo $Discapacidad->iddiscapacidad;?>"><?php echo utf8_encode($Discapacidad->descripcion);?></option>
                        <?php 
                          endforeach;
                          ?> 
                      </select>
                      </div>
                      <div class="form-group col-md-3">
                          <label for="grado">Grado %</label>
                          <select id="grado" name="grado" class="form-control" required disabled="true">
                            <option selected disabled value="">Seleccione...</option>
                              <option value="10">10%</option>
                              <option value="15">15%</option>
                              <option value="20">20%</option>
                              <option value="40">40%</option>
                              <option value="50">50%</option>
                              <option value="80">80%</option>
                          </select>
                      </div>
                  </div>
                <?php else:?>
                  <div class="form-row">
                      <div class="form-group col-md-3">
                          <label for="carnetConadis">Carnet Conadis</label>
                          <input type="text" class="form-control" id="carnetConadis" name="carnetConadis" value="<?php echo $carnetConadis[0]->carnet?>" required disabled="true">
                      </div>
                      <div class="form-group col-md-5">
                          <label for="discapacidad">Discapacidad</label>
                          <input type="text" class="form-control" onkeypress="return soloLetras(event)" id="discapacidad" name="discapacidad" value="<?php echo $carnetConadis[0]->descripcion?>" required disabled="true">
                      </div>
                      <div class="form-group col-md-2">
                          <label for="grado">Grado %</label>
                          <input type="text" class="form-control" id="grado" name="grado" value="<?php echo $carnetConadis[0]->grado?>" required disabled="true">
                      </div>
                      <div class="form-group col-md-2">
                        <a href="../controllers/borrarCarnet.php?cedula=<?php echo $resultado['idpacientes']?>&tipo=1"><i class="fas fa-minus-circle" title="Eliminar el carnet" style="color:black; font-size:18px; margin-left:40px; margin-top:40px;"></i></a>
                      </div>
                  </div>
                <?php endif;?>
                 <div class="d-flex justify-content-end mt-5">
                 <a href="../../../../" class="text-secondary mr-5 mt-2">Cancelar</a>
                    <input class="btn btn-primary font-weight-bold" name="perfil" style="width:300px;" value="Guardar cambios" type="submit">
                 </div>
              </form>                  
            <?php endif;?>
                <hr class="mt-1 mb-5 mr-5">
                <div class="mb-2"><b>INFORMACIÓN DE LA CUENTA</b></div>
                <hr class="mt-1 mb-2 mr-5">
                <form method="POST" action="perfil.php" class="form">
                  <div class="row">
                      <div class="col md-6">
                        <div class="form-group">
                            <label>Nombre de Usuario</label>
                            <input class="form-control" type="text" name="username" id="username" value="<?php echo $_SESSION['username']?>" required>
                        </div>
                      </div>
                      <div class="col md-6">
                        <input class="btn btn-primary" style="margin-top:31px;" type="submit" name="changedUserName" value="Guardar Nombre de Usuario">
                      </div>      
                  </div>
                </form>
                  <form id="formEditar" onsubmit="onSubmit(event)" method="POST" action="perfil.php" class="form">
                  <span class="text-danger"><?php echo $message?></span>
                  <hr class="mt-1 mb-2 mr-5">
                    <ul class="nav nav-pills p-3 bg-white rounded-pill align-items-center">
                        <li class="nav-item ml-auto">
                        <a href="#" id="btn-editar" title="Editar"><i class="fas fa-toggle-on" id="on" style="font-size:20px; display:none;"></i><i class="fas fa-toggle-off" id="off" style="font-size:20px;"></i></a> 
                        </li>
                    </ul>
                    <div class="row">
                      <div class="col-12 col-sm-6 mb-3">
                        <div class="mb-2"><b>Cambiar Contraseña</b></div>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label>Contraseña Antigua</label>
                              <input class="form-control" type="password" name="oldPassword" id="oldPassword" placeholder="••••••" required disabled>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label>Contraseña Nueva</label>
                              <input class="form-control" type="password" name="newPassword" id="newPassword" placeholder="••••••" required disabled>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label>Confirmar <span class="d-none d-xl-inline">Contraseña</span></label>
                              <input class="form-control" type="password" name="confirmNewPassword" id="confirmNewPassword" placeholder="••••••" required disabled>
                            </div>
                          </div>
                        </div>
                      </div>
            
                    </div>
                    <div class="row">
                      <div class="col d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit" disabled>Guardar Cambios</button>
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
                <span><a href="../controllers/logout.php" style=" text-decoration:none; color:white;">Logout</a></span>
              </button>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <h6 class="card-title font-weight-bold">Soporte</h6>
            <p class="card-text">¿Necesitas alguna ayuda con esta cuenta?.</p>
            <button type="button" class="btn btn-primary">Contactanos</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<div id="alert" role="alert" aria-live="assertive" aria-atomic="true" class="toast" data-autohide="true" style="position: absolute; top: 0; right: 0; margin-top:70px;" data-delay="2000">
        <div class="toast-header bg-danger text-white">
          <i class="fas fa-exclamation-circle mr-2"></i>
          <strong class="mr-auto">¡ERROR!</strong>
          <small>Hace 2 segundos</small>
          <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="toast-body">
            Las contraseñas no coinciden, porfavor escribelas de nuevo.
        </div>
    </div>
</main>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="../controllers/validations/validations.js"></script>
<script src="../components/scripts/ciudad.js"></script>

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
                $('#oldPassword') .focus();
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
    });
 
    onSubmit = (event) => {
      event.preventDefault()

      if(document.getElementById('confirmNewPassword').value == document.getElementById('newPassword').value){
          document.getElementById('formEditar').submit();
      }else{
          document.getElementById('confirmNewPassword').className = "form-control is-invalid"
          document.getElementById('newPassword').className = "form-control is-invalid"
          window.scroll(0, 0);
          document.getElementById('newPassword').focus();
          $('#alert').toast('show')
      } 
    }

function soloNumerosConadis(e){
  key=e.keyCode||e.which;
  teclado=String.fromCharCode(key);
  numero="0123456789.";
  especiales="8-37-38-46";
  teclado_especial=false;
    for(var i in especiales){
      if(key==especiales[i]){
        teclado_especial=true;
      }
    }
    if (numero.indexOf(teclado)==-1 && !teclado_especial) {
      return false;
    }
} 

  function validarConadis(input){
    const carnet = input.value;
      if(carnet.substr(2,1) != "."){
        input.className="form-control is-invalid"
        input.value=""
        input.focus();
      }else{
        input.className="form-control is-valid"
      }
  }
</script>

</body>
</html>