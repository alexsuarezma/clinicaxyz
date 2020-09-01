<?php
require '../components/LayoutAdmin.php';
require '../../../../database.php';
require '../../seguridad/controllers/functions/credenciales.php';

 verificarAcceso("../../../", "modulo_pacientes");

 $pago = $conn->query("SELECT *, pa.nombres as paciennombres FROM pacientes AS pa, pagos AS ps, citas AS ci, citas_medicos AS cm, empleados_medico AS em, empleados AS emp, especialidades AS esp WHERE (ci.paciente=pa.idpacientes AND ci.idcitas=ps.id_cita AND ci.idcitas=cm.cita AND cm.medico=em.id_medico AND em.id_especialidad_medico=esp.idespecialidades AND em.id_empleados_medico=emp.id_empleados) ORDER BY fecha DESC")->fetchAll(PDO::FETCH_OBJ);

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
    <style>
        #busqueda {
                background-image: url('/css/searchicon.png');
                background-position: 10px 12px;
                background-repeat: no-repeat;
                width: 100%;
                font-size: 16px;
                padding: 12px 20px 12px 40px;
                border: 1px solid #ddd;
                margin-bottom: 12px;
            }
    </style>
  </head>
  <body>
  <?php
    printLayout ('../index.php', '../../../../index.php', 'registrar.php', '../../citasmedicas/historial_clinico.php','../../citasmedicas/citas.php', 'visualizarPaciente.php', 'pacientesBaja.php', 'pagos.php','subirArchivo.php',
    '../../seguridad/controllers/logout.php','../../seguridad/routes/perfil.php',
      '../../recursoshumanos/','../../suministro/','../../contabilidad/','../../citasmedicas/','index.php','../../seguridad/',7);
    ?>
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Historial de Citas Facturadas</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        </div>
      </div>
      <div class="container">
        <input type="text" name="busqueda" id="busqueda" placeholder="Buscar facturas..." title="Type in a name">
      </div>
      <div class="container mt-5">
        <table class="table">
        <thead>
            <tr>
            <th>Historial</th>
            <th>Fecha</th>
            <th>Precio Total</th>
            <th>Tipo Pago</th>
            <th>Estado</th>
            <th></th>
            </tr>
        </thead>
        <tbody id="datos">
            <?php foreach($pago as $Pagos):?>
                <tr>
                <th style="width:400px;">Cedula Paciente: <span class='font-weight-normal'><?php echo $Pagos->idpacientes?></span><br>Paciente: <span class='font-weight-normal'><?php echo $Pagos->paciennombres." ".$Pagos->ape_paterno." ".$Pagos->ape_mat?></span><br> Medico: <span class='font-weight-normal'><?php echo $Pagos->nombres." ".$Pagos->apellidos?></span><br> Cita Agendada del Servicio de: <span class='font-weight-normal'><?php echo utf8_encode($Pagos->descripcion)?></span><br>
                Hora: <span class='font-weight-normal'><?php echo $Pagos->id_hora?></span>
                </th>
                <td><?php echo $Pagos->fecha?></td>
                <td><?php echo $Pagos->sub_total + ($Pagos->sub_total * 0.12)?> US$ order #<?php echo $Pagos->id_order?></td>
                <td>Tarjeta de Credito</td>
                <td><?php echo $Pagos->estado?></td>
                <td style="width:100px;"><a class="btn btn-outline-info" style="font-size:12px;" href="../../citasmedicas/historial_clinico.php?id_paciente=<?php echo $Pagos->idpacientes?>&id_citas=<?php echo $Pagos->idcitas?>"> Ver cita</a></td>
                </tr>
            <?php endforeach;?>
        </tbody>
        </table>
      </div>
    </main>
  </div>
</div>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="../../recursoshumanos/components/scripts/dashboard.js"></script>  
<script type="text/javascript" src="../components/scripts/filtroFacturas.js"></script>   
</body>
</html>
