<?php
require_once('../../../../database.php');

session_start();
date_default_timezone_set('America/Guayaquil');

$created = date("Y-m-d H:i:s");

try {
    
    $sql = "UPDATE pacientes SET deleted=:deleted,updated_at=:updated_at WHERE idpacientes=:idpacientes";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':deleted', 1, PDO::PARAM_INT);
    $stmt->bindParam(':updated_at', $created);
    $stmt->bindParam(':idpacientes', $_SESSION['cedula']);
    $stmt->execute();
} catch (\Throwable $th) {
    //throw $th;
}


header('Location: ../routes/visualizarPaciente.php');
session_destroy($_SESSION['cedula']);
