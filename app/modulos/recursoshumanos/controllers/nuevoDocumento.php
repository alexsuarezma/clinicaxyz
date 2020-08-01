<?php
require '../../../../database.php';
session_start();
date_default_timezone_set('America/Guayaquil');
$created = date("Y-m-d H:i:s");


$sql = "UPDATE empleados AS e, documento_empleado AS d SET activo=:activo, load_documento=:load_documento, updated_at=:updated_at WHERE (e.id_empleados=d.id_empleados_doc) AND id_empleados_doc=:id_empleados_doc";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':activo', 0, PDO::PARAM_INT);
$stmt->bindValue(':load_documento', 0, PDO::PARAM_INT);
$stmt->bindParam(':id_empleados_doc', $_SESSION['cedula']);
$stmt->bindParam(':updated_at', $created);

if($stmt->execute()){
    $sql = "INSERT INTO documento_empleado (descripcion,file_document,activo,id_empleados_doc,created_at,updated_at) VALUES (:descripcion,:file_document,:activo,:id_empleados_doc,:created_at,:updated_at)";                    
    $stmt = $conn->prepare($sql);                              
    $stmt->bindValue(':descripcion', null, PDO::PARAM_INT);
    $stmt->bindValue(':file_document', null, PDO::PARAM_INT);
    $stmt->bindValue(':activo', 1, PDO::PARAM_INT);
    $stmt->bindValue(':updated_at', null, PDO::PARAM_INT);
    $stmt->bindParam(':created_at', $created);
    $stmt->bindParam(':id_empleados_doc', $_SESSION['cedula']);
    $stmt->execute();

    header("Location:../routes/profile.php?id=".$_SESSION['cedula']);
}
