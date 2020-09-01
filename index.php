<?php 
        session_start();
        $_SESSION['paciente'] = 0;
  ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
    <title>Clinica Vitalia</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/carousel/">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="../assets/dist/css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="assets/styles/component/carousel.css" rel="stylesheet">
    <link rel="icon" href="clinicavitalia.ico">
  </head>
  <body>
    <header>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="index.html">
      <span style="font-weight:normal;">Clinica</span>
      <span style="font-weight:bold;">Vitalia</span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="formAspirantes.php">Postulate</a>
        </li>
        <?php
          if( $_SESSION['paciente'] == 1):
        ?>
          <li class="nav-item">
            <a class="nav-link" href="app/modulos/citasmedicas/index.php">Citas Medicas</a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" href="app/modulos/citasmedicas/cita.php">Historial Clinico</a>
          </li> -->
        <?php
          endif;
        ?>
      </ul>

      <?php 
        
          if(!empty($_SESSION['user_id'])): 
            require 'database.php';
                $credenciales = $conn->query("SELECT * FROM usuario_credencial WHERE id_usuario_uc =".$_SESSION['user_id'])->fetchAll(PDO::FETCH_OBJ);
                $_SESSION['modulo_rrhh'] = 0;
                $_SESSION['modulo_suministros'] = 0;
                $_SESSION['modulo_contabilidad'] = 0;
                $_SESSION['modulo_ctas_medicas'] = 0;
                $_SESSION['modulo_pacientes'] = 0;
                $_SESSION['modulo_seguridad'] = 0;
                $_SESSION['paciente'] = 0;
                $_SESSION['nombre_credencial'] = "";
                
                foreach ($credenciales as $idCredencial){ 

                    $records = $conn->prepare("SELECT * FROM usuario_credencial AS uc, credencial_base AS c, usuario AS u WHERE (uc.id_credencialbase_uc = c.id_credencial AND uc.id_usuario_uc = u.id_usuario) AND id_usuario_credencial = :id_usuario_credencial");
                    $records->bindParam(':id_usuario_credencial', $idCredencial->id_usuario_credencial);
                    $records->execute();
                    $results = $records->fetch(PDO::FETCH_ASSOC); 
                    if($results['modulo_rrhh'] == 1){
                      $_SESSION['modulo_rrhh'] = 1;
                    }
                    if($results['modulo_suministros'] == 1){
                      $_SESSION['modulo_suministros'] = 1;
                    }
                    if($results['modulo_contabilidad'] == 1){
                      $_SESSION['modulo_contabilidad'] = 1;
                    }
                    if($results['modulo_ctas_medicas'] == 1){
                      $_SESSION['modulo_ctas_medicas'] = 1;
                    }
                    if($results['modulo_pacientes'] == 1){
                      $_SESSION['modulo_pacientes'] = 1;
                    }
                    if($results['paciente'] == 1){
                      $_SESSION['paciente'] = 1;
                    }
                    if($results['modulo_seguridad'] == 1) {
                      $_SESSION['modulo_seguridad'] = 1;
                    }
                    if($_SESSION['nombre_credencial'] == ""){
                      $_SESSION['nombre_credencial'] = strtoupper($results['nombre_credencial']);
                    }else{
                      $_SESSION['nombre_credencial'] = $_SESSION['nombre_credencial'].", ".strtoupper($results['nombre_credencial']);
                    }
                }
                
                $_SESSION['username'] = ucwords($results['username']);
                

      ?>
          
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
                echo "<a class='dropdown-item' href='app/modulos/citasmedicas/citas.php'><i class='fas fa-notes-medical mr-3'></i> Citas agendadas</a>";

                echo "<a class='dropdown-item' href='app/modulos/citasmedicas/historial_clinico.php'><i class='fas fa-notes-medical mr-3'></i>Historial clinico</a>";
              }
              if($_SESSION['modulo_pacientes'] == 1){
                echo "<a class='dropdown-item' href='app/modulos/pacientes/'><i class='fas fa-procedures mr-2'></i> Modulo Pacientes</a>";
              }
              if($_SESSION['modulo_seguridad'] == 1){
                echo "<a class='dropdown-item' href='app/modulos/seguridad/'><i class='fas fa-user-shield mr-2'></i> Modulo Seguridad</a>";
              }
              if($_SESSION['paciente'] == 1){
                echo "<a class='dropdown-item' href='app/modulos/pacientes/home.php'><i class='fas fa-procedures mr-2'></i> Pacientes</a>";

                echo "<a class='dropdown-item' href='app/modulos/citasmedicas/index.php'><i class='fas fa-notes-medical mr-3'></i> Citas Medicas</a>";

                echo "<a class='dropdown-item' href='app/modulos/citasmedicas/historial_clinico.php'><i class='fas fa-notes-medical mr-3'></i> Historial clinico </a>";


              }
              
            ?>            
            <!-- <a class='dropdown-item' href='#'><i class='fas fa-file-medical-alt mr-3'></i> Historial Clinico</a> -->
            <hr class="ml-4 mr-4 mt-2">
            <a class='dropdown-item mt-2' style="float:right;" href='app/modulos/seguridad/routes/perfil.php'><span class="float-right">Ajustes de Usuario</span></a>
            <a class='dropdown-item' style="float:right;" href='#'><span class="float-right">Another</span></a>
            <a class='dropdown-item' style="float:right;" href='app/modulos/seguridad/controllers/logout.php'><span class="float-right">Cerrar Sesión</span></a>
          </div>
       
      <?php else: ?>
        <span class="navbar-text">
          <a class='' href='app/modulos/seguridad/routes/login.php'>Iniciar sesión</a>
        </span>   
      <?php endif; ?>
      
      <!-- <li class='justify-content-end'>
        
      </li> -->
    </div>
  </nav>
</header>

<main role="main">

  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img class="bd-placeholder-img" src="assets/images/img1.jpg" alt="" width="100%" height="100%" preserveAspectRatio="xMidYMid slice">
        <!-- <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="assets/images/img1.jpg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img"><rect width="100%" height="100%" fill="#777"/></svg> -->
        <div class="container">
          <div class="carousel-caption text-left">
            <h1 style="color:#212121;">Agenda citas desde cualquier lugar.</h1>
            <p class="font-weight-bold" style="color:#212121;">Clínica Vitalia es una institución privada conformada por un selecto grupo de profesionales del área de la salud, preocupados de entregar asistencia, prevencion y diagnostico, a través de tratamientos integrales con un trato familiar y personalizado.
            Nuestra clínica esta ubicada en pleno centro de Buin y cuenta con instalaciones diseñadas para dar el máximo confort a nuestros pacientes con un moderno equipamiento y así ofrecer una asistencia de calidad.</p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <img class="bd-placeholder-img" src="assets/images/img2.jpg" alt="" width="100%" height="100%" preserveAspectRatio="xMidYMid slice">
        <!-- <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img"><rect width="100%" height="100%" fill="#777"/></svg> -->
        <div class="container">
          <div class="carousel-caption">
            <p class="font-weight-bold" style="color:#212121;">Ser una Clínica cercana a las personas,  siendo reconocida en nuestra comuna por alcanzar altos estándares de calidad en la atención, con excelencia profesional, humana y ética de nuestra gente y con equipamientos de tecnología avanzada.</p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
      <img class="bd-placeholder-img" src="assets/images/img4.jpg" alt="" width="100%" height="100%" preserveAspectRatio="xMidYMid slice">
        <!-- <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img"><rect width="100%" height="100%" fill="#777"/></svg> -->
        <div class="container">
          <div class="carousel-caption text-right">
            <p class="font-weight-bold" style="color:#212121;">El recurso más importante de nuestra Clínica es nuestro personal, por lo que procuramos su satisfacción, desarrollo y bienestar, a través de la expresión de sus cualidades a través del trabajo en equipo y permanente formación.</p>
          </div>
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>


  <!-- Marketing messaging and featurettes
  ================================================== -->
  <!-- Wrap the rest of the page in another container to center all the content. -->

  <div class="container marketing">

    <!-- Three columns of text below the carousel -->
    <div class="row">
      <div class="col-lg-4">
        <img class="bd-placeholder-img rounded-circle" src="assets/images/img10.jpg" alt="" width="140" height="140" preserveAspectRatio="xMidYMid slice">
        <h2>Solicita Citas Medicas</h2>
        <p>Ingresa a nuestro modulo de pacientes para poder solicitar una consulta medica en cualquier especialidad de nustra clinica y el horario que usted escoja.</p>
        <p><a class="btn btn-secondary" href="app/modulos/pacientes/home.php" role="button">Más detalles &raquo;</a></p>
      </div><!-- /.col-lg-4 -->
      <div class="col-lg-4">
        <img class="bd-placeholder-img rounded-circle" src="assets/images/img10.jpg" alt="" width="140" height="140" preserveAspectRatio="xMidYMid slice">
        <!-- <svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 140x140"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"/><text x="50%" y="50%" fill="#777" dy=".3em">140x140</text></svg> -->
        <h2>Revisa tu historial clinico</h2>
        <p>Revisa tus citas agendadas y el historial de tratamiento, diagnostico dado en tu consulta desde cualquier lugar en donde te encuentres.</p>
        <p><a class="btn btn-secondary" href="app/modulos/pacientes/home.php" role="button">Más detalles &raquo;</a></p>
      </div><!-- /.col-lg-4 -->
      <div class="col-lg-4">
        <img class="bd-placeholder-img rounded-circle" src="assets/vitalia.png" alt="" width="240" height="140" preserveAspectRatio="xMidYMid slice">
        <!-- <svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 140x140"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"/><text x="50%" y="50%" fill="#777" dy=".3em">140x140</text></svg> -->
        <h2>Registrate en nuestra pagina</h2>
        <p>Puedes registrarte en cualquier momento para ser parte de nuestros pacientes.</p>
        <p><a class="btn btn-secondary" href="app/modulos/seguridad/routes/registro.php" role="button">Registrarme &raquo;</a></p>
      </div><!-- /.col-lg-4 -->
    </div><!-- /.row -->


    <!-- START THE FEATURETTES -->

    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7">
        <h2 class="featurette-heading">Clinica Vitalia. <span class="text-muted">Nuestro Compromiso.</span></h2>
        <p class="lead">El compromiso honesto de hacer bien las cosas, haciendo honor a la confianza que nos entrega cada uno de los pacientes, sin ninguna distinción.</p>
      </div>
      <div class="col-md-5">
        <img class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" src="assets/images/img7.jpg" alt="" width="500" height="500" preserveAspectRatio="xMidYMid slice">
        <!-- <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 500x500"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"/><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text></svg> -->
      </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7 order-md-2">
        <h2 class="featurette-heading">Clinica Vitalia. <span class="text-muted">Nuestro Personal.</span></h2>
        <p class="lead">Somos un grupo de profesionales que tenemos en común una clara misión de entregar bienestar y satisfacción a sus pacientes a través de servicios de alta calidad y a un precio justo, siempre apegados a altas normas de seguridad y ética.</p>
      </div>
      <div class="col-md-5 order-md-1">
        <img class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" src="assets/images/img8.jpg" alt="" width="500" height="500" preserveAspectRatio="xMidYMid slice">
        <!-- <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 500x500"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"/><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text></svg> -->
      </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7">
        <h2 class="featurette-heading">Clinica Vitalia. <span class="text-muted">Eco Friendly.</span></h2>
        <p class="lead">Somos una clínica Eco Friendly, nos enfocamos en lograr los resultados esperados con el mínimo impacto negativo en el medio ambiente.</p>
      </div>
      <div class="col-md-5">
        <img class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" src="assets/images/img5.jpg" alt="" width="500" height="500" preserveAspectRatio="xMidYMid slice">
        <!-- <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 500x500"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"/><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text></svg> -->
      </div>
    </div>

    <hr class="featurette-divider">

    <!-- /END THE FEATURETTES -->

  </div><!-- /.container -->


  <!-- FOOTER -->
  <footer class="container">
    <p class="float-right"><a href="#">Ir arriba</a></p>
    <p>&copy; 2020-2021 Todos los derechos reservados 8B, Inc. &middot; <a href="#">Terminos</a> &middot; <a href="#"></a></p>
  </footer>
</main>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>  <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="../assets/dist/js/bootstrap.bundle.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    </body>
</html>
