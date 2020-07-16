<?php
require '../../../../database.php';
    $sql = "UPDATE cargo_empleados SET id_credencialbase_cargo=:id_credencialbase_cargo WHERE id_cargo=:id_cargo";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_cargo', $_POST['idCargoAsociado']);
    $stmt->bindParam(':id_credencialbase_cargo', $_POST['credencial']);
    $stmt->execute();
  
//QUE LOS CAMBIOS SE REFLEJEN EN TODOS LOS EMPLEADOS ANTERIORES O SOLO A LOS QUE RECIEN SE REGISTRARAN
    if($_POST['cambioGlobal']=='si'){
        $sql = "UPDATE empleados AS e, usuario AS u, usuario_credencial AS uc SET id_credencialbase_uc=:id_credencialbase_uc WHERE (e.id_usuario_emp = u.id_usuario AND u.id_usuario = uc.id_usuario_uc) AND id_cargo_emp=:id_cargo_emp";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_cargo_emp', $_POST['idCargoAsociado']);
        $stmt->bindParam(':id_credencialbase_uc', $_POST['credencial']);
        $stmt->execute();
    }
        
header("Location:../routes/cargos.php");