<?php
require '../../../../database.php';
date_default_timezone_set('America/Guayaquil');


$created = date("Y-m-d H:i:s");
  
var_dump($_POST);
die;
$sql = "UPDATE pacientes SET ocupacion_paciente=:ocupacion_paciente,ciudad=:ciudad,zona=:zona,afiliacion_publica=:afiliacion_publica,afiliacion_privada=:afiliacion_privada,updated_at=:updated_at WHERE idpacientes=:idpacientes";
 $stmt = $conn->prepare($sql);
 $stmt->bindParam(':idpacientes', $_POST['id']);
 $stmt->bindParam(':ocupacion_paciente', $_POST['ocupacion']);
 $stmt->bindParam(':ciudad', $_POST['ciudad']);
 $stmt->bindParam(':zona', $_POST['zona']);  
 $stmt->bindParam(':afiliacion_publica', $afiliacionPublica);
 $stmt->bindParam(':afiliacion_privada', $afiliacionPrivada);
 $stmt->bindParam(':updated_at', $created);
 $stmt->execute();
$stmt=null;
$conn=null;

header('Location: ../routes/perfil.php');