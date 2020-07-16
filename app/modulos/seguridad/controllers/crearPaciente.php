<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Clinica Vitalia | Registro</title>
</head>
<body>
    <div class='modal fade' name='pacienteDuplicado' id='pacienteDuplicado' data-backdrop='static' data-keyboard='false' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabe' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header bg-danger text-white'>
                    <h5 class='modal-title' id='staticBackdropLabel'>Registro Fallido</h5>
                    </button>
                </div>
                <div class='modal-body'>
                        ¡Hey!. Ya te encuentras registrado en la plataforma, porfavor logeate.
                </div>
                <div class='modal-footer'>
                        <button id='continuar' name='confirmacion-update' type='submit' class='btn btn-light border border-danger text-danger font-weight-bold' style="width:200px;">OK</button>
                </div>
            </div>
    </div>
<script src="../components/scripts/jquery.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script>
    $('#continuar').click(function(){
        location.href=`../routes/login.php`;
    });  
</script>
</body>
</html>




<?php
require '../../../../database.php';

//BUSCAR PRIMERO SI LA CEDULA YA ESTA REGISTRADA!!!!! Y LUEGO REGISTRAR AL USUARIO
$paciente = $conn->query("SELECT * FROM pacientes WHERE idpacientes = ".$_POST['cedula'])->rowCount();
    
    if($paciente>0){
      echo "<script language='javascript'>$('#pacienteDuplicado').modal('show');</script>";
    }else{
          $sql = "INSERT INTO usuario (username, password) VALUES (:username,:password)";
          $stmt = $conn->prepare($sql);
          $stmt->bindParam(':username', $_POST['username']);
          $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
          $stmt->bindParam(':password', $password);
          
          if($stmt->execute()){
              //recupera el id insertado generado*
                $id = $conn->lastInsertId();
              //INSERTAR USUARIO_CREDENCIAL
              $sql = "INSERT INTO usuario_credencial (id_usuario_uc,id_credencialbase_uc) VALUES 
              (:id_usuario_uc,:id_credencialbase_uc)";
              $stmt = $conn->prepare($sql);
              $stmt->bindParam(':id_usuario_uc', $id);
              $stmt->bindValue(':id_credencialbase_uc', 18, PDO::PARAM_INT);
                if($stmt->execute()){
                      //REGISTRAR PACIENTE
                      $sql = "INSERT INTO pacientes (idpacientes,ape_paterno,ape_mat,
                  nombres,ocupacion,sexo,f_nacimiento,provincia,ciudad,zona,direccion,tlno_particular,tlno_personal,correo,afiliado,id_usuario_pac) VALUES 
                  (:idpacientes,:ape_paterno,:ape_mat,:nombres,:ocupacion,:sexo,:f_nacimiento,:provincia,:ciudad,:zona,:direccion,:tlno_particular,:tlno_personal,:correo,:afiliado,:id_usuario_pac)";
                      $stmt = $conn->prepare($sql);
                      $stmt->bindParam(':idpacientes', $_POST['cedula']);
                      $stmt->bindParam(':ape_paterno', $_POST['apellidoPaterno']);
                      $stmt->bindParam(':ape_mat', $_POST['apellidoMaterno']);
                      $stmt->bindParam(':nombres', $_POST['name']);
                      $stmt->bindParam(':ocupacion', $_POST['ocupacion']);
                      $stmt->bindParam(':sexo', $_POST['sexo']);
                      $stmt->bindParam(':f_nacimiento', $_POST['fechaNacimiento']);
                      $stmt->bindParam(':provincia', $_POST['provincia']);
                      $stmt->bindParam(':ciudad', $_POST['ciudad']);
                      $stmt->bindParam(':zona', $_POST['zona']);
                      $stmt->bindParam(':direccion', $_POST['direccion']);
                      $stmt->bindParam(':tlno_particular', $_POST['telefono']);
                      $stmt->bindParam(':tlno_personal', $_POST['celular']);
                      $stmt->bindParam(':correo', $_POST['email']);                  
                      $stmt->bindParam(':afiliado', $_POST['afiliado']);
                      $stmt->bindParam(':id_usuario_pac', $id);

                      if($stmt->execute()){
                        $message = 'Usuario creado exitosamente';
                        header("Location: ../../../../");
                      }else{
                        $message = 'Error al crear nuevo usuario';
                      }
                }else{
                  $message = 'Error al crear nuevo usuario';
                }

          }else{
            $message = 'Error al crear nuevo usuario';
          }
  }
