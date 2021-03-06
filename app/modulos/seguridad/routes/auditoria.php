<?php
require '../../../../database.php';
require '../components/layout.php';
require '../../recursoshumanos/components/modal.php';
require '../controllers/functions/credenciales.php';

verificarAcceso("../../../../", "modulo_seguridad");

$auditoria = $conn->query("SELECT * FROM auditoria ORDER BY created_at DESC")->fetchAll(PDO::FETCH_OBJ);

?>

<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title> Seguridad | Auditoria</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link href="../assets/styles/dashboard.css" rel="stylesheet">
  </head>
  <body>
<?php
printLayout('../index.php', '../../../../index.php', 'credencial.php', 'scopes.php', 'usuarios.php', 'cargos.php', 'auditoria.php', '../controllers/logout.php',
'perfil.php','../../recursoshumanos/','../../suministro/','../../contabilidad/','../../citasmedicas/','../../pacientes/','../../seguridad/',6);
?>
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">AUDITORIA</h1>
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
     
    <div class="container mt-5 mb-5">
          <!-- PROJECT TABLE  -->
          <table class="table colored-header datatable project-list">
            <thead>
                <tr>
                    <th style="width:40px;">Acción</th>
                    <th style="width:80px;">Modulo</th>
                    <th style="width:160px;">Descripcion</th>
                    <th style="width:40px;">Usuario</th>
                    <th style="width:40px;">Credencial</th>
                    <th style="width:80px;">Fecha</th>
                  </tr>
            </thead>
            <tbody>
            <?php foreach($auditoria as $Auditorias):
                    $user = $conn->query("SELECT * FROM empleados WHERE id_usuario_emp=".$Auditorias->usuario)->fetchAll(PDO::FETCH_OBJ);
              ?>
                <tr>
                    <td><?php echo utf8_encode($Auditorias->accion);?></td>
                    <td><?php echo utf8_encode($Auditorias->modulo);?></td>
                    <td><?php echo utf8_encode($Auditorias->descripcion);?></td>
                    <td><?php echo utf8_encode($user[0]->nombres." ".$user[0]->apellidos);?></td>
                    <td><?php echo utf8_encode($Auditorias->credencial);?></td>
                    <td><?php echo utf8_encode($Auditorias->created_at);?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
      </div>
      <p>
</p>
    </main>

</div>
<script src="../components/scripts/jquery.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="../components/scripts/dashboard.js"></script> 
<script src="../components/scripts/consulta.js"></script>    
</body>
</html>