<?php
// var_dump($_POST);
require_once('../../../../database.php');
date_default_timezone_set('America/Guayaquil');
extract($_REQUEST);

$created = date("Y-m-d H:i:s");
  
try {
    $sql = "INSERT INTO historial_importado (file_document,descripcion,tipo,created_at,id_pacientes_hi) VALUES (:file_document,:descripcion,:tipo,:created_at,:id_pacientes_hi)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':file_document', $archivo);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':created_at', $created);
    $stmt->bindParam(':id_pacientes_hi', $cedula);
    $stmt->execute();
    
} catch (\Throwable $th) {
    echo false;
}
echo true;

$stmt = null;
$conn = null;