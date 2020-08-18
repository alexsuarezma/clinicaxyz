<?php

require '../../../../database.php';
require '../../seguridad/controllers/functions/Auditoria.php';

session_start();

date_default_timezone_set('America/Guayaquil');

$created = date("Y-m-d H:i:s");
$pago = date("Y-m-d");

$sql = "UPDATE orden_compra SET estado=:estado,update_at=:update_at,comentario=:comentario,total=:total,fecha_pago=:fecha_pago WHERE id_orden_compra=:id_orden_compra";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id_orden_compra', $_POST['idOrden']);
$stmt->bindParam(':update_at', $created);
$stmt->bindParam(':estado', $_POST['estadoPedido']);
$stmt->bindParam(':total', $_POST['total']);


if($_POST['estadoPedido'] == 'pagado'){
    $stmt->bindParam(':fecha_pago', $pago);
}else{
    $stmt->bindValue(':fecha_pago', null, PDO::PARAM_INT);   
}



if(isset($_POST['comentario'])){
    $stmt->bindParam(':comentario', $_POST['comentario']);   
}else{
    $stmt->bindValue(':comentario', null, PDO::PARAM_INT);   
}


if($stmt->execute()){
    $auditoria = new Auditoria(utf8_decode('Actualizar'), 'Contabilidad',utf8_decode("Se actualizo el estado de una Orden de Compra a : ".$_POST['estadoPedido'].", Orden#".$_POST['idOrden']),$_SESSION['user_id'],null);
    $auditoria->Registro($conn);
    header("Location:../routes/requerimientoCompra.php?id=".$_POST['idOrden']);
}