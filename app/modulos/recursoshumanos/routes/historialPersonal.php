<?php 
    require '../../../../database.php'; 
    require '../components/layout.php';
        $results = $conn->query("SELECT * FROM empleados WHERE deleted = 1")->fetchAll(PDO::FETCH_OBJ);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/dashboard/">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- Bootstrap core CSS -->
    <link href="../assets/dist/css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../assets/styles/component/dashboard.css" rel="stylesheet">
    <style>
        #busqueda {
                background-image: url('/css/searchicon.png');
                background-position: 10px 12px;
                background-repeat: no-repeat;
                width: 100%;
                font-size: 16px;
                padding: 12px 20px 12px 40px;
                border: 1px solid #ddd;
                margin-bottom: 12px;
            }
    </style>
</head>
<body>
<?php
  printLayout('../index.php', '../../../../index.html', 'contrato.php', 'personal.php', 'reclutamiento.php', 'historialPersonal.php');
?>
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Historial de personal contratado</h1>
            <h5 id="personal" style="display: none"><?php echo $_GET["pers"] ?></h5>
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
    <div class="container mt-4">
      <input type="text" name="busqueda" id="busqueda" placeholder="Search for names.." title="Type in a name">
    </div>
            <div class="container mt-5" >
                <ul class="list-group">
                      <?php
                        foreach ($results as $empleados):?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><?php echo $empleados->id_empleados?></span>
                        <span style="text-decoration: line-through;"><?php echo $empleados->nombres?> <?php echo $empleados->apellidos?></span>
                        <span>
                        <a href="../components/viewEmpleado.php?id=<?php echo $empleados->id_empleados?>" ><i class="fas fa-external-link-alt" style="color:blue;" title="Ver Informacion"></i></a>
                        <a href="../controllers/deleteFisic.php?id=<?php echo $empleados->id_empleados?>" ><i class="fas fa-trash-alt" style="color:red;" title="Eliminar Registro Fisicamente"></i></a>
                        </span>
                        </li>
                      <?php 
                        endforeach;
                      ?>    
                    
                    
                    
                </ul>
            </div>
     </main>
   </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="../assets/dist/js/bootstrap.bundle.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <script src="../components/scripts/dashboard.js"></script>      
  <!-- <script type="text/javascript" src="../components/scripts/jquery.min.js"></script>    
  <script type="text/javascript" src="../components/scripts/searchFilter.js"></script>       -->
  
</body>
</html>