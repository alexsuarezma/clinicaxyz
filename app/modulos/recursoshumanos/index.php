<?php
  require '../../../database.php';
  
  if(!empty($_POST['cedula'])){
    try {
      $sql = "INSERT INTO empleados (cedula,nombres,apellidos,fechaNacimiento,sexo,especialidad,telefono,email,direccion,personal,ciudad) VALUES (:cedula, :nombres, :apellidos, :fechaNacimiento, :sexo, :especialidad, :telefono, :email, :direccion, :personal, :ciudad)";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':cedula', $_POST['cedula']);
      $stmt->bindParam(':nombres',$_POST['nombres']);
      $stmt->bindParam(':apellidos',$_POST['apellidos']);
      $stmt->bindParam(':fechaNacimiento',$_POST['fechaNacimiento']);
      $stmt->bindParam(':sexo',$_POST['sexo']);
      $stmt->bindParam(':ciudad',$_POST['ciudad']);
      $stmt->bindParam(':especialidad',$_POST['especialidad']);
      $stmt->bindParam(':telefono',$_POST['telefono']);
      $stmt->bindParam(':email',$_POST['email']);
      $stmt->bindParam(':direccion',$_POST['direccion']);
      $stmt->bindParam(':personal',$_POST['personal']);
      if($stmt->execute()){
        header("Location:localhost/clinicaxyz");
      }
  } catch (PDOException $e) {
      die('Problema: ' . $e->getMessage());
  }
   
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
    <title>Dashboard Template · Bootstrap</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/dashboard/">

    <!-- Bootstrap core CSS -->
<link href="../assets/dist/css/bootstrap.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="assets/styles/component/dashboard.css" rel="stylesheet">
  </head>
  <body>
<?php
  require 'layout.php'
?>
<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="sidebar-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="../index.html">
              <span data-feather="home"></span>
              Home Page <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="briefcase"></span>
              Contrato
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="users"></span>
              Personal
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="bar-chart-2"></span>
              Reportes
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="layers"></span>
              Reclutamiento
            </a>
          </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Saved reports</span>
          <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
            <span data-feather="plus-circle"></span>
          </a>
        </h6>
        <ul class="nav flex-column mb-2">
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Current month
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Last quarter
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Social engagement
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Year-end sale
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
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

      <h2>Nuevo contrato</h2>
      <div class="container mt-5">
          <form action="" method="POST">
            <div class="form-row">
                <div class="col-md-6 mb-3">
                  <label for="validationServer01">Numero de cedula</label>
                  <input type="text" name="cedula" class="form-control is-invalid" id="validationServer01" required>
                </div>
            </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationServer01">Nombres</label>
              <input type="text" name="nombres" class="form-control" id="validationServer02" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="validationServer02">Apellidos</label>
              <input type="text" name="apellidos" class="form-control" id="validationServer03" required>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationServer03">Dirección</label>
              <input type="text" name="direccion" class="form-control" id="validationServer04" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="validationServer04">Numero de telefono</label>
              <input type="text" name="telefono" class="form-control" id="validationServer05" required>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationServer05">Correo electronico</label>
              <input type="email" name="email" class="form-control" id="validationServer06" required>
            </div>
            <div class="col-md-3 mb-3">
              <label for="validationServer06">Personal</label>
              <select class="custom-select" name="personal" id="validationServer07" required>
                <option selected disabled value="">Seleccione...</option>
                <option>Administrativo</option>
                <option>Medico</option>
                <option>Asistencial</option>
              </select>
              <div class="invalid-feedback">
                <!--mensaje para feedback del campo.-->
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <label for="validationServer07">Especialidad</label>
              <select class="custom-select" name="especialidad" id="validationServer08" required>
                <option selected disabled value="">Seleccione...</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
              </select>
              <div class="invalid-feedback">
                <!--mensaje para feedback del campo.-->
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationServer08">Ciudad</label>
              <input type="text" name="ciudad" class="form-control" id="validationServer09" required>
              <div class="invalid-feedback">
                Porfavor escriba la ciudad
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <label for="validationServer09">Sexo</label>
              <select class="custom-select" name="sexo" id="validationServer10" required>
                <option selected disabled value="">Seleccione...</option>
                <option>Hombre</option>
                <option>Mujer</option>
                <option>No definido</option>
              </select>
              <div class="invalid-feedback">
                <!--mensaje para feedback del campo.-->
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <label for="validationServer10">Fecha de nacimiento</label>
              <input type="date" name="fechaNacimiento" class="form-control" id="validationServer11" required>
              <div class="invalid-feedback">
                <!--mensaje para feedback del campo.-->
              </div>
            </div>
          </div>
          <button class="btn btn-primary" type="submit" id="btn-submit">Registrar</button>
        </form>
      </div>
    </main>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="../assets/dist/js/bootstrap.bundle.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <script src="assets/static/dashboard.js"></script>      
      </body>
</html>
