<?php
require '../../../../database.php';

  session_start();
  
  $message = '';
    if (isset($_SESSION['user_id'])) {
          header("Location: ../../../../");
    }

      if(!empty($_POST['cedula']) && !empty($_POST['password'])){
        //CONSULTA PRIMERO EN LA TABLA PACIENTES, LA CEDULA SI EXISTE, VERIFICAMOS EL CAMPO IDUSER PARA CONSULTAR SU USUARIO.PASSWORD
        $cedula = $_POST['cedula'];
        $paciente = $conn->query("SELECT * FROM pacientes WHERE idpacientes = $cedula")->rowCount();
        $empleado = $conn->query("SELECT * FROM empleados WHERE id_empleados = $cedula")->rowCount();
        
          //es paciente
          if($paciente > 0){
            $consulta = $conn->prepare("SELECT id_usuario,password FROM pacientes AS p, usuario AS u WHERE (p.id_usuario_pac = u.id_usuario) AND idpacientes = :idpacientes");
            $consulta->bindParam(':idpacientes', $_POST['cedula']);
            $consulta->execute();
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC); 
          }    
          //es empleado
          if($empleado > 0){
            $consulta = $conn->prepare("SELECT id_usuario,password FROM empleados AS e, usuario AS u WHERE (e.id_usuario_emp = u.id_usuario) AND id_empleados = :id_empleados");
            $consulta->bindParam(':id_empleados', $_POST['cedula']);
            $consulta->execute();
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC); 
          }
      
          if($paciente == 0 && $empleado == 0){
            $message = 'Lo sentimos, las credenciales que ingreso no son correctas';
          }else{
              // if ($_POST['password'] == $resultado['password'])   
              if(password_verify($_POST['password'],$resultado['password'])){

                  $_SESSION['user_id'] = $resultado['id_usuario'];

                  $records  = $conn->prepare('SELECT * FROM usuario_credencial AS u, credencial_base AS c WHERE (u.id_credencialbase_uc = c.id_credencial) AND (id_usuario_uc=:id_usuario)');
                  $records->bindParam(':id_usuario', $_SESSION['user_id']);
                  $records->execute();
                  $results = $records->fetch(PDO::FETCH_ASSOC);

                  $_SESSION['user_credential'] = $results['id_credencial'];
                  
                  header("Location: ../../../../");
              }else{
                $message = 'Lo sentimos, las credenciales que ingreso no son correctas';
              }
          }

      }
?>
<!Doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
    <title>Seguridad</title>
    <!-- Bootstrap core CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" 
integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

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
  <link href="../assets/styles/component/signin.css" rel="stylesheet">
  </head>
  <body class="text-center">
    <form class="form-signin" method="POST" action="login.php" autocomplete="off">
      <?php if(!empty($message)): ?>
        <h5 style="text-align: center;"><?php echo $message ?></h5>
      <?php endif; ?>
    
      <img class="mb-4" src="../assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Login</h1>
      <label for="cedula" class="sr-only">Ingrese Cedula</label>
      <input type="text" name="cedula" id="cedula" onkeypress="return soloNumeros(event)" maxlength="10" class="form-control" placeholder="User" required autofocus>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
      <!-- <div class="checkbox mb-3">
        {Recuerdame} 
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div> -->
      <button class="btn btn-lg btn-primary btn-block" type="submit">Iniciar</button>
      <a href="registro.php">Registrarse</a>
      <p class="mt-5 mb-3 text-muted">&copy; 2019-2020</p>
    </form>
<script src="../controllers/validations/validations.js"></script>  
</body>
</html>