<?php
require '../../../../database.php';
require '../components/layout.php';
require '../../recursoshumanos/components/modal.php';
require '../controllers/functions/credenciales.php';

verificarAcceso("../../../../", "modulo_seguridad");

$auditoria = $conn->query("SELECT * FROM auditoria ORDER BY created_at DESC")->fetchAll(PDO::FETCH_OBJ);

?>

<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title> Seguridad | Auditoria</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link href="../assets/styles/dashboard.css" rel="stylesheet">
  </head>
  <body>
<?php
printLayout('../index.php', '../../../../index.php', 'credencial.php', 'scopes.php', 'usuarios.php', 'cargos.php', 'auditoria.php', '../controllers/logout.php',
'perfil.php','../../recursoshumanos/','../../suministro/','../../contabilidad/','../../citasmedicas/','../../pacientes/','../../seguridad/',6);
?>
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">AUDITORIA</h1>
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
                    <th style="width:40px;">Acción</th>
                    <th style="width:80px;">Modulo</th>
                    <th style="width:160px;">Descripcion</th>
                    <th style="width:40px;">Usuario</th>
                    <th style="width:40px;">Credencial</th>
                    <th style="width:80px;">Fecha</th>
                  </tr>
            </thead>
            <tbody>
            <?php foreach($auditoria as $Auditorias):
                    $user = $conn->query("SELECT * FROM empleados WHERE id_usuario_emp=".$Auditorias->usuario)->fetchAll(PDO::FETCH_OBJ);
              ?>
                <tr>
                    <td><?php echo utf8_encode($Auditorias->accion);?></td>
                    <td><?php echo utf8_encode($Auditorias->modulo);?></td>
                    <td><?php echo utf8_encode($Auditorias->descripcion);?></td>
                    <td><?php echo utf8_encode($user[0]->nombres." ".$user[0]->apellidos);?></td>
                    <td><?php echo utf8_encode($Auditorias->credencial);?></td>
                    <td><?php echo utf8_encode($Auditorias->created_at);?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
         <table class="table colored-header datatable project-list">
              <tbody>
                    <th style="width:150px;"></th>
                    <td style="width:200px;"><i class="far fa-question-circle text-info" style="font-size:15px; cursor:pointer;" title="Esta Orden se encuentra en revision por el departamento de contabilidad"></i></td>         
                    <td style="width:200px;"></td>
                    <td style="width:200px;"></td>
                        <td style="width:110px;">No</td>
                    <td style="width:100px;">
                        <a href="ordenesCompra.php?id=">Ver Orden <i class="fas fa-arrow-right"></i></a>
                        </br>
                      detalle
                      <a class=" ml-2" data-toggle="collapse" href="#collapse" role="button" aria-expanded="false" aria-controls="collapse">
                      <i class="fas fa-chevron-down"></i>
                      </a>
                    </td>
                </tr>
                </tbody>
            </table>

             <table>
                <tbody>  
                  <tr>
                    <th style="width:1400px;">
                      <div class="collapse mb-2" id="collapse">
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
                
                                <tr>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                </tr>
              
                              </tbody>
                          </table>
                        </div>
                      </div>
                    </th>
                  </tr>
                </tbody>
             </table>
      </div>
      <p>
</p>
    </main>
      <div class='modal fade' name='modal-registrar' id='modal-registrar' data-backdrop='static' data-keyboard='false' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabe' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='staticBackdropLabel'>Registrar Producto</h5>
                    <button type='button' id='close-update' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                    ¡Hey!. ¿Estas seguro de eliminar este articulo de tu ORDEN DE COMPRA?.
                </div>
                <div class='modal-footer mt-2'>
                    <button id="btn-cancelar" type='button' class="btn btn-light border-secondary" data-dismiss='modal'>Cancelar</button>
                    <button id='btn-registrar' class='btn btn-primary font-weight-bold' style="width:200px;">Si, de acuerdo</button>
                </div> 
            </div>
        </div>
    </div>
</div>
<script src="../components/scripts/jquery.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="../components/scripts/dashboard.js"></script> 
<script src="../components/scripts/consulta.js"></script>    
</body>
</html>