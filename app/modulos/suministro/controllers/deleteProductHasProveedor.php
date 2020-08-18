<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <div class='modal fade' name='deleteHas' id='deleteHas' data-backdrop='static' data-keyboard='false' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabe' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='staticBackdropLabel'>Eliminar Proveedor asociado al Producto</h5>
                    </button>
                </div>
                <div class='modal-body'>
                <input type="hidden" name="idProd" id="idProd" value="<?php echo $_POST['idProducto']?>">
                        ¡Hey!. Se ha eliminado el PROVEEDOR asociado a el producto, <?php echo $_POST['idProducto']?> ya no se encuentra registrado en la lista proveedores que lo surten.
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
require '../../seguridad/controllers/functions/Auditoria.php';

session_start();

$producto = $conn->query("SELECT * FROM productos WHERE idproducto=".$_POST['idProducto'])->fetchAll(PDO::FETCH_OBJ);
$proveedor = $conn->query("SELECT * FROM proveedores WHERE idproveedor=".$_POST['idProveedor'])->fetchAll(PDO::FETCH_OBJ);

$sql = "UPDATE producto_has_proveedor SET deleted=:deleted WHERE idproducto_has=:idproducto_has AND idproveedor_has=:idproveedor_has";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':deleted', 1, PDO::PARAM_INT);
$stmt->bindParam(':idproducto_has', $_POST['idProducto']);
$stmt->bindParam(':idproveedor_has', $_POST['idProveedor']);

if($stmt->execute()){
    $auditoria = new Auditoria(utf8_decode('Borrado'), 'Suministros',utf8_decode("Se elimino el proveedor ".$proveedor[0]->razon_social_empresa_pro." del producto ".$producto[0]->nombre_pr),$_SESSION['user_id'],null);
    $auditoria->Registro($conn);
    echo "<script language='javascript'>$('#deleteHas').modal('show');</script>"; 
}