<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <div class='modal fade' name='productoDuplicado' id='productoDuplicado' data-backdrop='static' data-keyboard='false' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabe' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='staticBackdropLabel'>Proveedor en el Producto DUPLICADO</h5>
                    </button>
                </div>
                <div class='modal-body'>
                        <input type="hidden" name="idProd" id="idProd" value="<?php echo $_POST['idProductoinsert']?>">
                        ¡Hey!. Este PROVEEDOR ya esta se encuentra en la lista de proveedores del PRODUCTO, por favor verifica  en la lista de provedores del productos.
                </div>
                <div class='modal-footer'>
                        <button id='continuar' name='confirmacion-update' type='submit' class='btn btn-primary font-weight-bold' style="width:200px;">Continuar</button>
                </div>
            </div>
        </div>
    </div>
<script src="../components/scripts/jquery.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script>
    $('#continuar').click(function(){
        location.href=`../routes/informacionProducto.php?id=${$('#idProd').val()}`;
    });  
</script>
</body>
</html>
<?php
require '../../../../database.php';
    
    $productoHasYaAsignado = $conn->query("SELECT * FROM producto_has_proveedor WHERE idproducto_has=".$_POST['idProductoinsert']." AND idproveedor_has=".$_POST['proveedor'])->rowCount();
    
    //PRODUCTO YA TIENE ASIGNADO ESTE PROVEEDOR
    if($productoHasYaAsignado>0){
        //VERIFICAR SI DELETE ESTABA EN TRUE
        $productoHasYaAsignadoDeleted = $conn->query("SELECT * FROM producto_has_proveedor WHERE idproducto_has=".$_POST['idProductoinsert']." AND idproveedor_has=".$_POST['proveedor'])->fetchAll(PDO::FETCH_OBJ);
        if($productoHasYaAsignadoDeleted[0]->deleted==1){
            //UPDATE A NO BORRADO
            $sql = "UPDATE producto_has_proveedor SET deleted=:deleted WHERE idproducto_has=:idproducto_has AND idproveedor_has=:idproveedor_has";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':deleted', 0, PDO::PARAM_INT);
            $stmt->bindParam(':idproducto_has', $_POST['idProductoinsert']);
            $stmt->bindParam(':idproveedor_has', $_POST['proveedor']);
            if($stmt->execute()){
                header("Location:../routes/informacionProducto.php?id=".$_POST['idProductoinsert']);
            }
        }else{
            //MSG ESTE PROVEDOR YA ESTA ASIGNADO AL PRODUCTO
            echo "<script language='javascript'>$('#productoDuplicado').modal('show');</script>"; 
        }
    }else{
            $sql = "INSERT INTO producto_has_proveedor (idproducto_has,idproveedor_has,deleted) VALUES (:idproducto_has,:idproveedor_has,:deleted)";                    
            $stmt = $conn->prepare($sql);                              
            $stmt->bindParam(':idproducto_has',$_POST['idProductoinsert']);
            $stmt->bindParam(':idproveedor_has',$_POST['proveedor']);
            $stmt->bindValue(':deleted', 0, PDO::PARAM_INT);
            if($stmt->execute()){
                header("Location:../routes/informacionProducto.php?id=".$_POST['idProductoinsert']);
            }
    }
    