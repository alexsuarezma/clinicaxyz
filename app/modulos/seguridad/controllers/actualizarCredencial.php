<?php
require '../../../../database.php';
require 'functions/Auditoria.php';
session_start();
$credencial = $conn->query("SELECT * FROM credencial_base WHERE id_credencial=".$_POST['idCredencial'])->fetchAll(PDO::FETCH_OBJ);

$sql = "UPDATE credencial_base SET nombre_credencial=:nombre_credencial, modulo_rrhh=:modulo_rrhh,modulo_contabilidad=:modulo_contabilidad,modulo_suministros=:modulo_suministros,modulo_ctas_medicas=:modulo_ctas_medicas,modulo_pacientes=:modulo_pacientes,modulo_seguridad=:modulo_seguridad,paciente=:paciente,id_scope_credencial=:id_scope_credencial WHERE id_credencial = :id_credencial";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id_credencial', $_POST['idCredencial']);
$stmt->bindParam(':nombre_credencial', $_POST['nombreCredencial']);
if($_POST['accessoModulo']=='Humanos'){
    $stmt->bindValue(':modulo_rrhh', 1, PDO::PARAM_INT);
  }else{
    $stmt->bindValue(':modulo_rrhh', 0, PDO::PARAM_INT);
  }

  if($_POST['accessoModulo']=='Contabilidad'){
    $stmt->bindValue(':modulo_contabilidad', 1, PDO::PARAM_INT);
  }else{
    $stmt->bindValue(':modulo_contabilidad', 0, PDO::PARAM_INT);
  }

  if($_POST['accessoModulo']=='Suministros'){
    $stmt->bindValue(':modulo_suministros', 1, PDO::PARAM_INT);
  }else{
    $stmt->bindValue(':modulo_suministros', 0, PDO::PARAM_INT);
  }

  if($_POST['accessoModulo']=='Citas'){
    $stmt->bindValue(':modulo_ctas_medicas', 1, PDO::PARAM_INT);
  }else{
    $stmt->bindValue(':modulo_ctas_medicas', 0, PDO::PARAM_INT);
  }

  if($_POST['accessoModulo']=='ModuloPacientes'){
    $stmt->bindValue(':modulo_pacientes', 1, PDO::PARAM_INT);
  }else{
    $stmt->bindValue(':modulo_pacientes', 0, PDO::PARAM_INT);
  }

  if($_POST['accessoModulo']=='Seguridad'){
    $stmt->bindValue(':modulo_seguridad', 1, PDO::PARAM_INT);
  }else{
    $stmt->bindValue(':modulo_seguridad', 0, PDO::PARAM_INT);
  }

  if($_POST['accessoModulo']=='Paciente'){
    $stmt->bindValue(':paciente', 1, PDO::PARAM_INT);
  }else{
    $stmt->bindValue(':paciente', 0, PDO::PARAM_INT);
  }

  $stmt->bindParam(':id_scope_credencial', $_POST['scope']);

if($stmt->execute()){
    $auditoria = new Auditoria(utf8_decode('Actualización'), 'Seguridad',utf8_decode("Se actualizo la credencial base ".$credencial[0]->id_credencial."-".$credencial[0]->nombre_credencial),$_SESSION['user_id'],null);
    $auditoria->Registro($conn);
    header("Location: ../routes/credencial.php");
}