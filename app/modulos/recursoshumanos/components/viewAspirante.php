<?php
    require '../../../../database.php';
    require 'layout.php';
    $id = $_GET['id'];    

            $records = $conn->prepare("SELECT * FROM aspirante WHERE cedula = :cedula");
            $records->bindParam(':cedula', $id);
            $records->execute();
            $results = $records->fetch(PDO::FETCH_ASSOC);
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aspirante | Información</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/dashboard/">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- Bootstrap core CSS -->
    <link href="../assets/dist/css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../assets/styles/component/dashboard.css" rel="stylesheet">
</head>
<body>
<?php
  
  printLayout('../index.php', '../../../../index.html', '../routes/contrato.php', '../routes/selectPersonal.php', '../routes/reclutamiento.php', '../routes/historialPersonal.php');
?>
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Información del Aspirante</h1>
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
    <div class="container">
      <input type="button" class="btn btn-secondary" onclick="location.href='../routes/reclutamiento.php';" value="<-- REGRESA" title="Volver a Historial del Personal"/>
    </div>
        <div class="container mb-5 shadow-sm p-3 bg-white rounded">
                <label class="font-weight-bolder">Datos Personales</label>
                <hr class="mt-1 mb-4 mr-5 ">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                    <label for="validationServer01">Numero de cedula</label>
                    <input type="text" name="cedula" class="form-control"  value="<?php echo $results["cedula"] ?>" disabled="">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                    <label for="validationServer01">Nombres</label>
                    <input type="text" name="nombres" class="form-control"  value="<?php echo $results["nombres"] ?>" disabled="">
                    </div>
                    <div class="col-md-6 mb-3">
                    <label for="validationServer02">Apellidos</label>
                    <input type="text" name="apellidos" class="form-control"  value="<?php echo $results["apellidos"] ?>" disabled="">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationServer01">Dirección</label>
                        <input type="text" name="nombres" class="form-control"  value="<?php echo $results["direccion"] ?>" disabled="">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="validationServer02">Nacionalidad</label>
                        <input type="text" name="apellidos" class="form-control"  value="<?php echo $results["nacionalidad"] ?>" disabled="">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="validationServer02">Fecha de nacimiento</label>
                        <input type="text" name="apellidos" class="form-control"  value="<?php echo $results["fechaNacimiento"] ?>" disabled="">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationServer02">Ciudad</label>
                        <input type="text" name="apellidos" class="form-control"  value="<?php echo $results["ciudad"] ?>" disabled="">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationServer02">Telefono fijo</label>
                        <input type="text" name="apellidos" class="form-control"  value="<?php echo $results["telefono"] ?>" disabled="">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <label for="validationServer02">Telefono celular</label>
                        <input type="text" name="apellidos" class="form-control"  value="<?php echo $results["celular"]?>" disabled="">
                    </div>
                    <div class="col-md-5 mb-3">
                        <label for="validationServer02">Correo electronico</label>
                        <input type="text" name="apellidos" class="form-control"  value="<?php echo $results["email"] ?>" disabled="">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="validationServer02">Sexo</label>
                        <input type="text" name="apellidos" class="form-control"  value="<?php echo $results["sexo"] ?>" disabled="">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="validationServer02">Estado Civil</label>
                        <input type="text" name="apellidos" class="form-control"  value="<?php echo $results["estadoCivil"] ?>" disabled="">
                    </div>
                </div>
                <label class="font-weight-bolder mt-3">Antecedentes acádemicos y profesionales</label>
                <hr class="mt-1 mb-4 mr-5">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationServer01">Titulo / Profesión</label>
                        <input type="text" name="nombres" class="form-control" value="<?php echo $results["titulo"]?>" disabled="">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationServer02">Institución</label>
                        <input type="text" name="apellidos" class="form-control"  value="<?php echo $results["institucion"]?>" disabled="">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationServer02">Año de ingreso</label>
                        <input type="text" name="apellidos" class="form-control" value="<?php echo $results["anoIngreso"]?>" disabled="">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationServer02">Año de Egreso</label>
                        <input type="text" name="apellidos" class="form-control" value="<?php echo $results["anoEgreso"]?>" disabled="">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationServer01">Titulo / Profesión</label>
                        <input type="text" name="nombres" class="form-control" value="<?php echo $results["titulo2"]?>" disabled="">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationServer02">Institución</label>
                        <input type="text" name="apellidos" class="form-control"  value="<?php echo $results["institucion2"]?>" disabled="">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationServer02">Año de ingreso</label>
                        <input type="text" name="apellidos" class="form-control" value="<?php echo $results["anoIngreso2"]?>" disabled="">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationServer02">Año de Egreso</label>
                        <input type="text" name="apellidos" class="form-control" value="<?php echo $results["anoEgreso2"]?>" disabled="">
                    </div>
                </div>
                <label class="font-weight-bolder mt-3">Información ocupacional</label>
                <hr class="mt-1 mb-4 mr-5">
                <div class="form-row">
                    <div class="col-md-2 mb-3">
                        <label for="validationServer02">Fecha de envio del formulario</label>
                        <input type="text" name="apellidos" class="form-control" value="<?php echo $results["created_at"]?>" disabled="">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="validationServer02">Especialidad</label>
                        <input type="text" name="apellidos" class="form-control" value="<?php echo $results["especialidad"]?>" disabled="">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="validationServer02">Especialidad 2</label>
                        <input type="text" name="apellidos" class="form-control" value="<?php echo $results["especialidad2"]?>" disabled="">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="validationServer02">Especialidad 3</label>
                        <input type="text" name="apellidos" class="form-control" value="<?php echo $results["especialidad3"]?>" value="php echo $results" disabled="">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <label for="validationServer02">Años de experiencia</label>
                        <input type="text" name="apellidos" class="form-control" value="<?php echo $results["anosExperiencia"]?>" disabled="">
                    </div>
                    <div class="col-md-5 mb-3">
                        <label for="validationServer02">Área pretendida</label>
                        <input type="text" name="apellidos" class="form-control" value="<?php echo $results["areaPretendida"]?>" disabled="">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="validationServer02">Horario Pretendido</label>
                        <input type="text" name="apellidos" class="form-control" value="<?php echo $results["horarioPretendido"]?>" disabled="">
                    </div>
                </div>
                <label class="font-weight-bolder mt-3">Descripcion del perfil del aspirante</label>
                <hr class="mt-1 mb-4 mr-5 ">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                    <textarea name="documentosDescription" class="form-control" id="lugar" rows="3" disabled=""><?php echo $results["descriptionPerfil"]?></textarea>
                    </div>        
                </div>   
            </div> 
            <hr class="mt-2 mb-3">
            </div>
     </main>
   </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="../assets/dist/js/bootstrap.bundle.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <script src="scripts/dashboard.js"></script>      
  
</body>
</html>