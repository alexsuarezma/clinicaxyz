<?php
  session_start();
  require '../../../../database.php';

       $sql = "UPDATE empleados SET deleted=1 WHERE id_empleados=:cedula";
       $stmt = $conn->prepare($sql);
       $stmt->bindParam(':cedula', $_SESSION['cedula']);
       $stmt->execute();
       header("Location:../routes/personal.php");
