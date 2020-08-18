<?php
  session_start();
  require '../../../../database.php';
  require '../../seguridad/controllers/functions/Auditoria.php';
       $sql = "UPDATE empleados SET deleted=1 WHERE id_empleados=:cedula";
       $stmt = $conn->prepare($sql);
       $stmt->bindParam(':cedula', $_SESSION['cedula']);
       $stmt->execute();
       $auditoria = new Auditoria(utf8_decode('Borrado'), 'rrhh',utf8_decode("Se elimino al empleado con cedula: ".$_SESSION['cedula']),$_SESSION['user_id'],null);
       $auditoria->Registro($conn);  
       header("Location:../routes/personal.php");
