<?php
  require '../../../../database.php';
    $id=$_GET["id"];
       
       $sql = "UPDATE empleados SET deleted=1 WHERE id_empleados=:cedula";
       $stmt = $conn->prepare($sql);
       $stmt->bindParam(':cedula', $id);
       $stmt->execute();
       header("Location:../routes/personal.php");
