<?php
require '../../../../database.php';
date_default_timezone_set('America/Guayaquil');

$created = date("Y-m-d H:i:s");


if($_GET['type']=='publico'){
    $sql = "UPDATE pacientes SET afiliacion_publica=:afiliacion_publica,updated_at=:updated_at WHERE idpacientes=:idpacientes";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':afiliacion_publica', null, PDO::PARAM_INT);
    $stmt->bindParam(':updated_at', $created);
    $stmt->bindParam(':idpacientes', $_GET['cedula']);
    $stmt->execute();
}else{
    $sql = "UPDATE pacientes SET afiliacion_privada=:afiliacion_privada,updated_at=:updated_at WHERE idpacientes=:idpacientes";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':afiliacion_privada', null, PDO::PARAM_INT);
    $stmt->bindParam(':updated_at', $created);
    $stmt->bindParam(':idpacientes', $_GET['cedula']);
    $stmt->execute();
}


if($_GET['tipo'] == 1){
    header('Location: ../routes/perfil.php');
  }elseif($_GET['tipo'] == 2){
    header('Location: ../../pacientes/routes/informacion.php?cedula='.$_GET['cedula']);
  }
