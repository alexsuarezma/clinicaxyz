<?php
  require '../../../../database.php';
    $id=$_GET["id"];
    $aspirante=$_GET["aspirante"];
       if($aspirante==""){
        $sql = "DELETE FROM empleados WHERE cedula=:cedula";
       }else{
        $sql = "DELETE FROM aspirante WHERE cedula=:cedula";
       }
       
       $stmt = $conn->prepare($sql);
       $stmt->bindParam(':cedula', $id);
       $stmt->execute();
       header("Location:../routes/historialPersonal.php");
