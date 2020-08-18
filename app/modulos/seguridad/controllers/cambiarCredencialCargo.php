<?php
require '../../../../database.php';
require 'functions/Auditoria.php';
session_start();

$credencial = $conn->query("SELECT * FROM credencial_base WHERE id_credencial=".$_POST['credencial'])->fetchAll(PDO::FETCH_OBJ);
$cargo = $conn->query("SELECT * FROM cargo_empleados WHERE id_cargo=".$_POST['idCargoAsociado'])->fetchAll(PDO::FETCH_OBJ);

    $sql = "UPDATE cargo_empleados SET id_credencialbase_cargo=:id_credencialbase_cargo WHERE id_cargo=:id_cargo";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_cargo', $_POST['idCargoAsociado']);
    $stmt->bindParam(':id_credencialbase_cargo', $_POST['credencial']);
    $stmt->execute();
  
//QUE LOS CAMBIOS SE REFLEJEN EN TODOS LOS EMPLEADOS ANTERIORES O SOLO A LOS QUE RECIEN SE REGISTRARAN
    if($_POST['cambioGlobal']=='si'){
        $sql = "UPDATE empleados AS e, cargo_empleados AS ca, cargo_horario AS ch, usuario AS u, usuario_credencial AS uc SET id_credencialbase_uc=:id_credencialbase_uc WHERE (e.id_usuario_emp = u.id_usuario AND e.id_cargo_horario_emp = ch.id_cargo_horario AND ch.id_cargo_ch = ca.id_cargo AND u.id_usuario = uc.id_usuario_uc) AND id_cargo_ch=:id_cargo_ch";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_cargo_ch', $_POST['idCargoAsociado']);
        $stmt->bindParam(':id_credencialbase_uc', $_POST['credencial']);
        $stmt->execute();
    }
$auditoria = new Auditoria(utf8_decode('Actualización'), 'Seguridad',utf8_decode("Se actualizo una credencial".$credencial[0]->nombre_credencial.", al cargo: ".$cargo[0]->nombre_cargo),$_SESSION['user_id'],null);
$auditoria->Registro($conn);
header("Location:../routes/cargos.php");