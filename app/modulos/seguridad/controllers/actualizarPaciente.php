<?php
require '../../../../database.php';
date_default_timezone_set('America/Guayaquil');

$created = date("Y-m-d H:i:s");
  

$sql = "UPDATE pacientes SET ocupacion_paciente=:ocupacion_paciente,ciudad=:ciudad,zona=:zona,afiliacion_publica=:afiliacion_publica,afiliacion_privada=:afiliacion_privada,updated_at=:updated_at WHERE idpacientes=:idpacientes";
 $stmt = $conn->prepare($sql);
 $stmt->bindParam(':ocupacion_paciente', $_POST['ocupacion']);
 $stmt->bindParam(':ciudad', $_POST['ciudad']);
 $stmt->bindParam(':zona', $_POST['zona']);  
 $stmt->bindParam(':afiliacion_publica', $_POST['afiliacionPublica']);
 $stmt->bindParam(':afiliacion_privada', $_POST['afiliacionPrivada']);
 $stmt->bindParam(':updated_at', $created);
 $stmt->bindParam(':idpacientes', $_POST['cedula']);
 $stmt->execute();

 if($_POST['ingreso'] == "si" && $_POST['type'] == 2){

  $sql = "UPDATE pacientes SET updated_at=:updated_at,created_at=:created_at WHERE idpacientes=:idpacientes";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':updated_at', $created);

  $created = date("H:i:s");
  $fingreso = $_POST['fechaIngreso']." ".$created;
  $stmt->bindParam(':created_at', $fingreso);
  $stmt->bindParam(':idpacientes', $_POST['cedula']);
  $stmt->execute();
 }

 
 $sql = "UPDATE direccion_paciente SET direccion=:direccion,tlno_particular=:tlno_particular,tlno_personal=:tlno_personal,created_at=:created_at WHERE id_pacientes_de=:id_pacientes_de AND tipo=:tipo";
 $stmt = $conn->prepare($sql);
 $stmt->bindParam(':direccion', $_POST['direccionDomicilio']);
 $stmt->bindParam(':tlno_particular', $_POST['telefonoDomicilio']);
 $stmt->bindParam(':tlno_personal', $_POST['celularDomicilio']);
 $stmt->bindParam(':created_at', $created);
 $stmt->bindParam(':id_pacientes_de', $_POST['cedula']);
 $stmt->bindValue(':tipo', 'Domicilio', PDO::PARAM_STR);
 $stmt->execute();


 $sql = "UPDATE direccion_paciente SET direccion=:direccion,tlno_particular=:tlno_particular,tlno_personal=:tlno_personal,created_at=:created_at WHERE id_pacientes_de=:id_pacientes_de AND tipo=:tipo";
 $stmt = $conn->prepare($sql);
 $stmt->bindParam(':direccion', $_POST['direccionTrabajo']);
 $stmt->bindParam(':tlno_particular', $_POST['telefonoTrabajo']);
 $stmt->bindValue(':tlno_personal', null, PDO::PARAM_INT);
 $stmt->bindParam(':created_at', $created);
 $stmt->bindParam(':id_pacientes_de', $_POST['cedula']);
 $stmt->bindValue(':tipo', 'Trabajo', PDO::PARAM_STR);
 $stmt->execute();


 $sql = "UPDATE direccion_paciente SET direccion=:direccion,tlno_particular=:tlno_particular,tlno_personal=:tlno_personal,created_at=:created_at WHERE id_pacientes_de=:id_pacientes_de AND tipo=:tipo";
 $stmt = $conn->prepare($sql);
 $stmt->bindParam(':direccion', $_POST['direccionAtencion']);
 $stmt->bindParam(':tlno_particular', $_POST['telefonoAtencion']);
 $stmt->bindValue(':tlno_personal', null, PDO::PARAM_INT);
 $stmt->bindParam(':created_at', $created);
 $stmt->bindParam(':id_pacientes_de', $_POST['cedula']);
 $stmt->bindValue(':tipo', 'Atención', PDO::PARAM_STR);
 $stmt->execute();

 if($_POST['poseeDiscapacidad'] == 'si'){
    $sql = "INSERT INTO conadis (paciente,carnet,discapacidad,grado) VALUES 
    (:paciente,:carnet,:discapacidad,:grado)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':paciente', $_POST['cedula']);
    $stmt->bindParam(':carnet', $_POST['carnetConadis']);
    $stmt->bindParam(':discapacidad', $_POST['discapacidad']);
    $stmt->bindParam(':grado', $_POST['grado']);
    $stmt->execute();
  }

$stmt=null;
$conn=null;

if($_POST['type'] == 1){
  header('Location: ../routes/perfil.php');
}elseif($_POST['type'] == 2){
  header('Location: ../../pacientes/routes/informacion.php?cedula='.$_POST['cedula']);
}