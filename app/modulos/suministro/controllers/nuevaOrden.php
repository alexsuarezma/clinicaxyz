<?php
require '../../../../database.php';
require '../../seguridad/controllers/functions/Auditoria.php';

session_start();

date_default_timezone_set('America/Guayaquil');
$count = 0;

$created = date("Y-m-d H:i:s");
$pedido = date("Y-m-d");
//REGISTRAR PRIMERO ORDEN DE COMPRA
$sql = "INSERT INTO orden_compra (created_at,update_at,fecha_pedido,fecha_pago,estado,registrado) VALUES (:created_at,:update_at,:fecha_pedido,:fecha_pago,:estado,:registrado)";                    
$stmt = $conn->prepare($sql);                              
$stmt->bindParam(':created_at', $created);
$stmt->bindValue(':update_at', null, PDO::PARAM_INT);
$stmt->bindParam(':fecha_pedido',$pedido);
$stmt->bindValue(':fecha_pago', null, PDO::PARAM_INT);
$stmt->bindValue(':estado','espera', PDO::PARAM_STR);
$stmt->bindValue(':registrado', 0, PDO::PARAM_INT);

if($stmt->execute()){
    $idLast = $conn->lastInsertId();
    //LUEGO DETALLES
    foreach ( $_POST['idHasProv'] as $id ) { 
        $sql = "INSERT INTO detalle_orden_compra (cantidad,precio_unitario,id_prod_has_prov,id_orden_compra_dt) VALUES (:cantidad,:precio_unitario,:id_prod_has_prov,:id_orden_compra_dt)";                    
        $stmt = $conn->prepare($sql);                              
        $stmt->bindParam(':cantidad', $_POST['cantOc'][$count]);
        $stmt->bindParam(':precio_unitario', $_POST['precioUniOc'][$count]);
        $stmt->bindParam(':id_prod_has_prov', $id);
        $stmt->bindParam(':id_orden_compra_dt', $idLast);
        $stmt->execute();
        $count++;
    }
    $auditoria = new Auditoria(utf8_decode('Registro'), 'Suministros',utf8_decode("Se registro una nueva Orden de Compra #".$idLast),$_SESSION['user_id'],null);
    $auditoria->Registro($conn);
    header("Location:../routes/ordenesCompra.php?id= $idLast");
}
    