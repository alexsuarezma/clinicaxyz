<?php
require_once realpath(__DIR__ . "../../../../../vendor/autoload.php");   
require '../../../../database.php';
require_once('../components/plantilla/contrato.php');
session_start();
$css = file_get_contents('../components/plantilla/style.css');



$mpdf = new \Mpdf\Mpdf([
    "mode" => "UTF-8",
    "format" => "A4",
]);

$cedula = $_SESSION['cedula'];
$empleado = $conn->query("SELECT * FROM empleados AS e, cargo_empleados AS c, horario_empleado AS h, cargo_horario AS ch, area_empleados AS a, ciudades AS ci WHERE (e.id_cargo_horario_emp = ch.id_cargo_horario 
AND ch.id_horario_ch = h.id_horario_empleado AND ch.id_cargo_ch = c.id_cargo AND c.id_area_cargo = a.id_area AND ci.idciudades = e.id_ciudad_emp) AND id_empleados = $cedula")->fetchAll(PDO::FETCH_OBJ);
$mpdf->SetFooter('{PAGENO}');

$empleado[0]->nombres = utf8_decode($empleado[0]->nombres);
$empleado[0]->apellidos = utf8_decode($empleado[0]->apellidos);
$empleado[0]->nombre_cargo = utf8_decode($empleado[0]->nombre_cargo);
$empleado[0]->nombre_area = utf8_decode($empleado[0]->nombre_area);
$empleado[0]->jornada = utf8_decode($empleado[0]->jornada);

if($_GET['type'] == 1 ){
    $plantilla = contrato($empleado,"CONTRATO DE TRABAJO INDEFINIDO",false,$_GET['desde'],$_GET['hasta']);
}

if($_GET['type'] == 2 ){
    $plantilla = contrato($empleado,"CONTRATO DE TRABAJO INDEFINIDO BONIFICADO",false,$_GET['desde'],$_GET['hasta']);
}

if($_GET['type'] == 3 ){
    $plantilla = contrato($empleado,"CONTRATO DE TRABAJO INDEFINIDO",true,$_GET['desde'],$_GET['hasta']);
}

if($_GET['type'] == 4 ){
    $plantilla = contrato($empleado,"CONTRATO DE TRABAJO TEMPORAL",false,$_GET['desde'],$_GET['hasta']);
}

if($_GET['type'] == 5 ){
    $plantilla = contrato($empleado,"CONTRATO DE TRABAJO TEMPORAL",true,$_GET['desde'],$_GET['hasta']);
}

if($_GET['type'] == 6 ){
    $plantilla = contrato($empleado,utf8_decode("CONTRATO DE TRABAJO EN PRÁCTICAS"),true,$_GET['desde'],$_GET['hasta']);
}


$mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($plantilla, \Mpdf\HTMLParserMode::HTML_BODY);

//contratoCIempleado
$mpdf->Output($empleado[0]->id_empleados."_".$empleado[0]->nombres.".pdf", "I");



