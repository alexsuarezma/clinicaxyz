<?php
echo $_POST['idOrden'];
require '../../../../database.php';




$sql = "INSERT INTO inventario_productos (stock,precio_unitario_pvp) VALUES (:stock,:precio_unitario_pvp)";                    
$stmt = $conn->prepare($sql);                              
$stmt->bindParam(':stock', $_POST['cantOc'][$count]);
$stmt->bindParam(':precio_unitario_pvp', $_POST['precioUniOc'][$count]);
$stmt->bindParam(':id_prod_has_prov', $id);
$stmt->bindParam(':id_orden_compra_dt', $idLast);
$stmt->execute();


$sql = "INSERT INTO orden_compra_inventario (id_orden_compra_oci,id_inventario_oci) VALUES (:id_orden_compra_oci,:id_inventario_oci)";                    
$stmt = $conn->prepare($sql);                              
$stmt->bindParam(':id_orden_compra_oci', $_POST['idOrden']);
$stmt->bindParam(':id_inventario_oci', $_POST['precioUniOc'][$count]);
$stmt->execute();