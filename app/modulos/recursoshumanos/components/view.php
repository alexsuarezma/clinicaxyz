<?php
    require '../../../../database.php';
    require 'layout.php';
    $id = $_GET['id'];    
            $records = $conn->prepare("SELECT * FROM empleados WHERE cedula = :cedula");
            $records->bindParam(':cedula', $id);
            $records->execute();
            $results = $records->fetch(PDO::FETCH_ASSOC);
    
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
</head>
<body>
<?php
  
  printLayout('../index.php', '../../../../index.html', 'contrato.php', 'selectPersonal.php', 'reclutamiento.php', 'historialPersonal.php');
?>
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Información del personal</h1>
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
      <input type="button" class="btn btn-secondary" onclick="location.href='../routes/historialPersonal.php';" value="<-- REGRESA" title="Volver a Historial del Personal"/>
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
                        <label for="validationServer01">Distrito</label>
                        <input type="text" name="nombres" class="form-control" value="<?php echo $results["distrito"]?>" disabled="">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="validationServer02">Ciudad</label>
                        <input type="text" name="apellidos" class="form-control"  value="<?php echo $results["ciudad"] ?>" disabled="">
                    </div>
                    <div class="col-md-3 mb-3">
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
                        <input type="text" name="apellidos" class="form-control" value="<?php echo $results["fechaIngresoInsti"]?>" disabled="">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationServer02">Año de Egreso</label>
                        <input type="text" name="apellidos" class="form-control" value="<?php echo $results["fechaEgresoInsti"]?>" disabled="">
                    </div>
                </div>
                <label class="font-weight-bolder mt-3">Información ocupacional</label>
                <hr class="mt-1 mb-4 mr-5">
                <div class="form-row">
                    <div class="col-md-2 mb-3">
                        <label for="validationServer02">Fecha Ingreso</label>
                        <input type="text" name="apellidos" class="form-control" value="<?php echo $results["created_at"]?>" disabled="">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="validationServer02">Salario Base</label>
                        <input type="text" name="apellidos" class="form-control" value="<?php echo $results["salarioBase"]?>" disabled="">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="validationServer02">Contrato</label>
                        <input type="text" name="apellidos" class="form-control" value="<?php echo $results["idcontrato"]?>" disabled="">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="validationServer02">Especialidad</label>
                        <input type="text" name="apellidos" class="form-control" value="<?php echo $results["especialidad"]?>" value="php echo $results" disabled="">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <label for="validationServer02">Cargo</label>
                        <input type="text" name="apellidos" class="form-control" value="<?php echo $results["cargo"]?>" disabled="">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="validationServer02">Personal</label>
                        <input type="text" name="apellidos" class="form-control" value="<?php echo $results["personal"]?>" disabled="">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="validationServer02">Área</label>
                        <input type="text" name="apellidos" class="form-control" value="<?php echo $results["area"]?>" disabled="">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="validationServer02">Horario</label>
                        <input type="text" name="apellidos" class="form-control" value="<?php echo $results["idhorario"]?>" disabled="">
                    </div>
                </div>
                <label class="font-weight-bolder mt-3">Contactos para casos de emergencia</label>
                <hr class="mt-1 mb-4 mr-5">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationServer01">Nombres y Apellidos</label>
                        <input type="text" name="nombres" class="form-control" value="<?php echo $results["nombresContactoEmerg"]?>" disabled="">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="validationServer02">Telf. Fijo</label>
                        <input type="text" name="apellidos" class="form-control" value="<?php echo $results["telefonoContactoEmerg"]?>" disabled="">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="validationServer02">Celular </label>
                        <input type="text" name="apellidos" class="form-control" value="<?php echo $results["celularContactoEmerg"]?>" disabled="">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationServer01">Nombres y Apellidos</label>
                        <input type="text" name="nombres" class="form-control" value="<?php echo $results["nombresContactoEmerg2"]?>" disabled="">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="validationServer02">Telf. Fijo</label>
                        <input type="text" name="apellidos" class="form-control" value="<?php echo $results["telefonoContactoEmerg"]?>" disabled="">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="validationServer02">Celular </label>
                        <input type="text" name="apellidos" class="form-control" value="<?php echo $results["celularContactoEmerg"]?>" disabled="">
                    </div>
                </div>
                <label class="font-weight-bolder mt-3">Informacion de hijos </label>
                <hr class="mt-1 mb-4 mr-5 ">
                <div id="radio-hijos" class="form-group shadow-sm p-3 bg-white rounded">
                            <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="validationServer04">Nombres</label>
                                <input type="text" name="nombreHijo" value="<?php echo $results["nombreHijo"]?>"  class="form-control" disabled="">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationServer04">Apellidos</label>
                                <input type="text" name="apellidoHijo" class="form-control" value="<?php echo $results["apellidoHijo"]?>" disabled="">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="validationServer04">Años</label>
                                <input type="text" name="anosHijo" class="form-control" value="<?php echo $results["anosHijo"]?>"  disabled="">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="validationServer04">Meses</label>
                                <input type="text" name="mesesHijo" class="form-control" value="<?php echo $results["mesesHijo"]?>" disabled="">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="validationServer04">Nombres</label>
                                <input type="text" name="nombreHijo2" class="form-control" value="<?php echo $results["nombreHijo2"]?>" disabled="">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationServer04">Apellidos</label>
                                <input type="text" name="apellidoHijo2" class="form-control" value="<?php echo $results["apellidoHijo2"]?>" disabled="">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="validationServer04">Años</label>
                                <input type="text" name="anosHijo2" class="form-control" value="<?php echo $results["anosHijo2"]?>" disabled="">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="validationServer04">Meses</label>
                                <input type="text" name="mesesHijo2" class="form-control" value="<?php echo $results["mesesHijo2"]?>" disabled="">
                            </div>
                        </div>
                        <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationServer04">Nombres</label>
                            <input type="text" name="nombreHijo3" class="form-control" value="<?php echo $results["nombreHijo3"]?>" disabled="">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationServer04">Apellidos</label>
                            <input type="text" name="apellidoHijo3" class="form-control" value="<?php echo $results["apellidoHijo3"]?>" disabled="">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="validationServer04">Años</label>
                            <input type="text" name="anosHijo3" class="form-control" value="<?php echo $results["anosHijo3"]?>" disabled="">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="validationServer04">Meses</label>
                            <input type="text" name="mesesHijo3" class="form-control" value="<?php echo $results["mesesHijo3"]?>" disabled="">
                        </div>
                        </div>
                    </div> 
                <label class="font-weight-bolder mt-3">Descripcion de documentos que adjuntar</label>
                <hr class="mt-1 mb-4 mr-5 ">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                    <textarea name="documentosDescription" class="form-control" id="lugar" rows="3" disabled=""><?php echo $results["documentosDescription"]?></textarea>
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