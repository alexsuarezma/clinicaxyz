<?php
require '../../../../database.php';
require '../../seguridad/controllers/functions/Auditoria.php';

session_start();

date_default_timezone_set('America/Guayaquil');
$created = date("Y-m-d H:i:s");

$categoria = $conn->query("SELECT * FROM categoria WHERE idcategoria=".$_POST['categoria'])->fetchAll(PDO::FETCH_OBJ);

// RESTAR //UPDATE
$oldStock = $conn->query("SELECT * FROM inventario_productos WHERE idinventario_productos=".$_POST['idinventario'])->fetchAll(PDO::FETCH_OBJ);

$inStock = ($oldStock[0]->stock - $_POST['cantidad']);

$sql = "UPDATE inventario_productos SET stock=:stock WHERE idinventario_productos=:idinventario_productos";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':stock', $inStock);
$stmt->bindParam(':idinventario_productos', $_POST['idinventario']);

if($stmt->execute()){
    // REGISTRAR ORDEN DE DISTRIBUCION
    $sql = "INSERT INTO orden_distribucion (cantidad,departamento,detalle,id_producto_od,created_at) VALUES (:cantidad,:departamento,:detalle,:id_producto_od,:created_at)";                    
    $stmt = $conn->prepare($sql);                              
    $stmt->bindParam(':cantidad',$_POST['cantidad']);
    $stmt->bindParam(':departamento', $categoria[0]->nombre_cate);
    $stmt->bindParam(':detalle', $_POST['detalle']);                
    $stmt->bindParam(':id_producto_od',$_POST['idproducto']);
    $stmt->bindParam(':created_at',$created);
    if($stmt->execute()){
        //TO PDF
        $idLast = $conn->lastInsertId();
        $auditoria = new Auditoria(utf8_decode('Registro'), 'Suministros',utf8_decode("Se registro una Orden de Distribución: #".$idLast),$_SESSION['user_id'],null);
        $auditoria->Registro($conn);
        header('Location: http://localhost:8000/orden_distribucion.php?order='.$idLast);
    }
}


