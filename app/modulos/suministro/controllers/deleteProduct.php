<?php
require '../../../../database.php';
require '../../seguridad/controllers/functions/Auditoria.php';

session_start();

$producto = $conn->query("SELECT * FROM productos WHERE idproducto=".$_POST['idProduct'])->fetchAll(PDO::FETCH_OBJ);

$sql = "UPDATE productos SET deleted=:deleted WHERE idproducto=:idproducto";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':deleted', 1, PDO::PARAM_INT);
$stmt->bindParam(':idproducto', $_POST['idProduct']);

if($stmt->execute()){
    //SE QUITA EL PRODUCTO PRODUC_HAS_PROVE
    $sql = "UPDATE producto_has_proveedor SET deleted=:deleted WHERE idproducto_has=:idproducto_has";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':deleted', 1, PDO::PARAM_INT);
    $stmt->bindParam(':idproducto_has', $_POST['idProduct']);
    if($stmt->execute()){
        $auditoria = new Auditoria(utf8_decode('Borrado'), 'Suministro',utf8_decode("Se dio de baja a un producto: ".$producto[0]->nombre_pr),$_SESSION['user_id'],null);
        $auditoria->Registro($conn);
        header("Location:../routes/productos.php");
    }
}