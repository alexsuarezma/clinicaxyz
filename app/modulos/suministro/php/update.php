<?php

require '../../../../database.php';
$id = $_POST['idproducto'];

$sql = "UPDATE productos SET codigo_barra_pr=:codigo_barra_pr,nombre_pr=:nombre_pr,descripcion_pr=:descripcion_pr,stock_pr=:stock_pr,precio_pr=:precio_pr,fecha_elaboracion_pr=:fecha_elaboracion_pr,fecha_caducidad_pr=:fecha_caducidad_pr,idcategoria_pr=:idcategoria_pr WHERE idproducto=:idproducto";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':codigo_barra_pr',$_POST['serie_pr']);
$stmt->bindParam(':nombre_pr',$_POST['nombre_pr']);
$stmt->bindParam(':descripcion_pr',$_POST['descripcion_pr']);
$stmt->bindParam(':stock_pr',$_POST['stock_pr']);
$stmt->bindParam(':precio_pr', $_POST['precio_pr']);
$stmt->bindParam(':fecha_elaboracion_pr', $_POST['fecha_elaboracion']);
$stmt->bindParam(':fecha_caducidad_pr', $_POST['fecha_elaboracion']);
$stmt->bindParam(':idcategoria_pr', $_POST['categoria_pr']);
$stmt->bindParam(':idproducto', $id);

        if($stmt->execute()){
            echo "DATO ACTUALIZADO CORRECTAMENTE";
        }else{
            echo "DATO NO GUARDADO";
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="2;URL=buscar.php?p=<?php echo $id;?>">
    <title>Document</title>
</head>
<body>
    
</body>
</html>