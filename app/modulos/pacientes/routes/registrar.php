<?php
require '../components/LayoutAdmin.php';
require '../../../../database.php';
require '../../seguridad/controllers/functions/credenciales.php';

verificarAcceso("../../../../", "modulo_pacientes");
$provincias = $conn->query("SELECT * FROM provincias ORDER BY nombre ASC")->fetchAll(PDO::FETCH_OBJ);
$profesion = $conn->query("SELECT * FROM profesion_paciente ORDER BY profesion ASC")->fetchAll(PDO::FETCH_OBJ);
$seguroPublico = $conn->query("SELECT * FROM seguro_publico ORDER BY descripcion ASC")->fetchAll(PDO::FETCH_OBJ);
$seguroPrivado = $conn->query("SELECT * FROM seguro_privado ORDER BY descripcion ASC")->fetchAll(PDO::FETCH_OBJ);
$discapacidad = $conn->query("SELECT * FROM discapacidades ORDER BY descripcion ASC")->fetchAll(PDO::FETCH_OBJ);
$conn = null;

?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Modulo Pacientes | Registro</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../../recursoshumanos/assets/styles/component/dashboard.css" rel="stylesheet">
  </head>
  <body>
<?php
printLayout ('../index.php', '../../../../index.php', 'registrar.php', '../../citasmedicas/historial_clinico.php','../../citasmedicas/citas.php', 'visualizarPaciente.php', 'pacientesBaja.php', '#','subirArchivo.php',
'../../seguridad/controllers/logout.php','../../seguridad/routes/perfil.php',
  '../../recursoshumanos/','../../suministro/','../../contabilidad/','../../citasmedicas/','../index.php','../../seguridad/',4);
?>
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">REGISTRO DE PACIENTES</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        </div>
      </div>
      <div class="container mt-5">
        <div class="shadow p-3 mb-5 bg-white rounded">
        <form class="p-3" id="form-registro" onsubmit="RegistroSubmit(event)" method="POST" action="../controllers/insertPaciente.php" class="ml-4 mr-4 mb-5">
                <label class="font-weight-bold mt-4">Información personal del paciente</label>
                <hr class="mt-1 mb-4 mr-5">
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="cedula">Número de Cedula</label>
                    <input type="text" class="form-control" name="cedula" onkeypress="return soloNumeros(event)" onchange="verificarCedula(this);" maxlength="10" id="cedula" required>
                    <div class="invalid-feedback">
                        Número de cédula inválida.
                    </div>
                    <div class="valid-feedback">
                      Número de cédula válida.
                    </div>
                  </div>
                    <div class="form-group col-md-2 mt-4 ml-2">
                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" id="ingreso1" name="ingreso" class="custom-control-input" onchange="yesNo(this,'fechaIngreso');" value="si">
                          <label class="custom-control-label" for="ingreso1">Si</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" id="ingreso2" name="ingreso" class="custom-control-input" onchange="yesNo(this,'fechaIngreso');" value="no" checked>
                          <label class="custom-control-label" for="ingreso2">No</label>
                        </div>
                      </div>  
                    <div class="form-group col-md-3">
                      <label for="fechaIngreso">Fecha de Ingreso</label>
                      <input type="date" name="fechaIngreso" id="fechaIngreso" class="form-control" disabled required>
                    </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="name">Nombres</label>
                    <input type="text" class="form-control" onkeypress="return soloLetras(event)" name="name" id="name" required>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="apellidoPaterno">Apellido Paterno</label>
                    <input type="text" class="form-control" onkeypress="return soloLetras(event)" name="apellidoPaterno" id="apellidoPaterno" required>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="apellidoMaterno">Apellido Materno</label>
                    <input type="text" class="form-control" onkeypress="return soloLetras(event)" name="apellidoMaterno" id="apellidoMaterno" required>
                  </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control"  onchange="validarEmail(this);" name="email" id="email" placeholder="ejemplo@gmail.com" required>
                        <div class="invalid-feedback">
                            Correo electrónico inválido.
                        </div>
                        <div class="valid-feedback">
                            Correo electrónico válido.
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="ocupacion">Ocupación</label>
                        <select id="ocupacion" name="ocupacion" class="form-control" required>
                          <option selected disabled value="">Seleccione...</option>
                          <?php
                            foreach ($profesion as $Ocupaciones):
                          ?>
                            <option value="<?php echo $Ocupaciones->idprofesion_paciente;?>"><?php echo utf8_encode($Ocupaciones->profesion);?></option>
                          <?php 
                            endforeach;
                          ?> 
                        </select>
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
                  <div class="form-group col-md-4" id="print-ciudades">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="zona">Zona</label>
                    <input type="text" class="form-control" onkeypress="return soloLetras(event)" id="zona" name="zona" required>
                  </div>
                </div>
                <label class="font-weight-bold">Información de ubicación</label>
                <hr class="mt-1 mb-4 mr-5">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="direccionDomicilio">Dirección del domicilio</label>
                        <input type="text" class="form-control" id="direccionDomicilio" name="direccionDomicilio" required>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="telefonoDomicilio">Telefono</label>
                      <input type="text" class="form-control"  onchange="validarTelefono(this);" onkeypress="return soloNumeros(event)" maxlength="7" id="telefonoDomicilio" name="telefonoDomicilio" required>
                      <div class="invalid-feedback">
                        Número fijo inválido. </br>
                        ¡Debe ser un número teléfonico, tiene que tener 7 dígitos!
                      </div>
                      <div class="valid-feedback">
                        Número fijo válido.
                      </div>
                  </div>
                  <div class="form-group col-md-3">
                      <label for="celularDomicilio">Celular</label>
                      <input type="text" class="form-control"  onchange="validarCelular(this);" onkeypress="return soloNumeros(event)" maxlength="10" id="celularDomicilio" name="celularDomicilio" required>
                      <div class="invalid-feedback">
                          Número celular inválido.</br>
                          ¡El celular debe comenzar en 0, y contener 10 dígitos!
                      </div>
                      <div class="valid-feedback">
                        Número celular válido.
                      </div>
                  </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-9">
                        <label for="direccionTrabajo">Dirección del lugar de trabajo</label>
                        <input type="text" class="form-control" id="direccionTrabajo" name="direccionTrabajo" required>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="telefonoTrabajo">Telefono</label>
                      <input type="text" class="form-control"  onchange="validarTelefono(this);" onkeypress="return soloNumeros(event)" maxlength="7" id="telefonoTrabajo" name="telefonoTrabajo" required>
                      <div class="invalid-feedback">
                        Número fijo inválido. </br>
                        ¡Debe ser un número teléfonico, tiene que tener 7 dígitos!
                      </div>
                      <div class="valid-feedback">
                        Número fijo válido.
                      </div>
                  </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-9">
                        <label for="direccionAtencion">Dirección de atención medica</label>
                        <input type="text" class="form-control" id="direccionAtencion" name="direccionAtencion" required>
                    </div>
                  <div class="form-group col-md-3">
                      <label for="telefonoAtencion">Telefono</label>
                      <input type="text" class="form-control"  onchange="validarTelefono(this);" onkeypress="return soloNumeros(event)" maxlength="7" id="telefonoAtencion" name="telefonoAtencion" required>
                      <div class="invalid-feedback">
                        Número fijo inválido. </br>
                        ¡Debe ser un número teléfonico, tiene que tener 7 dígitos!
                      </div>
                      <div class="valid-feedback">
                        Número fijo válido.
                      </div>
                  </div>
                </div>
                <hr class="mt-1 mb-4 mr-5">
                <label class="font-weight-bold">¿Posee Afiliación?</label>
                <div class="form-row">
                    <div class="form-group col-md-4 mt-4 ml-2">
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="afiliado1" name="afiliado" class="custom-control-input" onchange="esAfiliado(this,'afiliaciones');" value="si">
                        <label class="custom-control-label" for="afiliado1">Si</label>
                      </div>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="adiliado2" name="afiliado" class="custom-control-input" onchange="esAfiliado(this,'afiliaciones');" value="no" checked>
                        <label class="custom-control-label" for="adiliado2">No</label>
                      </div>
                    </div>                  
                </div>
                <div id="afiliaciones" style="display:none;">
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <div class="form-check form-check-inline mr-5 mt-4">
                        <input class="form-check-input" type="checkbox" id="publica" value="publica" onchange="afiliacion(this,'afiliacionPublica');">
                        <label class="form-check-label" for="publica">Afiliación Pública</label>
                      </div>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="afiliacionPublica">Afiliación Pública</label>
                      <select id="afiliacionPublica" name="afiliacionPublica" class="form-control" disabled required>
                        <option selected disabled value="">Seleccione...</option>
                        <?php
                          foreach ($seguroPublico as $ListaPublico):
                            ?>
                          <option value="<?php echo $ListaPublico->idseguro_publico;?>"><?php echo utf8_encode($ListaPublico->descripcion);?></option>
                        <?php 
                          endforeach;
                        ?> 
                      </select>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <div class="form-check form-check-inline mt-4">
                        <input class="form-check-input" type="checkbox" id="privada" value="privada" onchange="afiliacion(this,'afiliacionPrivada');">
                        <label class="form-check-label" for="privada">Afiliación Privada</label>
                      </div>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="afiliacionPrivada">Afiliación Privada</label>
                      <select id="afiliacionPrivada" name="afiliacionPrivada" class="form-control" disabled required>
                        <option selected disabled value="">Seleccione...</option>
                        <?php
                          foreach ($seguroPrivado as $ListaPrivado):
                            ?>
                          <option value="<?php echo $ListaPrivado->idseguro_privado;?>"><?php echo utf8_encode($ListaPrivado->descripcion);?></option>
                        <?php 
                          endforeach;
                          ?> 
                      </select>
                    </div>
                  </div>      
                </div>
                <hr class="mt-1 mb-4 mr-5">
                <label class="font-weight-bold">¿Posee alguna discapacidad?</label>
                <div class="form-row">
                    <div class="form-group col-md-4 mt-2 ml-2">
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="discapacidad1" name="poseeDiscapacidad" class="custom-control-input" onchange="esDiscapacitado(this,'carnetConadis', 'discapacidad', 'grado')" value="si">
                        <label class="custom-control-label" for="discapacidad1">Si</label>
                      </div>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="discapacidad2" name="poseeDiscapacidad" class="custom-control-input" onchange="esDiscapacitado(this,'carnetConadis', 'discapacidad', 'grado')" value="no" checked>
                        <label class="custom-control-label" for="discapacidad2">No</label>
                      </div>
                    </div>                  
                </div>      
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="carnetConadis">Carnet Conadis</label>
                        <input type="text" class="form-control" id="carnetConadis" name="carnetConadis" required disabled="true">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="discapacidad">Discapacidad</label>
                        <!-- <input type="text" class="form-control" onkeypress="return soloLetras(event)" id="discapacidad" name="discapacidad" required disabled="true"> -->
                        <select id="discapacidad" name="discapacidad" class="form-control" disabled required>
                        <option selected disabled value="">Seleccione...</option>
                        <?php
                          foreach ($discapacidad as $Discapacidad):
                            ?>
                          <option value="<?php echo $Discapacidad->iddiscapacidad;?>"><?php echo utf8_encode($Discapacidad->descripcion);?></option>
                        <?php 
                          endforeach;
                          ?> 
                      </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="grado">Grado %</label>
                        <select id="grado" name="grado" class="form-control" required disabled="true">
                        <option selected disabled value="">Seleccione...</option>
                          <option value="10">10%</option>
                          <option value="15">15%</option>
                          <option value="20">20%</option>
                          <option value="40">40%</option>
                          <option value="50">50%</option>
                          <option value="80">80%</option>
                      </select>
                    </div>
                 </div>
                 <div class="d-flex justify-content-end mt-5">
                    <a href="../../../../" class="text-secondary mr-5 mt-2">Cancelar</a>
                    <button class="btn btn-primary font-weight-bold" style="width:300px;" type="submit">Registrar</button>
                 </div>
              </form>
        </div>
      </div>
    </main>
  </div>
</div>
<div class='modal fade' name='modal-success' id='modal-success' data-backdrop='static' data-keyboard='false' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabe' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='staticBackdropLabel'>REGISTRO SATISFACTORIO</h5>
                  
                </div>
                <div class='modal-body mb-5'>
                    <div class="container d-flex flex-column" style="width:100%;">
                        <div id="icon-message" class="container d-flex justify-content-center align-items-center mb-5 mt-4" style="width:100%;">
                            <!-- ICONO -->
                        </div>
                        <div class="container d-flex justify-content-center align-items-center" style="width:100%;">                            
                            <div id="message">
                                <!-- MESSAGE -->
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>     
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="../../recursoshumanos/components/scripts/dashboard.js"></script>          
<script src="../../seguridad/controllers/validations/validations.js"></script>
<script src="../../seguridad/components/scripts/ciudad.js"></script>
<script src="../components/scripts/paciente.js"></script>
</body>
</html>
