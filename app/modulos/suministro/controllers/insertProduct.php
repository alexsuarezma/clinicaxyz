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
                    <h5 class='modal-title' id='staticBackdropLabel'>Codigo de Barra de Producto Duplicado</h5>
                    </button>
                </div>
                <div class='modal-body'>
                        ¡Hey!. Este producto ya esta registrado, por favor verifica el codigo de barra <?php echo $_POST['codigoBarra']?> en la lista de productos ya registrados.
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
        location.href=`../routes/productos.php`;
    });  
</script>
</body>
</html>


<?php

require '../../../../database.php';
require '../../seguridad/controllers/functions/Auditoria.php';

session_start();


$productoDuplicado = $conn->query("SELECT * FROM productos WHERE codigo_barra_pr =".$_POST['codigoBarra'])->rowCount();

    if($productoDuplicado > 0){
        echo "<script language='javascript'>$('#productoDuplicado').modal('show');</script>"; 
    
    }else{
        
        $sql = "INSERT INTO productos (codigo_barra_pr,nombre_pr,descripcion_pr,precio_unitario_pr,fecha_elaboracion_pr,fecha_caducidad_pr,idcategoria_pr,deleted,img_pr) VALUES (:codigo_barra_pr,:nombre_pr,:descripcion_pr,:precio_unitario_pr,:fecha_elaboracion_pr,:fecha_caducidad_pr,:idcategoria_pr,:deleted,:img_pr)";                    
        $stmt = $conn->prepare($sql);                              
        $stmt->bindParam(':codigo_barra_pr',$_POST['codigoBarra']);
        $stmt->bindParam(':nombre_pr',$_POST['nombreProducto']);
        $stmt->bindParam(':descripcion_pr',$_POST['descripcion']);
        $stmt->bindParam(':precio_unitario_pr', $_POST['precio']);
        $stmt->bindParam(':fecha_elaboracion_pr', $_POST['fechaElaboracion']);
        $stmt->bindParam(':fecha_caducidad_pr', $_POST['fechaCaducidad']);
        $stmt->bindParam(':idcategoria_pr', $_POST['categoria']);
        $stmt->bindValue(':deleted', 0, PDO::PARAM_INT);
        $stmt->bindParam(':img_pr', $_POST['img_Product']);
        
        if($stmt->execute()){
            $id = $conn->lastInsertId();
            
                // PONER product_has_proveedor proveedor;
                $sql = "INSERT INTO producto_has_proveedor (idproducto_has,idproveedor_has,deleted) VALUES (:idproducto_has,:idproveedor_has,:deleted)";                    
                $stmt = $conn->prepare($sql);                              
                $stmt->bindParam(':idproducto_has',$id);
                $stmt->bindParam(':idproveedor_has',$_POST['proveedor']);
                $stmt->bindValue(':deleted', 0, PDO::PARAM_INT);                
                if($stmt->execute()){
                    $auditoria = new Auditoria(utf8_decode('Registro'), 'Suministros',utf8_decode("Se registro un nuevo producto: ".$_POST['nombreProducto']),$_SESSION['user_id'],null);
                    $auditoria->Registro($conn);
                    header("Location:../routes/productos.php");
                }
            }
    }
?>