<?php
require '../../../../database.php';
$idScope=$_POST['idScope'];
    $scopes = $conn->query("SELECT * FROM credencial_base WHERE id_scope_credencial = $idScope")->rowCount();
    
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

    header("Location:../routes/scopes.php");