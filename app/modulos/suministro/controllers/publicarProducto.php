<?php
$_POST['idProduct'];

require '../../../../database.php';
require '../../seguridad/controllers/functions/Auditoria.php';

session_start();
$producto = $conn->query("SELECT * FROM productos WHERE idproducto=".$_POST['idProduct'])->fetchAll(PDO::FETCH_OBJ);

$sql = "UPDATE productos SET deleted=:deleted WHERE idproducto=:idproducto";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':deleted', 0, PDO::PARAM_INT);
$stmt->bindParam(':idproducto', $_POST['idProduct']);

if($stmt->execute()){

    $sql = "UPDATE producto_has_proveedor SET deleted=:deleted WHERE idproducto_has=:idproducto_has";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':deleted', 0, PDO::PARAM_INT);
    $stmt->bindParam(':idproducto_has', $_POST['idProduct']);

    if($stmt->execute()){
        $auditoria = new Auditoria(utf8_decode('Registro'), 'Suministros',utf8_decode("Se volvio a publicar un producto dado de baja: ".$producto[0]->nombre_pr),$_SESSION['user_id'],null);
        $auditoria->Registro($conn);
        header("Location:../routes/informacionProducto.php?id=".$_POST['idProduct']);
    }
}