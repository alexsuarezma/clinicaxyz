<?php
  require '../../../../database.php';
  require '../components/layout.php';

  if(!empty($_POST['cedula'])){
    try {
      $sql = "INSERT INTO empleados (cedula,profileimage,nombres,apellidos,sexo,telefono,email,direccion,nacionalidad,ciudad,fechaNacimiento,
      estadoCivil,idhorario,idcontrato,salarioBase,personal,deleted,disponible,created_at,updated_at) VALUES (:cedula, :profileimage, :nombres, :apellidos, :sexo, :telefono, :email, :direccion, :nacionalidad, :ciudad, :fechaNacimiento, :estadoCivil, :idhorario, :idcontrato, :salarioBase, :personal, :deleted, :disponible, :created_at, :updated_at) ";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':cedula', $_POST['cedula']);
      $stmt->bindValue(':profileimage', null, PDO::PARAM_INT);
      $stmt->bindParam(':nombres',$_POST['nombres']);
      $stmt->bindParam(':apellidos',$_POST['apellidos']);
      $stmt->bindParam(':sexo',$_POST['sexo']);
      $stmt->bindParam(':telefono',$_POST['telefono']);
      $stmt->bindParam(':email',$_POST['email']);
      $stmt->bindParam(':direccion',$_POST['direccion']);
      $stmt->bindParam(':nacionalidad',$_POST['nacionalidad']);
      $stmt->bindParam(':ciudad',$_POST['ciudad']); 
      $stmt->bindParam(':fechaNacimiento',$_POST['fechaNacimiento']);
      $stmt->bindParam(':estadoCivil',$_POST['estadoCivil']);
      $stmt->bindParam(':idhorario',$_POST['horario']);
      $stmt->bindParam(':idcontrato',$_POST['contrato']);
      $stmt->bindParam(':salarioBase',$_POST['salarioBase']);
      $stmt->bindParam(':personal',$_POST['personal']);
      $stmt->bindValue(':deleted', 0, PDO::PARAM_INT);
      $stmt->bindValue(':disponible', 1, PDO::PARAM_INT);
      $stmt->bindValue(':created_at', null, PDO::PARAM_INT);
      $stmt->bindValue(':updated_at', null, PDO::PARAM_INT);
    
      if($stmt->execute()){
        header("Location:create.php");
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
    <!-- Custom styles for this template -->
    <link href="../assets/styles/component/dashboard.css" rel="stylesheet">
  </head>
  <body>
<?php
  printLayout('../index.php', '../../../../index.html', 'contrato.php', 'personal.php');
?>
<div class="container-fluid">
  <div class="row">

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
      <div class="container mt-5 mb-5">
          <form action="" method="POST">
            <div class="form-row">
                <div class="col-md-6 mb-3">
                  <label for="validationServer01">Numero de cedula</label>
                  <input type="text" name="cedula" class="form-control" id="validationServer01" maxlength="10" onkeypress="return soloNumeros(event)" onpaste="return false" required>
                  <div class="invalid-feedback">
                    Numero de cedula invalida.
                  </div>
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
              <label for="validationServer08">Contrato</label>
              <input type="text" name="contrato" class="form-control" id="validationServer09" required>
            </div>
            <div class="col-md-3 mb-3">
              <label for="validationServer09">Estado civil</label>
              <select class="custom-select" name="estadoCivil" id="validationServer10" required>
                <option selected disabled value="">Seleccione...</option>
                <option>Soltero</option>
                <option>Casado</option>
                <option>Union libre</option>
              </select>
              <div class="invalid-feedback">
                <!--mensaje para feedback del campo.-->
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <label for="validationServer10">Nacionalidad</label>
              <select class="custom-select" name="nacionalidad" id="validationServer11" required>
                <option selected disabled value="">Seleccione...</option>
                <option>Ecuatoriana</option>
                <option>Extranjera</option>
                <option>3</option>
              </select>
              <div class="invalid-feedback">
                <!--mensaje para feedback del campo.-->
              </div>
            </div>
          </div>
          
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationServer11">Salario base</label>
              <input type="text" name="salarioBase" class="form-control" id="validationServer12 " required>
            </div>
            <div class="col-md mb-3">
              <label for="validationServer12">Horario</label>
              <select class="custom-select" name="horario" id="validationServer13" required>
                <option selected disabled value="">Seleccione...</option>
                <option>Matutino</option>
                <option>Vespertino</option>
                <option>Rotativo</option>
                <option>Indistinto</option>
              </select>
              <div class="invalid-feedback">
                <!--mensaje para feedback del campo.-->
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationServer14">Ciudad</label>
              <input type="text" name="ciudad" class="form-control" id="validationServer15" required>
              <div class="invalid-feedback">
                Porfavor escriba la ciudad
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <label for="validationServer15">Sexo</label>
              <select class="custom-select" name="sexo" id="validationServer16" required>
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
              <label for="validationServer16">Fecha de nacimiento</label>
              <input type="date" name="fechaNacimiento" class="form-control" id="validationServer17" required>
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
        <script src="../components/scripts/dashboard.js"></script>   
        <script src="../controllers/validation.js"></script>         
      </body>
</html>
