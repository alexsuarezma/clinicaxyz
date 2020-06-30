<?php 
require 'conexion.php'; 
$q = $conexion->real_escape_string($_GET['p']);
    $query= "SELECT * FROM proveedores WHERE (idproveedor LIKE '%$q%' OR numero_identificacion_pro LIKE '%$q%' OR razon_social_empresa_pro LIKE '%$q%' OR nombre_representante_legal_pro LIKE '%$q%' OR direccion_pro LIKE '%$q%' OR ciudad_pro LIKE '%$q%' OR email_1_pro LIKE '%$q%' OR telefono_1_pro LIKE '$q')";	
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
    <h4 class="mt-5" style="text-align:center;">PROVEEDORES</h4>
    <div class="container mt-5">
   
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">N° Identificación</th>
                <th scope="col">Razon Social</th>
                <th scope="col">Nombre Representante Legal</th>
                <th scope="col">Direccion</th>
                <th scope="col">Ciudad</th>
                <th scope="col">Telefono 1</th>
                <th scope="col">Telefono 2</th>
                <th scope="col">Email 1</th>
                <th scope="col">Email 2</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($resultado->num_rows>0) {
                while($proveedores = $resultado->fetch_assoc()):
            ?>
                <tr>
                    <th scope="row"><?php echo $proveedores["numero_identificacion_pro"];?></th>
                    <td><?php echo $proveedores["razon_social_empresa_pro"];?></td>
                    <td><?php echo $proveedores["nombre_representante_legal_pro"];?></td>
                    <td><?php echo $proveedores["direccion_pro"];?></td>
                    <td><?php echo $proveedores["ciudad_pro"];?></td>
                    <td><?php echo $proveedores["telefono_1_pro"];?></td>
                    <td><?php echo $proveedores["telefono_2_pro"];?></td>
                    <td><?php echo $proveedores["email_1_pro"];?></td>
                    <td><?php echo $proveedores["email_2_pro"];?></td>
                    <td>
                        <a href="../actualizarProveedor.php?id=<?php echo $proveedores["idproveedor"];?>"><i class="fas fa-edit" style="color:blue;" title="Editar"></i></a>
                        <a id="delete" href="delete.php?id=<?php echo $proveedores["idproveedor"];?>&proveedor=1" class=""><i class="fas fa-trash-alt" style="color:red;" title="Eliminar"></i></a>
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