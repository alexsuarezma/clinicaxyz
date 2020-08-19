<?php

require '../../../../database.php';
require '../../seguridad/controllers/functions/Auditoria.php';

session_start();

$producto = $conn->query("SELECT * FROM productos WHERE idproducto=".$_POST['idproducto'])->fetchAll(PDO::FETCH_OBJ);

$sql = "UPDATE productos SET codigo_barra_pr=:codigo_barra_pr,nombre_pr=:nombre_pr,descripcion_pr=:descripcion_pr,precio_unitario_pr=:precio_unitario_pr,fecha_elaboracion_pr=:fecha_elaboracion_pr,fecha_caducidad_pr=:fecha_caducidad_pr,idcategoria_pr=:idcategoria_pr WHERE idproducto=:idproducto";

if($_POST['type']==1){
    $sql = "UPDATE productos SET codigo_barra_pr=:codigo_barra_pr,nombre_pr=:nombre_pr,descripcion_pr=:descripcion_pr,precio_unitario_pr=:precio_unitario_pr,fecha_elaboracion_pr=:fecha_elaboracion_pr,fecha_caducidad_pr=:fecha_caducidad_pr,idcategoria_pr=:idcategoria_pr,img_pr=:img_pr WHERE idproducto=:idproducto";
}

$stmt = $conn->prepare($sql);
$stmt->bindParam(':codigo_barra_pr',$_POST['codigoBarra']);
$stmt->bindParam(':nombre_pr',$_POST['nombreProducto']);
$stmt->bindParam(':descripcion_pr',$_POST['descripcion']);
$stmt->bindParam(':precio_unitario_pr', $_POST['precio']);
$stmt->bindParam(':fecha_elaboracion_pr', $_POST['fechaElaboracion']);
$stmt->bindParam(':fecha_caducidad_pr', $_POST['fechaCaducidad']);
$stmt->bindParam(':idcategoria_pr', $_POST['categoria']);
$stmt->bindParam(':idproducto', $_POST['idproducto']);
if($_POST['type']==1){
$stmt->bindParam(':img_pr', $_POST['img_Product']);
}

        if($stmt->execute()){
            $auditoria = new Auditoria(utf8_decode('Actualización'), 'Suministros',utf8_decode("Se actualizo un producto ".$producto[0]->nombre_pr),$_SESSION['user_id'],null);
            $auditoria->Registro($conn);
            header("Location:../routes/productos.php");
        }