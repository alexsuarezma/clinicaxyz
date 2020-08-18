<?php
    require '../../../../database.php';
    require 'functions/Auditoria.php';
    session_start();

        $sql = "INSERT INTO credencial_base (nombre_credencial,modulo_rrhh,modulo_contabilidad,modulo_suministros,modulo_ctas_medicas,modulo_pacientes,modulo_seguridad,paciente,id_scope_credencial) 
       VALUES (:nombre_credencial,:modulo_rrhh,:modulo_contabilidad,:modulo_suministros,:modulo_ctas_medicas,:modulo_pacientes,:modulo_seguridad,:paciente,:id_scope_credencial)";
       $stmt = $conn->prepare($sql);
       $stmt->bindParam(':nombre_credencial', $_POST['nombreCredencial']);
       if($_POST['accessoModulo']=='Humanos'){
         $stmt->bindValue(':modulo_rrhh', 1, PDO::PARAM_INT);
       }else{
         $stmt->bindValue(':modulo_rrhh', 0, PDO::PARAM_INT);
       }

       if($_POST['accessoModulo']=='Contabilidad'){
         $stmt->bindValue(':modulo_contabilidad', 1, PDO::PARAM_INT);
       }else{
         $stmt->bindValue(':modulo_contabilidad', 0, PDO::PARAM_INT);
       }

       if($_POST['accessoModulo']=='Suministros'){
         $stmt->bindValue(':modulo_suministros', 1, PDO::PARAM_INT);
       }else{
         $stmt->bindValue(':modulo_suministros', 0, PDO::PARAM_INT);
       }

       if($_POST['accessoModulo']=='Citas'){
         $stmt->bindValue(':modulo_ctas_medicas', 1, PDO::PARAM_INT);
       }else{
         $stmt->bindValue(':modulo_ctas_medicas', 0, PDO::PARAM_INT);
       }

       if($_POST['accessoModulo']=='ModuloPacientes'){
         $stmt->bindValue(':modulo_pacientes', 1, PDO::PARAM_INT);
       }else{
         $stmt->bindValue(':modulo_pacientes', 0, PDO::PARAM_INT);
       }

       if($_POST['accessoModulo']=='Seguridad'){
         $stmt->bindValue(':modulo_seguridad', 1, PDO::PARAM_INT);
       }else{
         $stmt->bindValue(':modulo_seguridad', 0, PDO::PARAM_INT);
       }

       if($_POST['accessoModulo']=='Paciente'){
         $stmt->bindValue(':paciente', 1, PDO::PARAM_INT);
       }else{
         $stmt->bindValue(':paciente', 0, PDO::PARAM_INT);
       }
       
       $stmt->bindParam(':id_scope_credencial', $_POST['scope']);

       if($stmt->execute()){
         echo "<script language='javascript'>alert('Credencial Registrada');</script>";
         $auditoria = new Auditoria(utf8_decode('Registro'), 'Seguridad',utf8_decode("Se registro una nueva credencial base".$_POST['nombreCredencial']),$_SESSION['user_id'],null);
         $auditoria->Registro($conn);
         header("Location: ../routes/credencial.php");
       }

       