<?php
require '../../../../database.php';
require '../components/layout.php';
require '../../recursoshumanos/components/modal.php';
require '../../seguridad/controllers/functions/credenciales.php';

verificarAcceso("../../../../", "modulo_suministros");
$orden = $conn->query("SELECT * FROM orden_compra WHERE registrado=1")->fetchAll(PDO::FETCH_OBJ);

?>

<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title> Suministro | Ordenes de compra registradas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link href="../assets/styles/dashboard.css" rel="stylesheet">
  </head>
  <body>
<?php
printLayout ('../ico/farma.ico','../index.php', '../../../../index.php','inventario.php','productos.php', 'nuevoProducto.php',
'historialProductos.php','historialOrdenCompra.php','nuevaOrdenCompra.php','listaOrdenesCompra.php','proveedores.php','../../seguridad/controllers/logout.php','../../seguridad/routes/perfil.php',
'../../recursoshumanos/','../index.php','../../contabilidad/','../../citasmedicas/','../../pacientes/','../../seguridad/',6);
?>
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">ORDENES DE COMPRA REGISTRADAS</h1>
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
          <!-- PROJECT TABLE  -->
          <table class="table colored-header datatable project-list">
            <thead>
                <tr>
                    <th style="width:40px;"># Compra</th>
                    <th style="width:110px;">Estado</th>
                    <th style="width:110px;">Fecha de pedido</th>
                    <th style="width:110px;">Fecha de pago</th>
                    <th style="width:110px;">Registrado</th>
                  </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
            <?php
                     foreach ($orden as $ordenDetalle): 
                ?>
         <table class="table colored-header datatable project-list">
              <tbody>
                <tr>
                    <th style="width:150px;"><?php echo $ordenDetalle->id_orden_compra?></th>
                    <td class="font-weight-bold text-success" style="width:200px;"><?php echo strtoupper ( $ordenDetalle->estado)?></td>
                    <td style="width:200px;"><?php echo $ordenDetalle->fecha_pedido?></td>
                    <td style="width:200px;"><?php echo $ordenDetalle->fecha_pago?></td>
                    <td class="font-weight-bold text-success" style="width:110px;">Si</td>
                    <td style="width:100px;">
                        <a href="ordenesCompra.php?id=<?php echo $ordenDetalle->id_orden_compra?>">Ver Orden <i class="fas fa-arrow-right"></i></a>
                        </br>
                      detalle
                      <a class=" ml-2" data-toggle="collapse" href="#collapse<?php echo $ordenDetalle->id_orden_compra?>" role="button" aria-expanded="false" aria-controls="collapse<?php echo $ordenDetalle->id_orden_compra?>">
                      <i class="fas fa-chevron-down"></i>
                      </a>
                    </td>
                </tr>
                </tbody>
            </table>
                      <?php
                        $detalle = $conn->query("SELECT * FROM orden_compra as o, detalle_orden_compra AS de, producto_has_proveedor AS has, proveedores AS pr, productos AS pd WHERE (de.id_orden_compra_dt =o.id_orden_compra AND de.id_prod_has_prov=has.idproducto_has_proveedor AND has.idproveedor_has=pr.idproveedor AND has.idproducto_has=pd.idproducto) AND id_orden_compra=".$ordenDetalle->id_orden_compra)->fetchAll(PDO::FETCH_OBJ);
                      ?>
             <table>
                <tbody>  
                  <tr>
                    <th style="width:1400px;">
                      <div class="collapse mb-2" id="collapse<?php echo $ordenDetalle->id_orden_compra?>">
                        <div class="card card-body">
                        <table class="table colored-header datatable project-list">
                            <thead>
                                <tr>
                                    <th style="width:40px;">Producto</th>
                                    <th style="width:110px;">Proveedor</th>
                                    <th style="width:110px;">Cantidad</th>
                                    <th style="width:110px;">Precio Unitario</th>
                                    <th style="width:110px;">Total Cantidad</th>
                                  </tr>
                            </thead>
                            <tbody>
                          <?php
                            $total = 0 ;
                              foreach ($detalle as $Detalle): 
                                $total+=$Detalle->cantidad*$Detalle->precio_unitario_pr;
                                ?>
                                <tr>
                                  <td><?php echo $Detalle->nombre_pr?></td>
                                  <td><?php echo $Detalle->razon_social_empresa_pro?></td>
                                  <td><?php echo $Detalle->cantidad?></td>
                                  <td><?php echo $Detalle->precio_unitario_pr?></td>
                                  <td><?php echo $total?></td>
                                </tr>
                          <?php 
                              endforeach;
                          ?>
                              </tbody>
                          </table>
                        </div>
                      </div>
                    </th>
                  </tr>
                </tbody>
             </table>
                <?php 
                    endforeach;
                ?>
      </div>
      <p>
</p>
    </main>
</div>
<script src="../components/scripts/jquery.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="../components/scripts/dashboard.js"></script> 
<script src="../components/scripts/consulta.js"></script>    
      </body>
</html>
