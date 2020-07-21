

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
                        ¡Hey!. La CREDENCIAL que agregaste a este USUARIO YA EXISTE. Se elimino la credencial duplicada.
                </div>
                <div class='modal-footer'>
                        <button id='continuar' name='confirmacion-update' type='submit' class='btn btn-primary font-weight-bold' style="width:200px;">Continuar</button>
                </div>
            </div>
        </div>
    </div>

    <div class='modal fade' name='credencialSinAcceso' id='credencialSinAcceso' data-backdrop='static' data-keyboard='false' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabe' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='staticBackdropLabel'>Credencial De Usuarios</h5>
                    </button>
                </div>
                <div class='modal-body'>
                        ¡Hey!. No puedes agregarle una credencial "SIN ACCESO" a un usuario. Si deseas puedes ELIMINAR sus CREDENCIALES y cambiar su ultima credencial a "SIN ACCESO".
                </div>
                <div class='modal-footer'>
                        <button id='ok' name='ok' type='submit' class='btn btn-primary font-weight-bold' style="width:200px;">Continuar</button>
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
    $('#ok').click(function(){
        location.href=`../routes/usuarios.php`;
    });  
</script>
</body>
</html>



<?php
require '../../../../database.php';

    $usuario = $conn->query("SELECT * FROM usuario_credencial WHERE id_usuario_uc = ".$_POST['idUserCredencialUsuario']." AND id_credencialbase_uc = 19")->rowCount();
    
    if($usuario > 0){
        //Update credencial sin acceso
        $sql = "UPDATE usuario_credencial SET id_credencialbase_uc=:id_credencialbase_uc WHERE id_usuario_uc=:id_usuario_uc AND id_credencialbase_uc = 19";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_usuario_uc', $_POST['idUserCredencialUsuario']);
        $stmt->bindParam(':id_credencialbase_uc', $_POST['credencialUsuario']);
        if($stmt->execute()){
            header("Location: ../routes/usuarios.php");
        }
    }
    
    if($_POST['credencialUsuario']==19){
            echo "<script language='javascript'>$('#credencialSinAcceso').modal('show');</script>"; 
    }else{

        $credencialDuplicada = $conn->query("SELECT * FROM usuario_credencial WHERE id_usuario_uc = ".$_POST['idUserCredencialUsuario']." AND id_credencialbase_uc = ".$_POST['credencialUsuario'])->rowCount();    
            if($credencialDuplicada > 0){
                //Credencial Duplicada
                $idCredencialDuplicada = $conn->query("SELECT id_usuario_credencial FROM usuario_credencial WHERE id_usuario_uc = ".$_POST['idUserCredencialUsuario']." AND id_credencialbase_uc = ".$_POST['credencialUsuario'])->fetchAll(PDO::FETCH_OBJ);    

                if ($_POST['idUcActual'] != $idCredencialDuplicada[0]->id_usuario_credencial) {
                    //BORRO CREDENCIAL ACTUAL                    
                    $conn->query("DELETE FROM usuario_credencial WHERE id_usuario_credencial = ".$_POST['idUcActual']);
                }            

                echo "<script language='javascript'>$('#credencialEliminada').modal('show');</script>"; 
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
    }
?>