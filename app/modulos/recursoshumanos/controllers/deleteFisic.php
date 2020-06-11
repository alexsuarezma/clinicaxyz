<?php
  require '../../../../database.php';
    $id=$_GET["id"];
       
      //  $sql = "DELETE FROM empleados WHERE cedula=:cedula";
      //  $stmt = $conn->prepare($sql);
      //  $stmt->bindParam(':cedula', $id);
      //  $stmt->execute();
       header("Location:../components/success.html");
