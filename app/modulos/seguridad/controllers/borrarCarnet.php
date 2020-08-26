<?php
require '../../../../database.php';
var_dump($_POST);
$sql = "DELETE FROM conadis WHERE paciente=:paciente";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':paciente', $_GET['cedula']);
$stmt->execute();
    
$conn = null;
$stmt = null;


if($_GET['tipo'] == 1){
    header('Location: ../routes/perfil.php');
  }elseif($_GET['tipo'] == 2){
    header('Location: ../../pacientes/routes/informacion.php?cedula='.$_GET['cedula']);
  }
