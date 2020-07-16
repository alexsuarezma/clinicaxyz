<?php
    require '../../../../database.php';

    $sql = "UPDATE scope SET descripcion_rol=:descripcion_rol,nivel_scope=:nivel_scope,lectura=:lectura,insertar=:insertar,actualizar=:actualizar,actualizar_informacion=:actualizar_informacion,borrado_logico=:borrado_logico,borrado_fisico=:borrado_fisico,crear_usuarios=:crear_usuarios WHERE id_scope = :id_scope";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_scope', $_POST['idScope']);
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
           header("Location: ../routes/scopes.php");
      } 