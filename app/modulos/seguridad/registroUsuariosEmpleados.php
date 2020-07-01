<?php
require 'database.php';

$message = '';
$tipoUsuario = $conn->query("SELECT * FROM tipo_prueba ORDER BY nombre_tipo_prueba ASC")->fetchAll(PDO::FETCH_OBJ);

  if(!empty($_POST['user']) && !empty($_POST['password'])){
      $sql = "INSERT INTO prueba (username, pass, id_tipo_prueba) VALUES (:username, :pass, :id_tipo_prueba)";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':username', $_POST['user']);
      $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
      $stmt->bindParam(':pass', $password);
      $stmt->bindParam(':id_tipo_prueba', $_POST['tipoUsuario']);

      if($stmt->execute()){
        $message = 'Usuario creado exitosamente';
        header("Location: index.php");
      }else{
        $message = 'Error al crear nuevo usuario';
      }

  }
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
	<title>Registrarse</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/sign-in/">
    
    <link href="../assets/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="signin.css" rel="stylesheet">
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
</head>
<body class="text-center">

	<!-- <h1>Registrate</h1> -->

	<form class="form-signin" action="registro.php" method="POST">
  <h1 class="h3 mb-3 font-weight-normal">Registro Usuarios de Empleados</h1>
		<input type="text" class="form-control" name="user" placeholder="Ingrese tu Nombre de Usuario" require>
		<input type="password" class="form-control mt-2" name="password" placeholder="Ingrese su contraseña" require>
    <input type="password" class="form-control" name="confirm_password" placeholder="Confirmar su contraseña" require>
      <label>Tipo Usuario</label>
        <select class="custom-select mb-3" name="tipoUsuario" id="validationServer42" required>
          <option selected disabled value="">Seleccione...</option>
          <?php
          foreach ($tipoUsuario as $usuarios):
          ?>
             <option value="<?php echo $usuarios->id_tipo;?>"><?php echo utf8_encode($usuarios->nombre_tipo_prueba);?></option>
          <?php 
          endforeach;
          ?> 
        </select>
		<button class="btn btn-lg btn-primary btn-block" type="submit">Registrar</button>
	</form>

</body>
</html>