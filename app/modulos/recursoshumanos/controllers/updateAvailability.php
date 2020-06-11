<?php
  require '../../../../database.php';
    $id=$_GET["id"];
    $proceso = $_GET["proceso"];     
    
     if($proceso){
        //drop logic
        $conn->query("UPDATE empleados SET deleted=1 WHERE cedula=$id");
        header("Location:../routes/profile.php");
      }else{
        //update availability
        $available = $_GET["available"];
        $conn->query("UPDATE empleados SET disponible=$available WHERE cedula=$id");
        header("Location:../routes/profile.php");
        // Ó
        //$records = $conn->prepare("UPDATE empleados SET disponible=$available WHERE cedula=:cedula");
        //$records->bindParam(':cedula', $id);
        //$records->execute();
      }