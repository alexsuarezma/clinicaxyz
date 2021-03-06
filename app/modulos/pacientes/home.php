<?php
require 'components/LayoutPublic.php';
require '../../../database.php';
require '../seguridad/controllers/functions/credenciales.php';
verificarAcceso("../seguridad/routes/login.php", "paciente");

?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Pacientes | Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../recursoshumanos/assets/styles/component/dashboard.css" rel="stylesheet">
  </head>
  <body>
<?php
printLayout ('home.php', '../../../index.php', '../citasmedicas/', 'routes/diagnostico.php', 'routes/facturas.php','../seguridad/controllers/logout.php','../seguridad/routes/perfil.php','home.php',1);
?>
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><span style="color:#0074D9">¡Bienvenido!</span> <?php echo $_SESSION['username']?></h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        </div>
      </div>
      <div class="container mt-5 d-flex justify-content-center" style="height:600px;">
          <img src="../../../assets/vitalia.png" class="img-fluid" width="1400px" alt="Responsive image">
      </div>
    </main>
  </div>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="../recursoshumanos/components/scripts/dashboard.js"></script>        
</body>
</html>
