<?php
require '../../../../database.php';
date_default_timezone_set('America/Guayaquil');

$created = date("Y-m-d H:i:s");
$orden = $conn->query("SELECT * FROM orden_compra as o, detalle_orden_compra AS de, producto_has_proveedor AS has, proveedores AS pr, productos AS pd WHERE (de.id_orden_compra_dt =o.id_orden_compra AND de.id_prod_has_prov=has.idproducto_has_proveedor AND has.idproveedor_has=pr.idproveedor AND has.idproducto_has=pd.idproducto) AND id_orden_compra=".$_POST['idOrden'])->fetchAll(PDO::FETCH_OBJ);

foreach ( $orden as $Productos ) { 
    
    $productoDuplicado = $conn->query("SELECT * FROM inventario_productos WHERE idproducto_inventario=".$Productos->idproducto)->rowCount();

    if($productoDuplicado > 0){
        //UPDATE CANTIDAD
        $stockActual = $conn->query("SELECT * FROM inventario_productos WHERE idproducto_inventario=".$Productos->idproducto)->fetchAll(PDO::FETCH_OBJ);
        $total = $stockActual[0]->stock + $Productos->cantidad;

        $sql = "UPDATE inventario_productos SET stock=:stock WHERE idproducto_inventario=:idproducto_inventario";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':stock',$total);
        $stmt->bindParam(':idproducto_inventario', $Productos->idproducto);
        $stmt->execute();

        //BUSCAR SI EL ID DE ESTE INVENTARIO_PRODUCTO YA ESTA REGISTRADO EN ORDE_COMPRA_INVENTARIO CON EL idOrden
        $idOci = $conn->query("SELECT * FROM orden_compra_inventario WHERE id_inventario_oci=".$stockActual[0]->idinventario_productos." AND id_orden_compra_oci=".$_POST['idOrden'])->rowCount();
        if($idOci < 1 ){
            $sql = "INSERT INTO orden_compra_inventario (id_orden_compra_oci,id_inventario_oci,created_at) VALUES (:id_orden_compra_oci,:id_inventario_oci,:created_at)";                    
            $stmt = $conn->prepare($sql);                              
            $stmt->bindParam(':id_orden_compra_oci', $_POST['idOrden']);
            $stmt->bindParam(':id_inventario_oci', $stockActual[0]->idinventario_productos);
            $stmt->bindParam(':created_at', $created);
            $stmt->execute();
        }
                 
    }else{
        $sql = "INSERT INTO inventario_productos (stock,idproducto_inventario) VALUES (:stock,:idproducto_inventario)";                    
        $stmt = $conn->prepare($sql);                              
        $stmt->bindParam(':stock', $Productos->cantidad);
        $stmt->bindParam(':idproducto_inventario', $Productos->idproducto);
        $stmt->execute();
        
        $idLast = $conn->lastInsertId();

        $sql = "INSERT INTO orden_compra_inventario (id_orden_compra_oci,id_inventario_oci,created_at) VALUES (:id_orden_compra_oci,:id_inventario_oci,:created_at)";                    
        $stmt = $conn->prepare($sql);                              
        $stmt->bindParam(':id_orden_compra_oci', $_POST['idOrden']);
        $stmt->bindParam(':id_inventario_oci', $idLast);
        $stmt->bindParam(':created_at', $created);
        $stmt->execute();
    }
}


    $sql = "UPDATE orden_compra SET registrado=:registrado,estado=:estado WHERE id_orden_compra=".$_POST['idOrden'];
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':estado', 'registrado', PDO::PARAM_STR);
    $stmt->bindValue(':registrado', 1, PDO::PARAM_INT);
    $stmt->execute();

    header("Location:../routes/ordenesCompra.php?id=".$_POST['idOrden']);