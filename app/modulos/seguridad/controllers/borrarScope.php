<?php
require '../../../../database.php';
require 'functions/Auditoria.php';
session_start();
$idScope=$_POST['idScope'];
if($idScope == 5){
    header("Location: scopes.php");
}
    $scopes = $conn->query("SELECT * FROM credencial_base WHERE id_scope_credencial = $idScope")->rowCount();
    $scope = $conn->query("SELECT * FROM scope WHERE id_scope=".$_POST['idScope'])->fetchAll(PDO::FETCH_OBJ);

    if($scopes>0){
        //UPDATE Y DELETE
        $sql = "UPDATE credencial_base SET id_scope_credencial=:id_scope_credencial WHERE id_scope_credencial=:idScope";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idScope', $_POST['idScope']);
        $stmt->bindParam(':id_scope_credencial', $_POST['scope']);
        $stmt->execute();
    }
    
    $sql = "DELETE FROM scope WHERE id_scope=:id_scope";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_scope', $_POST['idScope']);
    $stmt->execute();
    $auditoria = new Auditoria(utf8_decode('Borrado'), 'Seguridad',utf8_decode("Se elimino un scope base ".$scope[0]->descripcion_rol),$_SESSION['user_id'],null);
    $auditoria->Registro($conn);
    header("Location:../routes/scopes.php");