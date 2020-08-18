<?php
require '../../../../database.php';
require 'functions/Auditoria.php';
session_start();

   $sql = "INSERT INTO scope (descripcion_rol,nivel_scope,lectura,insertar,actualizar,actualizar_informacion,borrado_logico,borrado_fisico,crear_usuarios) 
   VALUES (:descripcion_rol,:nivel_scope,:lectura,:insertar,:actualizar,:actualizar_informacion,:borrado_logico,:borrado_fisico,:crear_usuarios)";
   $stmt = $conn->prepare($sql);
   $stmt->bindParam(':descripcion_rol', $_POST['descripcionRol']);
   $stmt->bindParam(':nivel_scope', $_POST['nivelScope']);
   $stmt->bindValue(':lectura', 0, PDO::PARAM_INT);
   $stmt->bindValue(':insertar', 0, PDO::PARAM_INT);
   $stmt->bindValue(':actualizar', 0, PDO::PARAM_INT);
   $stmt->bindValue(':actualizar_informacion', 0, PDO::PARAM_INT);
   $stmt->bindValue(':borrado_logico', 0, PDO::PARAM_INT);
   $stmt->bindValue(':borrado_fisico', 0, PDO::PARAM_INT);
   $stmt->bindValue(':crear_usuarios', 0, PDO::PARAM_INT);

     foreach ($_POST['accion'] as $Acciones) {
          if($Acciones == "lectura"){$stmt->bindValue(':lectura', 1, PDO::PARAM_INT);}
          if($Acciones == "escritura"){$stmt->bindValue(':insertar', 1, PDO::PARAM_INT);}
          if($Acciones == "actualizar"){$stmt->bindValue(':actualizar', 1, PDO::PARAM_INT);}
          if($Acciones == "actSensible"){$stmt->bindValue(':actualizar_informacion', 1, PDO::PARAM_INT);}
          if($Acciones == "borradoLogico"){$stmt->bindValue(':borrado_logico', 1, PDO::PARAM_INT);}
          if($Acciones == "borradoFisico"){$stmt->bindValue(':borrado_fisico', 1, PDO::PARAM_INT);}
          if($Acciones == "crearUsuario"){$stmt->bindValue(':crear_usuarios', 1, PDO::PARAM_INT);}
     }
     
     if($stmt->execute()){

          $auditoria = new Auditoria(utf8_decode('Registro'), 'Seguridad',utf8_decode("Se registro un nuevo scope base".$_POST['descripcionRol']),$_SESSION['user_id'],null);
          $auditoria->Registro($conn);
          header("Location: ../routes/scopes.php");
     } 