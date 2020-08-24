<?php
require '../../../../database.php';
date_default_timezone_set('America/Guayaquil');
extract($_REQUEST);

$created = date("Y-m-d H:i:s");

//BUSCAR PRIMERO SI LA CEDULA YA ESTA REGISTRADA!!!!! Y LUEGO REGISTRAR AL USUARIO
$paciente = $conn->query("SELECT * FROM pacientes WHERE idpacientes = ".$cedula)->rowCount();
    
if($paciente>0){
  echo false;
}else{

    $sql = "INSERT INTO usuario (username, password) VALUES (:username,:password)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $passwordBcrypt = password_hash($password, PASSWORD_BCRYPT);
    $stmt->bindParam(':password', $passwordBcrypt);
    $stmt->execute();
        //recupera el id insertado generado*
        $id = $conn->lastInsertId();
        //INSERTAR USUARIO_CREDENCIAL
        $sql = "INSERT INTO usuario_credencial (id_usuario_uc,id_credencialbase_uc) VALUES 
        (:id_usuario_uc,:id_credencialbase_uc)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_usuario_uc', $id);
        $stmt->bindValue(':id_credencialbase_uc', 18, PDO::PARAM_INT);
        $stmt->execute();
        
           //REGISTRAR PACIENTE
           $sql = "INSERT INTO pacientes (idpacientes,ape_paterno,ape_mat,nombres,ocupacion_paciente,sexo,f_nacimiento,zona,correo,ciudad,afiliacion_publica,afiliacion_privada,id_usuario_pac,created_at,updated_at) VALUES (:idpacientes,:ape_paterno,:ape_mat,:nombres,:ocupacion_paciente,:sexo,:f_nacimiento,:zona,:correo,:ciudad,:afiliacion_publica,:afiliacion_privada,:id_usuario_pac,:created_at,:updated_at)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':idpacientes', $cedula);
            $stmt->bindParam(':ape_paterno', $apellidoPaterno);
            $stmt->bindParam(':ape_mat', $apellidoMaterno);
            $stmt->bindParam(':nombres', $name);
            $stmt->bindParam(':ocupacion_paciente', $ocupacion);
            $stmt->bindParam(':sexo', $sexo);
            $stmt->bindParam(':f_nacimiento', $fechaNacimiento);
            $stmt->bindParam(':zona', $zona);
            $stmt->bindParam(':correo', $email);                  
            $stmt->bindParam(':ciudad', $ciudad);
            $stmt->bindParam(':id_usuario_pac', $id);
            $stmt->bindParam(':afiliacion_publica', $afiliacionPublica);
            $stmt->bindParam(':afiliacion_privada', $afiliacionPrivada);
            $stmt->bindParam(':created_at', $created);
            $stmt->bindValue(':updated_at', null, PDO::PARAM_INT);
            $stmt->execute();
    
            $sql = "INSERT INTO direccion_paciente (direccion,tlno_particular,tlno_personal,created_at,id_pacientes_de,tipo) VALUES 
            (:direccion,:tlno_particular,:tlno_personal,:created_at,:id_pacientes_de,:tipo)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_pacientes_de', $cedula);
            $stmt->bindValue(':tipo', 'Domicilio', PDO::PARAM_STR);
            $stmt->bindParam(':direccion', $direccionDomicilio);
            $stmt->bindParam(':tlno_particular', $telefonoDomicilio);
            $stmt->bindParam(':tlno_personal', $celularDomicilio);
            $stmt->bindParam(':created_at', $created);
            $stmt->execute();

            $sql = "INSERT INTO direccion_paciente (direccion,tlno_particular,tlno_personal,created_at,id_pacientes_de,tipo) VALUES 
            (:direccion,:tlno_particular,:tlno_personal,:created_at,:id_pacientes_de,:tipo)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_pacientes_de', $cedula);
            $stmt->bindValue(':tipo', 'Trabajo', PDO::PARAM_STR);
            $stmt->bindParam(':direccion', $direccionTrabajo);
            $stmt->bindParam(':tlno_particular', $telefonoTrabajo);
            $stmt->bindValue(':tlno_personal', null, PDO::PARAM_INT);
            $stmt->bindParam(':created_at', $created);
            $stmt->execute();

            $sql = "INSERT INTO direccion_paciente (direccion,tlno_particular,tlno_personal,created_at,id_pacientes_de,tipo) VALUES 
            (:direccion,:tlno_particular,:tlno_personal,:created_at,:id_pacientes_de,:tipo)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_pacientes_de', $cedula);
            $stmt->bindValue(':tipo', 'Atención', PDO::PARAM_STR);
            $stmt->bindParam(':direccion', $direccionAtencion);
            $stmt->bindParam(':tlno_particular', $telefonoAtencion);
            $stmt->bindValue(':tlno_personal', null, PDO::PARAM_INT);
            $stmt->bindParam(':created_at', $created);
            $stmt->execute();
    
            if($poseeDiscapacidad == 'si'){
              $sql = "INSERT INTO conadis (paciente,carnet,discapacidad,grado) VALUES 
              (:paciente,:carnet,:discapacidad,:grado)";
              $stmt = $conn->prepare($sql);
              $stmt->bindParam(':paciente', $cedula);
              $stmt->bindParam(':carnet', $carnetConadis);
              $stmt->bindParam(':discapacidad', $discapacidad);
              $stmt->bindParam(':grado', $grado);
              $stmt->execute();
            }
  $stmt=null;
  $conn=null;
  echo true;
}
