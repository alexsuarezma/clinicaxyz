<?php
require '../../../../database.php';
require '../components/layout.php';
require '../../seguridad/controllers/functions/credenciales.php';

verificarAcceso("../../../../", "modulo_suministros");
$prod = $conn->query("SELECT * FROM producto_has_proveedor WHERE idproveedor_has=".$_GET['id'])->rowCount();

if($prod > 0){
    $proveedor = $conn->query("SELECT * FROM proveedores AS p, producto_has_proveedor AS has, productos AS pr WHERE (p.idproveedor=has.idproveedor_has AND has.idproducto_has=pr.idproducto) AND idproveedor=".$_GET['id'])->fetchAll(PDO::FETCH_OBJ);
    
    $orde = $conn->query("SELECT * FROM producto_has_proveedor AS has, detalle_orden_compra AS doc, orden_compra AS oc WHERE (doc.id_prod_has_prov=has.idproducto_has_proveedor AND doc.id_orden_compra_dt=oc.id_orden_compra) AND  has.idproveedor_has=".$_GET['id'])->rowCount();

    if($orde > 0){

        $ordenes = $conn->query("SELECT * FROM producto_has_proveedor AS has, productos AS pr, detalle_orden_compra AS doc, orden_compra AS oc WHERE (doc.id_prod_has_prov=has.idproducto_has_proveedor AND has.idproducto_has=pr.idproducto AND doc.id_orden_compra_dt=oc.id_orden_compra) AND has.idproveedor_has=".$_GET['id'])->fetchAll(PDO::FETCH_OBJ);
    }
}else{
    $proveedor = $conn->query("SELECT * FROM proveedores WHERE idproveedor=".$_GET['id'])->fetchAll(PDO::FETCH_OBJ);
}





// foreach ($ordenes as $Proveedores):
//     echo $Proveedores->id_orden_compra;
//     echo '</br>';
//     if($Proveedores->estado=="pagado"):
//         echo '</br>';
//         echo '------------';
//         echo $Proveedores->id_orden_compra;
//         echo '</br>';
//         $acumulado=($Proveedores->cantidad*$Proveedores->precio_unitario);
//         echo '</br>';
//         echo 'Total deuda';
//         echo $acumulado;
//     else:
//         $acumulado=0;
//     endif;
// endforeach;

?>



<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title> Suministro | Proveedores</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link href="../assets/styles/dashboard.css" rel="stylesheet">
    
  </head>
  
  <body>
<?php
    printLayout ('../ico/farma.ico','../index.php', '../../../../index.php','inventario.php','productos.php', 'nuevoProducto.php',
    'historialProductos.php','historialOrdenCompra.php','nuevaOrdenCompra.php','listaOrdenesCompra.php','proveedores.php','../../seguridad/controllers/logout.php','../../seguridad/routes/perfil.php',
    '../../recursoshumanos/','../index.php','../../contabilidad/','../../citasmedicas/','../../pacientes/','../../seguridad/',2);
?>
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">PROVEEDORES DE PRODUCTOS</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar"></span>
            This week
          </button>
        </div>
      </div>
     
      <div class="container mt-5 mb-5">
           
<div class="page-content container note-has-grid">
    
    <form id="form" method="POST" action="../controllers/insertProveedor.php" class="ml-2 mr-2">
        <label class="font-weight-bold">PROVEEDOR</label>
        <hr class="mt-1 mb-4 mr-5">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="numeroIdentificacion">Numero identificación</label>
                <input type="text" class="form-control" name="numeroIdentificacion" value="<?php echo $proveedor[0]->numero_identificacion_pro?>" required readonly>
            </div>
            <div class="form-group col-md-6">
                <label for="razonSocial">Razon social de la empresa</label>
                <input type="text" class="form-control" name="razonSocial" value="<?php echo $proveedor[0]->razon_social_empresa_pro?>"id="razonSocial" required readonly>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="direccionProveedor">Dirección</label>
                <input type="text" class="form-control" name="direccionProveedor" value="<?php echo $proveedor[0]->direccion_pro?>"id="direccionProveedor" required readonly>
            </div>
            <div class="col-md-6 mb-3">
            <label for="validationServer14">Ciudad</label>
            <input class="form-control" name="ciudad" id="validationServer08" required value="<?php echo $proveedor[0]->ciudad_pro?>"readonly>
        </div>
        </div>
        <label class="font-weight-bold">Información de contacto</label>
        <hr class="mt-1 mb-4 mr-5">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="nombreRepresentante">Nombre de representante legal</label>
                <input type="text" class="form-control" name="nombreRepresentante" value="<?php echo $proveedor[0]->nombre_representante_legal_pro?>" required readonly>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="telefonoUno">Primer telefono de contacto</label>
                <input type="text" class="form-control" name="telefonoUno" value="<?php echo $proveedor[0]->telefono_1_pro?>" required readonly>
            </div>
            <div class="form-group col-md-6">
                <label for="telefonoDos">Segundo telefono de contacto</label>
                <input type="text" class="form-control" name="telefonoDos" value="<?php echo $proveedor[0]->telefono_2_pro?>" required readonly>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
            <label for="emailUno">Primer E-mail de contacto</label>
            <input type="email" class="form-control" name="emailUno" value="<?php echo $proveedor[0]->email_2_pro?>" required readonly>
            </div>
            <div class="form-group col-md-6">
            <label for="emailDos">Segundo E-mail de contacto</label>
            <input type="email" class="form-control" value="<?php echo $proveedor[0]->email_2_pro?>" required readonly>
            </div>
        </div>                        

    </form>

</div>
          <hr class="mb-4">
          <table class="table colored-header datatable project-list">
            <thead>
                <tr>
                    <th>Orden de Compra</th>
                    <th>Producto</th>
                    <th>Fecha de pedido</th>
                    <th>Cantidad</th>
                    <th>Registrado</th>
                    <th>Precio Unitario</th>
                    <th>Total a pagar + IVA</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php
            if($prod > 0 && $orde > 0):
                foreach ($ordenes as $Proveedores):
                    if($Proveedores->estado == "pagado" || $Proveedores->estado =="aceptado" || $Proveedores->estado =="registrado"):
                    // if($Proveedores->estado=="pagado"):
                        //         echo '</br>';
                        //         echo '------------';
                        //         echo $Proveedores->id_orden_compra;
                        //         echo '</br>';
                        //         $acumulado=($Proveedores->cantidad*$Proveedores->precio_unitario);
                        //         echo '</br>';
                        //         echo 'Total deuda';
                        //         echo $acumulado;
                        //     else:
                        //         $acumulado=0;
                        //     endif;
            ?>
                <tr>
                    <th><?php echo $Proveedores->id_orden_compra?> <a href="ordenesCompra.php?id=<?php echo $Proveedores->id_orden_compra?>">Ver Orden</a></th>
                    <td><?php echo $Proveedores->nombre_pr?></td>
                    <td><?php echo $Proveedores->fecha_pedido?></td>
                    <td><?php echo $Proveedores->cantidad?></td>
                    <?php if($Proveedores->registrado==0):?>
                        <td><span class="text-danger"> No</span></td>
                    <?php else:?>
                        <td><span class="text-success"> Si</span></td>
                    <?php endif;?>
                    <td><?php echo $Proveedores->precio_unitario?></td>
                    <td><?php echo ($Proveedores->cantidad * $Proveedores->precio_unitario)+(($Proveedores->cantidad * $Proveedores->precio_unitario)*0.12)?></td>
                    <?php if($Proveedores->estado=="pagado"):?>
                        <td> <span class="text-success"> <?php echo ucwords($Proveedores->estado)?> </span></td>
                    <?php else:?>
                        <td> <span class="text-danger"> <?php echo 'Aceptado/ Aun No pagado';?> </span></td>
                    <?php endif;?>
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Saldo Pendiente</th>
                    <?php if($Proveedores->estado=="pagado"):?>
                        <td> <span class="text-success"> 0 </span></td>
                    <?php else:?>
                        <td> <span class="text-danger"> <?php echo ($Proveedores->cantidad * $Proveedores->precio_unitario)+(($Proveedores->cantidad * $Proveedores->precio_unitario)*0.12) ;?> </span></td>
                    <?php endif;?>
                    <th></th>
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            <?php 
                    endif;
                endforeach;
            endif;
            ?> 
            </tbody>
        </table>
        
      </div>
    </main>
</div>
<script src="../components/scripts/jquery.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="../components/scripts/dashboard.js"></script> 
     
      </body>
</html>

