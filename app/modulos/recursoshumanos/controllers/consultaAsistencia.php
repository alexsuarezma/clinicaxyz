
<?php
header('Content-Type: application/json');
$pdo=new PDO("mysql:dbname=heroku_fe7e002859673b2;host=us-cdbr-east-05.cleardb.net","b7550b2dcd9c38","a16e5057");
$_GET['cedula'];

$asistencia = $pdo->prepare("SELECT * FROM asistencia_empleado AS a, empleados AS e WHERE a.id_empleado_asis = e.id_empleados AND id_empleado_asis = ".$_GET['cedula']." ORDER BY start ASC");
// $asistencia = $pdo->prepare("SELECT * FROM asistencia_empleado AS a, empleados AS e WHERE a.id_empleado_asis = e.id_empleados AND id_empleado_asis = 0955317979 ORDER BY start ASC");
$asistencia->execute();

$resultado=$asistencia->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($resultado);
