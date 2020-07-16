<?php
require '../../../../database.php';
//con un foreach realizar el UPDATE para que afecte a las filas necesarias  

    $sql = "UPDATE usuario_credencial SET id_credencialbase_uc=:id_credencialbase_uc WHERE id_credencialbase_uc=:idCredencial";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':idCredencial', $_POST['idCredencial']);
    $stmt->bindParam(':id_credencialbase_uc', $_POST['credencial']);
    $stmt->execute();

    $sql = "UPDATE cargo_emplepados SET id_credencialbase_cargo=:id_credencialbase_cargo WHERE id_credencialbase_cargo=:idCredencial";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':idCredencial', $_POST['idCredencial']);
    $stmt->bindParam(':id_credencialbase_cargo', $_POST['credencial']);
    $stmt->execute();

    $sql = "DELETE FROM credencial_base WHERE id_credencial=:idCredencial";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':idCredencial', $_POST['idCredencial']);
    $stmt->execute();
    
    header("Location:../routes/credencial.php");
