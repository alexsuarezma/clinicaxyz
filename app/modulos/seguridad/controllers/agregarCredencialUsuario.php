<?php
require '../../../../database.php';

    $usuario = $conn->query("SELECT * FROM usuario_credencial WHERE id_usuario_uc = ".$_POST['idUserCredencialUsuario']." AND id_credencialbase_uc = 19")->rowCount();

    if($usuario > 0){
        //Update credencial sin acceso
        $sql = "UPDATE usuario_credencial SET id_credencialbase_uc=:id_credencialbase_uc WHERE id_usuario_uc=:id_usuario_uc";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_usuario_uc', $_POST['idUserCredencialUsuario']);
        $stmt->bindParam(':id_credencialbase_uc', $_POST['credencialUsuario']);
        if($stmt->execute()){
            header("Location: ../routes/usuarios.php");
        }
    }else{
        //CREAR CREDENCIAL
        $sql = "INSERT INTO usuario_credencial (id_usuario_uc,id_credencialbase_uc) 
        VALUES (:id_usuario_uc,:id_credencialbase_uc)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_usuario_uc', $_POST['idUserCredencialUsuario']);
        $stmt->bindParam(':id_credencialbase_uc', $_POST['credencialUsuario']);    
        if($stmt->execute()){
            header("Location: ../routes/usuarios.php");
        } 
    }
