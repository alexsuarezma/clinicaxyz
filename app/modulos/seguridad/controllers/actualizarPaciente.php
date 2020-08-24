<?php
require '../../../../database.php';
date_default_timezone_set('America/Guayaquil');


$created = date("Y-m-d H:i:s");
  
var_dump($_POST);

$sql = "UPDATE pacientes SET ape_paterno=:ape_paterno,ape_mat=:ape_mat,
nombres=:nombres,ocupacion=:ocupacion,sexo=:sexo,f_nacimiento=:f_nacimiento,provincia=:provincia,ciudad=:ciudad,zona=:zona,direccion=:direccion,tlno_particular=:tlno_particular,tlno_personal=:tlno_personal,correo=:correo,afiliado=:afiliado,id_usuario_pac=:id_usuario_pac,updated_at=:updated_at WHERE idpacientes=:idpacientes";
 $stmt = $conn->prepare($sql);
 $stmt->bindParam(':idpacientes', $_POST['id']);
 $stmt->bindParam(':ape_paterno', $_POST['apellidoPaterno']);
 $stmt->bindParam(':ape_mat', $_POST['apellidoMaterno']);
 $stmt->bindParam(':nombres', $_POST['name']);
 $stmt->bindParam(':ocupacion', $_POST['ocupacion']);
 $stmt->bindParam(':sexo', $_POST['sexo']);
 $stmt->bindParam(':f_nacimiento', $_POST['fechaNacimiento']);
 $stmt->bindParam(':provincia', $_POST['provincia']);
 $stmt->bindParam(':ciudad', $_POST['ciudad']);
 $stmt->bindParam(':zona', $_POST['zona']);
 $stmt->bindParam(':direccion', $_POST['direccion']);
 $stmt->bindParam(':tlno_particular', $_POST['telefono']);
 $stmt->bindParam(':tlno_personal', $_POST['celular']);
 $stmt->bindParam(':correo', $_POST['email']);                  
 $stmt->bindParam(':afiliado', $_POST['afiliado']);
 $stmt->bindParam(':updated_at', $created);
 $stmt->execute();
$stmt=null;
$conn=null;

header('Location: ../routes/perfil.php');