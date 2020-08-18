<?php
require '../../../../database.php';
require 'functions/Auditoria.php';
$idCredencial=$_POST['idCredencial'];
session_start();
    $deleteAuditoria = $conn->query("SELECT * FROM credencial_base WHERE id_credencial=".$_POST['idCredencial'])->fetchAll(PDO::FETCH_OBJ);

    $credencialCargo = $conn->query("SELECT * FROM cargo_empleados WHERE id_credencialbase_cargo = $idCredencial")->rowCount();
    $credencialUC = $conn->query("SELECT * FROM usuario_credencial WHERE id_credencialbase_uc = $idCredencial")->rowCount();
    
    if($credencialCargo > 0){
        $sql = "UPDATE cargo_empleados SET id_credencialbase_cargo=:id_credencialbase_cargo WHERE id_credencialbase_cargo=:idCredencial";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idCredencial', $_POST['idCredencial']);
        $stmt->bindParam(':id_credencialbase_cargo', $_POST['credenciales']);
        $stmt->execute();
    }

    if($credencialUC > 0){
        $sql = "UPDATE usuario_credencial SET id_credencialbase_uc=:id_credencialbase_uc WHERE id_credencialbase_uc=:idCredencial";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idCredencial', $_POST['idCredencial']);
        $stmt->bindParam(':id_credencialbase_uc', $_POST['credenciales']);
        $stmt->execute();
    }

    $sql = "DELETE FROM credencial_base WHERE id_credencial=:idCredencial";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':idCredencial', $_POST['idCredencial']);
    $stmt->execute();
    $auditoria = new Auditoria(utf8_decode('Borrado'), 'Seguridad',utf8_decode("Se elimino una credencial base ".$deleteAuditoria[0]->nombre_credencial),$_SESSION['user_id'],null);
    $auditoria->Registro($conn);
    header("Location:../routes/credencial.php");
