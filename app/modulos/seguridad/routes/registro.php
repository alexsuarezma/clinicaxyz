<?php
require '../../../../database.php';

$message = '';

$ciudades = $conn->query("SELECT * FROM ciudades ORDER BY nombre ASC")->fetchAll(PDO::FETCH_OBJ);
$provincias = $conn->query("SELECT * FROM provincias ORDER BY nombre ASC")->fetchAll(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
	<title>Registrarse</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/sign-in/">
    
    <link href="../assets/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- <link href="../assets/styles/component/signin.css" rel="stylesheet"> -->
<style>
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    
    </style>
</head>
<body>
 
  <div class="container mt-5 mb-5">
        <div class="shadow-none p-3 mb-5 bg-light rounded">
        <h2 class="mt-5 mb-5" style="text-align:center;">Registrate</h2>
            <form id="form" onsubmit="onSubmit(event)" method="POST" action="../controllers/crearPaciente.php" class="ml-4 mr-4 mb-5">
                <label class="font-weight-bold">Información de la cuenta de usuario</label>
                <hr class="mt-1 mb-4 mr-5">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="username">Nombre de usuario</label>
                        <input type="text" class="form-control" name="username" id="username" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="repeatPassword">Repetir contraseña</label>
                        <input type="password" class="form-control" name="repeatPassword" id="repeatPassword" required>
                    </div>
                </div>
                <label class="font-weight-bold mt-4">Información personal del paciente</label>
                <hr class="mt-1 mb-4 mr-5">
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="cedula">Cedula/Pasaporte</label>
                    <input type="text" class="form-control" name="cedula" id="cedula" maxlength="10" required>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="name">Nombres</label>
                    <input type="text" class="form-control" name="name" id="name" required>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="apellidoPaterno">Apellido Paterno</label>
                    <input type="text" class="form-control" name="apellidoPaterno" id="apellidoPaterno" required>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="apellidoMaterno">Apellido Materno</label>
                    <input type="text" class="form-control" name="apellidoMaterno" id="apellidoMaterno" required>
                  </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="ejemplo@gmail.com" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="ocupacion">Ocupación</label>
                        <input type="text" class="form-control" name="ocupacion" id="ocupacion" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="fechaNacimiento">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" name="fechaNacimiento" id="fechaNacimiento" required>
                    </div>
                    <div class="form-group col-md-4">
                    <label class="font-weight-bold">Sexo</label>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="sexo1" name="sexo" class="custom-control-input" value="Varón" checked>
                            <label class="custom-control-label" for="sexo1">Varón</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="sexo2" name="sexo" class="custom-control-input" value="Mujer">
                            <label class="custom-control-label" for="sexo2">Mujer</label>
                        </div>                
                        <div class="custom-control custom-radio">
                            <input type="radio" id="sexo3" name="sexo" class="custom-control-input" value="Indefinido">
                            <label class="custom-control-label" for="sexo3">Indefinido</label>
                        </div>
                    </div>              
                </div>
                <div class="form-row mb-3">
                  <div class="form-group col-md-4">
                    <label for="provincia">Provincia</label>
                    <select id="provincia" name="provincia" class="form-control" required>
                      <option selected disabled value="">Seleccione...</option>
                      <?php
                        foreach ($provincias as $provinciasPaciente):
                      ?>
                        <option value="<?php echo $provinciasPaciente->idprovincias;?>"><?php echo utf8_encode($provinciasPaciente->nombre);?></option>
                      <?php 
                        endforeach;
                      ?> 
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="ciudad">Ciudad</label>
                    <select id="ciudad" name="ciudad" class="form-control" required>
                      <option selected disabled value="">Seleccione...</option>
                      <?php
                        foreach ($ciudades as $ciudadesPaciente):
                      ?>
                        <option value="<?php echo $ciudadesPaciente->idciudades;?>"><?php echo utf8_encode($ciudadesPaciente->nombre);?></option>
                      <?php 
                        endforeach;
                      ?> 
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="zona">Zona</label>
                    <input type="text" class="form-control" id="zona" name="zona" required>
                    <!-- <select id="zona" name="zona" class="form-control" required>
                      <option selected disabled value="">Seleccione...</option>
                      <option value=""></option>
                    </select> -->
                  </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="direccion">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="telefono">Telefono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" maxlength="7" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="celular">Celular</label>
                        <input type="text" class="form-control" id="celular" name="celular" maxlength="10" required>
                    </div>
                 </div>
          
                <hr class="mt-1 mb-4 mr-5">
                <label class="font-weight-bold">¿Está Afiliado?</label>
                <div class="form-row">
                    <div class="form-group col-md-4 mt-4 ml-2">
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="afiliado1" name="afiliado" class="custom-control-input" onchange="esAfiliado(this,'tipoAfiliacion');" value="si">
                        <label class="custom-control-label" for="afiliado1">Si</label>
                      </div>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="adiliado2" name="afiliado" class="custom-control-input" onchange="esAfiliado(this,'tipoAfiliacion');" value="no" checked>
                        <label class="custom-control-label" for="adiliado2">No</label>
                      </div>
                    </div>                  
                    <div class="form-group col-md-4">
                        <label for="tipoAfiliacion">Tipo Afiliación</label>
                        <input class="form-control" id="tipoAfiliacion" name="tipoAfiliacion" required disabled="true">
                    </div>
                </div>      
                <hr class="mt-1 mb-4 mr-5">
                <label class="font-weight-bold">¿Posee alguna discapacidad?</label>
                <div class="form-row">
                    <div class="form-group col-md-4 mt-2 ml-2">
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="discapacidad1" name="discapacidad" class="custom-control-input" onchange="esDiscapacitado(this,'carnetConadis', 'discapacidad', 'grado')" value="si">
                        <label class="custom-control-label" for="discapacidad1">Si</label>
                      </div>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="discapacidad2" name="discapacidad" class="custom-control-input" onchange="esDiscapacitado(this,'carnetConadis', 'discapacidad', 'grado')" value="no" checked>
                        <label class="custom-control-label" for="discapacidad2">No</label>
                      </div>
                    </div>                  
                </div>      
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="carnetConadis">Carnet Conadis</label>
                        <input class="form-control" id="carnetConadis" name="carnetConadis" required disabled="true">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="discapacidad">Discapacidad</label>
                        <input class="form-control" id="discapacidad" name="discapacidad" required disabled="true">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="grado">Grado %</label>
                        <input class="form-control" id="grado" name="grado" required disabled="true">
                    </div>
                 </div>
                 <div class="d-flex justify-content-end mt-5">
                    <a href="../../../../" class="text-secondary mr-5 mt-2">Cancelar</a>
                    <button type="button" onclick="onClick();" class="btn btn-light border-secondary mr-5">Restablecer</button>
                    <button class="btn btn-primary font-weight-bold" style="width:300px;" type="submit">Registrarme</button>
                 </div>
              </form>
            </div>
    </div>
    
    <div id="borrado" role="alert" aria-live="assertive" aria-atomic="true" class="toast" data-autohide="true" style="position: absolute; top: 0; right: 0;" data-delay="2000">
        <div class="toast-header bg-info text-white">
          
          <i class="fas fa-info-circle mr-2"></i>
          <strong class="mr-auto">INFORMACIÓN</strong>
          <small>Hace 2 segundos</small>
          <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="toast-body">
          Su formulario ha sido borrado, porfavor vuelva a llenarlo.
        </div>
    </div>

    <div id="alert" role="alert" aria-live="assertive" aria-atomic="true" class="toast" data-autohide="true" style="position: absolute; top: 0; right: 0;" data-delay="4000">
        <div class="toast-header bg-danger text-white">
          <i class="fas fa-exclamation-circle mr-2"></i>
          <strong class="mr-auto">¡ERROR!</strong>
          <small>Hace 2 segundos</small>
          <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="toast-body">
            Las contraseñas no coinciden, porfavor escribelas de nuevo.
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script> 
<script src="../controllers/validations/validations.js"></script>
</body>
</html>