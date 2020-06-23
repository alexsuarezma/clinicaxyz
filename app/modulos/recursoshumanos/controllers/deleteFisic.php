<?php
  require '../../../../database.php';
    $id=$_GET["id"];
    $aspirante=$_GET["aspirante"];
       if($aspirante==""){
        $sql = "DELETE FROM empleados WHERE cedula=:cedula";
       }else{
        $sql = "DELETE FROM estudios_aspirantes WHERE id_aspirante_est=:cedula";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cedula', $id);
        $stmt->execute();

        $sql = "DELETE FROM expe_laboral WHERE id_aspirante_expe=:cedula";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cedula', $id);
        $stmt->execute();

        $sql = "DELETE FROM referencias WHERE id_aspirante_refe=:cedula";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cedula', $id);
        $stmt->execute();

        $sql = "DELETE FROM aspirantes WHERE id_aspirante=:cedula";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cedula', $id);
        $stmt->execute();
       }
       
       header("Location:../routes/historialPersonal.php");
