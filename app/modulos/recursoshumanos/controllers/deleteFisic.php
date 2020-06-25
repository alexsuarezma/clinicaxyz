<?php
  require '../../../../database.php';
    $id=$_GET["id"];
    $aspirante=$_GET["aspirante"];
       if($aspirante==""){
      
        $sql = "DELETE FROM estudios_empleados WHERE id_empleados_est = :cedula";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cedula', $id);
        $stmt->execute();

        $sql = "DELETE FROM expe_laboral_emp WHERE id_empleados_expe =:cedula";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cedula', $id);
        $stmt->execute();

        $sql = "DELETE FROM referencias_empleado WHERE id_empleados_refe =:cedula";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cedula', $id);
        $stmt->execute();

        $sql = "DELETE FROM contacto_emergencia WHERE id_empleados_contac =:cedula";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cedula', $id);
        $stmt->execute();

        $sql = "DELETE FROM hijos_empleados WHERE id_empleados_hijos =:cedula";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cedula', $id);
        $stmt->execute();

        $sql = "DELETE FROM empleados WHERE id_empleados =:cedula";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cedula', $id);
        $stmt->execute();
      
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
