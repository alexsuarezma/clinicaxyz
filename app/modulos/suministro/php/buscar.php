<?php 
require 'conexion.php'; 
$q = $conexion->real_escape_string($_GET['p']);
    $query= "SELECT * FROM productos AS p, categoria AS c WHERE (p.idcategoria_pr = c.idcategoria) AND (idproducto LIKE '%$q%' OR nombre_cate LIKE '%$q%' OR codigo_barra_pr LIKE '%$q%' OR nombre_pr LIKE '%$q%' OR descripcion_pr LIKE '%$q%' OR stock_pr LIKE '%$q%' OR precio_pr LIKE '$q')";	
    $resultado = $conexion->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/sumies.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
   
    <title>Document</title>
</head>
<body>
    <h3 class="mt-2" style="text-align:center;">Resultado de la busqueda</h3>
    <hr class="mt-1 mb-4 mr-5 ">
    <h4 class="mt-5" style="text-align:center;">PRODUCTOS</h4>
    <div class="container mt-5">
   
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Codigo de Barra</th>
                <th scope="col">Nombre</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Stock</th>
                <th scope="col">Precio</th>
                <th scope="col">Fecha Elaboración</th>
                <th scope="col">Fecha Caducidad</th>
                <th scope="col">Categoria</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($resultado->num_rows>0) {
                while($productos = $resultado->fetch_assoc()):
            ?>
                <tr>
                    <th scope="row"><?php echo $productos["idproducto"];?></th>
                    <td><?php echo $productos["codigo_barra_pr"];?></td>
                    <td><?php echo $productos["nombre_pr"];?></td>
                    <td><?php echo $productos["descripcion_pr"];?></td>
                    <td><?php echo $productos["stock_pr"];?></td>
                    <td><?php echo $productos["precio_pr"];?></td>
                    <td><?php echo $productos["fecha_elaboracion_pr"];?></td>
                    <td><?php echo $productos["fecha_caducidad_pr"];?></td>
                    <td><?php echo $productos["idcategoria_pr"];?></td>
                    <td>
                        <a href="../actualizar.php?id=<?php echo $productos["idproducto"];?>"><i class="fas fa-edit" style="color:blue;" title="Editar"></i></a>
                        <a id="delete" href="delete.php?id=<?php echo $productos["idproducto"];?>&proveedor=0" class="mr-3"><i class="fas fa-trash-alt" style="color:red;" title="Eliminar"></i></a>
                    </td>
                </tr>
            <?php 
                endwhile;
            }else{
            ?> 
                <td>
                    No hay datos asociados a la busqueda
                </td>
            <?php 
            }
            ?> 
            </tbody>
        </table>
       <a href="../">Vuelve al inicio</a>
    <footer class="mt-5">
      <span>Copyright 2020 Departamento Suministros</span>
    </footer>
   </div>
  
</body>
</html>