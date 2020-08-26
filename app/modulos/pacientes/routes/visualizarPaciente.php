

<?php
require '../components/LayoutAdmin.php';
require '../../../../database.php';
require '../../seguridad/controllers/functions/credenciales.php';

verificarAcceso("../../../../", "modulo_pacientes");

$paciente = $conn->query("SELECT * FROM pacientes ORDER BY idpacientes ASC")->fetchAll(PDO::FETCH_OBJ);

?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Modulo Pacientes | Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../../recursoshumanos/assets/styles/component/dashboard.css" rel="stylesheet">
  </head>
  <body>
<?php
printLayout ('../index.php', '../../../../index.php', 'registrar.php', '#', 'visualizarPaciente.php', '#','routes/subirArchivo.php',
'../../seguridad/controllers/logout.php','../../seguridad/routes/perfil.php',
  '../../recursoshumanos/','../../suministro/','../../contabilidad/','../../citasmedicas/','../index.php','../../seguridad/',4);
?>
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">PACIENTES</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        </div>
      </div>
      <div class="container mt-5">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                <th width="150px;">Cedula</th>
                <th width="350px">Nombres</th>
                <th width="">Ingreso</th>
                <th width="">Sexo</th>
                <th></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($paciente AS $Pacientes): ?>
                <tr>
                <th><?php echo $Pacientes->idpacientes; ?></th>
                <td><?php echo $Pacientes->nombres." ".$Pacientes->ape_paterno." ".$Pacientes->ape_mat ?></td>
                <td><?php echo substr($Pacientes->created_at,0,10);?></td>
                <td><?php if($Pacientes->sexo == 'V'){ echo 'Varón';}elseif($Pacientes->sexo == 'M'){ echo 'Mujer';} ?></td>
                <td><a href="informacion.php?cedula=<?php echo $Pacientes->idpacientes;?>"><i class="fas fa-user-edit" style="font-size:18px; color:black;" title="Acciones a Pacientes"></i></a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
      </div>
    </main>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>     
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="../../recursoshumanos/components/scripts/dashboard.js"></script>          
</body>
</html>














