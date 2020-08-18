<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <div class='modal fade' name='credencialEliminada' id='credencialEliminada' data-backdrop='static' data-keyboard='false' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabe' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='staticBackdropLabel'>Credencial De Usuarios</h5>
                    </button>
                </div>
                <div class='modal-body'>
                        ¡Hey!. No puedes borrar una CREDENCIAL "SIN ACCESO" anexada a un USUARIO... debes ACTUALIZAR la credencial a este usuario si deseas.
                </div>
                <div class='modal-footer'>
                        <button id='continuar' name='confirmacion-update' type='submit' class='btn btn-primary font-weight-bold' style="width:200px;">Continuar</button>
                </div>
            </div>
        </div>
    </div>
<script src="../components/scripts/jquery.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script>
    $('#continuar').click(function(){
        location.href=`../routes/usuarios.php`;
    });  
</script>
</body>
</html>

<?php
require '../../../../database.php';
require 'functions/Auditoria.php';
session_start();
    $usuarioSinAcceso = $conn->query("SELECT * FROM usuario_credencial WHERE id_usuario_uc =".$_GET['idUser']." AND id_credencialbase_uc = 19")->rowCount();
    $empleado = $conn->query("SELECT * FROM empleados WHERE id_usuario_emp=".$_GET['idUser'])->fetchAll(PDO::FETCH_OBJ);

    if($usuarioSinAcceso > 0){

        if($_GET['idCredencial'] == 19){
            //MSG NO PUEDE BORRAR ESA CREDENCIAL
            echo "<script language='javascript'>$('#credencialEliminada').modal('show');</script>"; 
        }else{
            $sql = "DELETE FROM usuario_credencial WHERE id_usuario_uc=:id_usuario_uc AND id_credencialbase_uc=:id_credencialbase_uc";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_credencialbase_uc', $_GET['idCredencial']);
            $stmt->bindParam(':id_usuario_uc', $_GET['idUser']);
            $stmt->execute();
            $auditoria = new Auditoria(utf8_decode('Borrado'), 'Seguridad',utf8_decode("Se elimino una credencial al usuario con cedula: ".$empleado[0]->id_empleados."-".$empleado[0]->nombres." ".$empleado[0]->apellidos),$_SESSION['user_id'],null);
            $auditoria->Registro($conn);
            header("Location:../routes/usuarios.php");
        }   
    }else{
        //si es la unica credencial que tiene actualizarla a sin acceso
        $unicaCredencial = $conn->query("SELECT * FROM usuario_credencial WHERE id_usuario_uc =".$_GET['idUser'])->rowCount();

        if($unicaCredencial == 1){
            //UPDATE CREDENCIAL
            $sql = "UPDATE usuario_credencial SET id_credencialbase_uc=:id_credencialbase_uc WHERE id_usuario_uc=:id_usuario_uc";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_usuario_uc', $_GET['idUser']);
            $stmt->bindValue(':id_credencialbase_uc', 19, PDO::PARAM_INT);
            $stmt->execute();
            $auditoria = new Auditoria(utf8_decode('Borrado'), 'Seguridad',utf8_decode("Se elimino una credencial al usuario con cedula: ".$empleado[0]->id_empleados."-".$empleado[0]->nombres." ".$empleado[0]->apellidos),$_SESSION['user_id'],null);
            $auditoria->Registro($conn);
            header("Location:../routes/usuarios.php");
            
        }else{

            $sql = "DELETE FROM usuario_credencial WHERE id_usuario_uc=:id_usuario_uc AND id_credencialbase_uc=:id_credencialbase_uc";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_credencialbase_uc', $_GET['idCredencial']);
            $stmt->bindParam(':id_usuario_uc', $_GET['idUser']);
            $stmt->execute();
            $auditoria = new Auditoria(utf8_decode('Borrado'), 'Seguridad',utf8_decode("Se elimino una credencial al usuario con cedula: ".$empleado[0]->id_empleados."-".$empleado[0]->nombres." ".$empleado[0]->apellidos),$_SESSION['user_id'],null);
            $auditoria->Registro($conn);
            header("Location:../routes/usuarios.php");
        }
    }   
    
?>