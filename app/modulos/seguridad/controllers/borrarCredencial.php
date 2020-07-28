<?php
require '../../../../database.php';
$idCredencial=$_POST['idCredencial'];

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
    
    header("Location:../routes/credencial.php");
