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
                        ¡Hey!. La CREDENCIAL que cambiaste a este USUARIO YA EXISTE. Se elimino la credencial duplicada.
                </div>
                <div class='modal-footer'>
                        <button id='continuar' name='confirmacion-update' type='submit' class='btn btn-primary font-weight-bold' style="width:200px;">Continuar</button>
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
    $scopes = $conn->query("SELECT * FROM usuario_credencial WHERE id_usuario_uc = ".$_POST['idUser']." AND id_credencialbase_uc = ".$_POST['credencial'])->rowCount();
    $empleado = $conn->query("SELECT * FROM empleados AS e, usuario AS u, usuario_credencial AS uc WHERE (e.id_usuario_emp=u.id_usuario AND u.id_usuario=uc.id_usuario_uc) AND id_usuario_credencial=".$_POST['idUserCredencial'])->fetchAll(PDO::FETCH_OBJ);

    if($scopes>0){
        //delete
        $sql = "DELETE FROM usuario_credencial WHERE id_usuario_credencial=:id_usuario_credencial";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_usuario_credencial', $_POST['idUserCredencial']);
        $stmt->execute();
        echo "<script language='javascript'>$('#credencialEliminada').modal('show');</script>";
    }else{
        //update
        $sql = "UPDATE usuario_credencial SET id_credencialbase_uc=:id_credencialbase_uc WHERE id_usuario_credencial=:id_usuario_credencial";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_usuario_credencial', $_POST['idUserCredencial']);
        $stmt->bindParam(':id_credencialbase_uc', $_POST['credencial']);
        $stmt->execute();
        $auditoria = new Auditoria(utf8_decode('Actualización'), 'Seguridad',utf8_decode("Se actualizo una credencial al usuario con cedula: ".$empleado[0]->id_empleados."-".$empleado[0]->nombres." ".$empleado[0]->apellidos),$_SESSION['user_id'],null);
        $auditoria->Registro($conn);
        header("Location:../routes/usuarios.php");
    }

?>
