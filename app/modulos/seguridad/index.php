<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: /prueba');
  }

require 'database.php';

if(!empty($_POST['user']) && !empty($_POST['password'])){
	$consulta = $conn->prepare('SELECT id, user, password FROM user WHERE user=:user LIMIT 1');
	$consulta->bindParam(':user', $_POST['user']);
	$consulta->execute();
	$resultado = $consulta->fetch(PDO::FETCH_ASSOC);

	$message = '';

	if (count($resultado) > 0 && ($_POST['password'] == $resultado['password'])) {
		$_SESSION['user_id'] = $resultado['id'];
		header("Location: /prueba/prueba.html");
	}else{
		$message = 'Lo sentimos el usuario o contraseña no son correctos';
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
    <title>Seguridad</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/sign-in/">

    <!-- Bootstrap core CSS -->
<link href="../assets/dist/css/bootstrap.css" rel="stylesheet">
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
    <link href="signin.css" rel="stylesheet">
  </head>
  <body class="text-center">
    <script type="text/javascript">
    function soloNumeros(e){
        key=e.keyCode||e.which;
        teclado=String.fromCharCode(key);
        numero="0123456789";
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
    </script>
   

    <form class="form-signin" method="POST" action="index.php">
    
    
  <img class="mb-4" src="../assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
  <h1 class="h3 mb-3 font-weight-normal">Login</h1>
  <label for="cedula" class="sr-only">Ingrese Cedula</label>
  <input type="text" name="user" id="cedula" maxlength="10" onkeypress="return soloNumeros(event)" class="form-control" placeholder="User" required autofocus>
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
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>