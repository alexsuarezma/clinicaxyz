<?php
require '../../../../database.php';
session_start();
date_default_timezone_set('America/Guayaquil');
$created = date("Y-m-d H:i:s");


$sql = "UPDATE empleados AS e, contrato_empleado AS c SET activo=:activo, load_contrato=:load_contrato, updated_at=:updated_at WHERE (e.id_empleados=c.id_empleados_cont) AND id_empleados_cont=:id_empleados_cont";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':activo', 0, PDO::PARAM_INT);
$stmt->bindValue(':load_contrato', 0, PDO::PARAM_INT);
$stmt->bindParam(':id_empleados_cont', $_SESSION['cedula']);
$stmt->bindParam(':updated_at', $created);

if($stmt->execute()){
    $sql = "INSERT INTO contrato_empleado (tipo_contrato,file_contrato,activo,id_empleados_cont,created_at,updated_at) VALUES (:tipo_contrato,:file_contrato,:activo,:id_empleados_cont,:created_at,:updated_at)";                    
    $stmt = $conn->prepare($sql);                              
    $stmt->bindValue(':tipo_contrato', null, PDO::PARAM_INT);
    $stmt->bindValue(':file_contrato', null, PDO::PARAM_INT);
    $stmt->bindValue(':activo', 1, PDO::PARAM_INT);
    $stmt->bindValue(':updated_at', null, PDO::PARAM_INT);
    $stmt->bindParam(':created_at', $created);
    $stmt->bindParam(':id_empleados_cont', $_SESSION['cedula']);
    $stmt->execute();

    header("Location:../routes/profile.php?id=".$_SESSION['cedula']);
}
