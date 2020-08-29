<?php
require '../components/LayoutAdmin.php';
require '../../../../database.php';
require '../../recursoshumanos/components/modal.php';
require '../../seguridad/controllers/functions/credenciales.php';

verificarAcceso("../../../../", "modulo_pacientes");
    $_SESSION['cedula'] = $_GET['cedula'];
    $afiliacionPublica= '';
    $afiliacionPrivada= '';
    $carnetConadis = '';
    $consulta = $conn->prepare("SELECT * FROM pacientes AS p, profesion_paciente AS pp, ciudades AS c WHERE (p.ocupacion_paciente=pp.idprofesion_paciente AND p.ciudad=c.idciudades) AND idpacientes = :idpacientes");
    $consulta->bindParam(':idpacientes', $_GET['cedula']);
    $consulta->execute();
    $resultado = $consulta->fetch(PDO::FETCH_ASSOC); 

    if($resultado['afiliacion_publica']!= null){
      $afiliacionPublica = $conn->query("SELECT * FROM seguro_publico WHERE idseguro_publico=".$resultado['afiliacion_publica'])->fetchAll(PDO::FETCH_OBJ);
    }
    
    if($resultado['afiliacion_privada']!= null){
      $afiliacionPrivada = $conn->query("SELECT * FROM seguro_privado WHERE idseguro_privado=".$resultado['afiliacion_privada'])->fetchAll(PDO::FETCH_OBJ);
    }
    
    $carnetConadis =  $conn->query("SELECT * FROM conadis AS c, discapacidades AS d WHERE (c.discapacidad=d.iddiscapacidad) AND paciente='".$resultado['idpacientes']."'")->fetchAll(PDO::FETCH_OBJ);
    
    if(!$carnetConadis){
      $carnetConadis = '';
    }
  
    $direccion = $conn->query("SELECT * FROM direccion_paciente WHERE id_pacientes_de=".$resultado['idpacientes']." ORDER BY tipo ASC")->fetchAll(PDO::FETCH_OBJ);
  
    $profesion = $conn->query("SELECT * FROM profesion_paciente ORDER BY profesion ASC")->fetchAll(PDO::FETCH_OBJ);
    $seguroPublico = $conn->query("SELECT * FROM seguro_publico ORDER BY descripcion ASC")->fetchAll(PDO::FETCH_OBJ);
    $seguroPrivado = $conn->query("SELECT * FROM seguro_privado ORDER BY descripcion ASC")->fetchAll(PDO::FETCH_OBJ);
    $discapacidad = $conn->query("SELECT * FROM discapacidades ORDER BY descripcion ASC")->fetchAll(PDO::FETCH_OBJ);
    $provincias = $conn->query("SELECT * FROM provincias ORDER BY nombre ASC")->fetchAll(PDO::FETCH_OBJ);
    $ciudades = $conn->query("SELECT * FROM ciudades ORDER BY nombre ASC")->fetchAll(PDO::FETCH_OBJ);
  


?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Modulo Pacientes | Home</title>
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
        <h1 class="h2">PERFIL DEL PACIENTE</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        </div>
      </div>
      <div class="container mt-5 mb-5">
      <div class="d-flex justify-content-end">
      <?php if($resultado['deleted'] == 0): ?>
        <button class="btn btn-outline-danger" style="width:200px;" data-toggle="modal" data-target="#modal-delete">Dar de baja al Paciente</button>
      <?php else:?>
        <button class="btn btn-outline-danger" style="width:300px;" data-toggle="modal" data-target="#modal-ingresar">Volver a ingresar al Paciente</button>
      <?php endif;?>
      </div>
        <form method="POST" id="form" onsubmit="AcualizarSubmit(event)" action="../../seguridad/controllers/actualizarPaciente.php" class="ml-4 mr-4 mb-5">
                
                <label class="font-weight-bold mt-4">Información personal del paciente</label>
                <hr class="mt-1 mb-4 mr-5">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="cedula">Cedula/Pasaporte</label>
                        <input type="hidden" name="deleted" id="deleted" value="<?php echo $resultado['deleted'] ?>">
                        <input type="hidden" name="type" value="2">
                        <input type="hidden" name="cedula" id="cedula" value="<?php echo $resultado['idpacientes']?>">
                        <input type="text" class="form-control" readonly value="<?php echo $resultado['idpacientes']?>" required>
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
                      <label for="fechaIngreso">Editar fecha de Ingreso</label>
                      <input type="date" name="fechaIngreso" id="fechaIngreso" value="<?php echo substr($resultado['created_at'],0,10);?>" class="form-control" disabled required>
                    </div>
                </div>
                <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="name">Nombres</label>
                    <input type="text" class="form-control" onkeypress="return soloLetras(event)" name="name" id="name" value="<?php echo $resultado['nombres']?>" readonly required>
                </div>
                <div class="form-group col-md-3">
                    <label for="apellidoPaterno">Apellido Paterno</label>
                    <input type="text" class="form-control" onkeypress="return soloLetras(event)" name="apellidoPaterno" id="apellidoPaterno" value="<?php echo $resultado['ape_paterno']?>" readonly required>
                </div>
                <div class="form-group col-md-3">
                    <label for="apellidoMaterno">Apellido Materno</label>
                    <input type="text" class="form-control" onkeypress="return soloLetras(event)" name="apellidoMaterno" id="apellidoMaterno" value="<?php echo $resultado['ape_mat']?>" readonly required>
                </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control"  onchange="validarEmail(this);" name="email" id="email" placeholder="ejemplo@gmail.com" value="<?php echo $resultado['correo']?>" readonly required>
                        <div class="invalid-feedback">
                            Correo electrónico inválido.
                        </div>
                        <div class="valid-feedback">
                            Correo electrónico válido.
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="ocupacion">Ocupación</label>
                        <select id="ocupacion" name="ocupacion" class="form-control">
                        <option selected value="<?php echo $resultado['idprofesion_paciente']?>"><?php echo utf8_encode($resultado['profesion'])?></option>
                        <option disabled value=""> Seleccione...</option>
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
                        <input type="date" class="form-control" name="fechaNacimiento" id="fechaNacimiento" value="<?php echo $resultado['f_nacimiento']?>" readonly required>
                    </div>
                    <div class="form-group col-md-4">
                    <label class="font-weight-bold">Sexo</label>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="sexo1" name="sexo" class="custom-control-input" checked>
                            <label class="custom-control-label" for="sexo1">
                            <?php if($resultado['sexo']=='V'):?>
                                Varón
                            <?php elseif($resultado['sexo']=='M'):?>
                                Mujer
                            <?php elseif($resultado['sexo']=='I'):?>
                                Indefinido
                            <?php endif;?>
                            </label>
                        </div>
                    </div>              
                </div>
                <div class="form-row mb-3">
                <div class="form-group col-md-4">
                    <label for="provincia">Provincia</label>
                    <select id="provincia" name="provincia" class="form-control" required>
                    <?php
                        foreach ($provincias as $provinciasPaciente):
                        ?>
                        <?php if($provinciasPaciente->idprovincias==$resultado['provincia']):?>
                            <option selected value="<?php echo $provinciasPaciente->idprovincias;?>"><?php echo utf8_encode($provinciasPaciente->nombre);?></option>
                        <?php else:?>
                            <option value="<?php echo $provinciasPaciente->idprovincias;?>"><?php echo utf8_encode($provinciasPaciente->nombre);?></option>
                        <?php endif;?>
                    <?php 
                        endforeach;
                        ?> 
                    </select>
                </div>
                <div class="form-group col-md-4" id="print-ciudades">
                    <label for='ciudad'>Ciudad</label>
                    <select id='ciudad' name='ciudad' class='form-control' required>
                    <option selected value="<?php echo $resultado['ciudad']?>"><?php echo $resultado['nombre']?></option>
                    <option disabled value=""> Seleccione...</option>
                    <?php foreach ($ciudades as $ciudadesPaciente):?>
                        <option value='<?php echo $ciudadesPaciente->idciudades?>'><?php echo utf8_encode($ciudadesPaciente->nombre)?></option>
                    <?php  endforeach;?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="zona">Zona</label>
                    <input type="text" class="form-control" onkeypress="return soloLetras(event)" id="zona" name="zona" value="<?php echo $resultado['zona']?>" required>
                </div>
                </div>
                <label class="font-weight-bold">Información de ubicación</label>
                <hr class="mt-1 mb-4 mr-5">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="direccionDomicilio">Dirección del domicilio</label>
                        <input type="text" class="form-control" id="direccionDomicilio" name="direccionDomicilio" value="<?php echo $direccion[1]->direccion?>" required>
                    </div>
                    <div class="form-group col-md-3">
                    <label for="telefonoDomicilio">Telefono</label>
                    <input type="text" class="form-control"  onchange="validarTelefono(this);" onkeypress="return soloNumeros(event)" maxlength="7" id="telefonoDomicilio" name="telefonoDomicilio" value="<?php echo $direccion[1]->tlno_particular?>" required>
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
                    <input type="text" class="form-control"  onchange="validarCelular(this);" onkeypress="return soloNumeros(event)" maxlength="10" id="celularDomicilio" name="celularDomicilio" value="<?php echo $direccion[1]->tlno_personal?>"  required>
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
                        <input type="text" class="form-control" id="direccionTrabajo" name="direccionTrabajo" value="<?php echo $direccion[2]->direccion?>"  required>
                    </div>
                    <div class="form-group col-md-3">
                    <label for="telefonoTrabajo">Telefono</label>
                    <input type="text" class="form-control"  onchange="validarTelefono(this);" onkeypress="return soloNumeros(event)" maxlength="7" id="telefonoTrabajo" name="telefonoTrabajo" value="<?php echo $direccion[2]->tlno_particular?>"  required>
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
                        <input type="text" class="form-control" id="direccionAtencion" name="direccionAtencion" value="<?php echo $direccion[0]->direccion?>" required>
                    </div>
                <div class="form-group col-md-3">
                    <label for="telefonoAtencion">Telefono</label>
                    <input type="text" class="form-control"  onchange="validarTelefono(this);" onkeypress="return soloNumeros(event)" maxlength="7" id="telefonoAtencion" name="telefonoAtencion" value="<?php echo $direccion[0]->tlno_particular?>"  required>
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
                <?php if($resultado['afiliacion_privada'] == null && $resultado['afiliacion_publica'] == null):?>
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
                <?php else:?> 
                    <div class="form-row">
                    <div class="form-group col-md-5">
                        <div class="form-check form-check-inline mr-5 mt-4">
                        <?php if($resultado['afiliacion_publica'] == null):?>
                        <input class="form-check-input" type="checkbox" id="publica" value="publica" onchange="afiliacion(this,'afiliacionPublica');">
                        <?php endif;?>
                        <label class="form-check-label" for="publica">Afiliación Pública</label>
                        </div>
                    </div>
                    <div class="form-group col-md-5">
                        <label for="afiliacionPublica">Afiliación Pública</label>
                        <?php if($resultado['afiliacion_publica'] == null):?>
                        <select id="afiliacionPublica" name="afiliacionPublica" class="form-control" disabled required>
                        <option selected disabled value="">Seleccione...</option>                 
                        <?php else: ?> 
                        <select id="afiliacionPublica" name="afiliacionPublica" class="form-control" required>
                        <option selected value="<?php echo $afiliacionPublica[0]->idseguro_publico?>"><?php echo utf8_encode($afiliacionPublica[0]->descripcion)?></option>                 
                        <option disabled value="">Seleccione...</option>                 
                        <?php endif;?>
                                    
                            <?php
                            foreach ($seguroPublico as $ListaPublico):
                            ?>
                            <option value="<?php echo $ListaPublico->idseguro_publico;?>"><?php echo utf8_encode($ListaPublico->descripcion);?></option>
                        <?php 
                            endforeach;
                        ?> 
                        </select>
                    </div>
                    <?php if($resultado['afiliacion_publica'] != null):?>
                        <div class="form-group col-md-2">
                            <?php if($resultado['deleted'] == 0): ?>
                                <a href="../../seguridad/controllers/borrarSeguro.php?type=publico&cedula=<?php echo $resultado['idpacientes']?>&tipo=2"><i class="fas fa-minus-circle" title="Elimina la credencial" style="color:black; font-size:18px; margin-left:40px; margin-top:40px;"></i></a>
                            <?php endif;?>
                        </div>
                    <?php endif;?>
                    </div>
                    <div class="form-row">
                    <div class="form-group col-md-5">
                        <div class="form-check form-check-inline mt-4">
                        <?php if($resultado['afiliacion_privada'] == null):?>
                        <input class="form-check-input" type="checkbox" id="privada" value="privada" onchange="afiliacion(this,'afiliacionPrivada');">
                        <?php endif;?>
                        <label class="form-check-label" for="privada">Afiliación Privada</label>
                        </div>
                    </div>
                    <div class="form-group col-md-5">
                        <label for="afiliacionPrivada">Afiliación Privada</label>
                        <?php if($resultado['afiliacion_privada'] == null):?>
                        <select id="afiliacionPrivada" name="afiliacionPrivada" class="form-control" disabled required>
                        <option selected disabled value="">Seleccione...</option>                         
                        <?php else:?>
                        <select id="afiliacionPrivada" name="afiliacionPrivada" class="form-control" required>
                        <option selected value="<?php echo $afiliacionPrivada[0]->idseguro_privado?>"><?php echo utf8_encode($afiliacionPrivada[0]->descripcion)?></option>                        
                        <option disabled value="">Seleccione...</option>                 
                        <?php endif;?>
                        <?php
                            foreach ($seguroPrivado as $ListaPrivado):
                            ?>
                            <option value="<?php echo $ListaPrivado->idseguro_privado;?>"><?php echo utf8_encode($ListaPrivado->descripcion);?></option>
                        <?php 
                            endforeach;
                            ?> 
                        </select>
                    </div>
                    <?php if($resultado['afiliacion_privada'] != null):?>
                        <div class="form-group col-md-2">
                            <?php if($resultado['deleted'] == 0): ?>
                                <a href="../../seguridad/controllers/borrarSeguro.php?type=privado&cedula=<?php echo $resultado['idpacientes']?>&tipo=2"><i class="fas fa-minus-circle" title="Eliminar seguro" style="color:black; font-size:18px; margin-left:40px; margin-top:40px;"></i></a>
                            <?php endif;?>
                        </div>
                    <?php endif; ?>
                    </div>      
                <?php endif; ?>

                <hr class="mt-1 mb-4 mr-5">
                <label class="font-weight-bold">¿Posee alguna discapacidad?</label>
                <?php if(!$carnetConadis):?>
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
                <?php else:?>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="carnetConadis">Carnet Conadis</label>
                        <input type="text" class="form-control" id="carnetConadis" name="carnetConadis" value="<?php echo $carnetConadis[0]->carnet?>" required disabled="true">
                    </div>
                    <div class="form-group col-md-5">
                        <label for="discapacidad">Discapacidad</label>
                        <input type="text" class="form-control" onkeypress="return soloLetras(event)" id="discapacidad" name="discapacidad" value="<?php echo $carnetConadis[0]->descripcion?>" required disabled="true">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="grado">Grado %</label>
                        <input type="text" class="form-control" id="grado" name="grado" value="<?php echo $carnetConadis[0]->grado?>" required disabled="true">
                    </div>
                    <div class="form-group col-md-2">
                        <?php if($resultado['deleted'] == 0): ?>
                            <a href="../../seguridad/controllers/borrarCarnet.php?cedula=<?php echo $resultado['idpacientes']?>&tipo=2"><i class="fas fa-minus-circle" title="Eliminar el carnet" style="color:black; font-size:18px; margin-left:40px; margin-top:40px;"></i></a>
                        <?php endif;?>
                    </div>
                </div>
                <?php endif;?>
                <div class="d-flex justify-content-end mt-5">
                    <?php if($resultado['deleted'] == 0): ?>
                        <a href="../../../../" class="text-secondary mr-5 mt-2">Cancelar</a>
                        <input class="btn btn-primary font-weight-bold" name="perfil" style="width:300px;" value="Guardar cambios" type="submit">
                    <?php endif;?>
                </div>
            </form> 

            <h6 class="font-weight-bold mt-5"> Historial importado del paciente.</h6>
            <hr class="mt-2 mb-4">
            <?php
                $historial = $conn->query("SELECT * FROM historial_importado WHERE id_pacientes_hi = ".$_GET['cedula']." ORDER BY created_at DESC")->fetchAll(PDO::FETCH_OBJ);
                    foreach($historial as $Historial):
            ?>
            <div class="d-flex justify-content-around mt-4 mb-5">
                <div>
                    <span class="font-weight-bold">Tipo: </span><?php echo $Historial->tipo?>
                </div>
                <div>
                    <span class="font-weight-bold">Descripcion: </span><?php echo $Historial->descripcion?>
                </div>
                <div>
                    <span class="font-weight-bold"> Registrado:</span> <?php echo $Historial->created_at?>
                </div>
                <div>
                    <a class="" href="<?php echo $Historial->file_document?>" target="_blank">
                        <i class="fas fa-external-link-square-alt mr-2"></i> 
                        Abrir el documento en otra pestaña
                    </a>
                </div>
            </div>
            <?php
                endforeach;
            ?> 
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

<?php
    printModal('Borrar Paciente','btn-delete','modal-delete','¡Hey!. Estas apunto de DAR DE BAJA al PACIENTE. ¿Realmente deseas continuar con esta acción?');
    printModal('Ingresar Paciente','btn-ingresar','modal-ingresar','¡Hey!. Estas apunto de REINTEGRAR al PACIENTE. ¿Realmente deseas continuar con esta acción?');
?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>     
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="../../recursoshumanos/components/scripts/dashboard.js"></script> 
<script src="../../seguridad/controllers/validations/validations.js"></script>
<script src="../../seguridad/components/scripts/ciudad.js"></script>  
<script src="../components/scripts/paciente.js"></script>    
<script>
    $(document).ready(function(){
        $('#btn-delete').click(function(){
            location.href=`../../recursoshumanos/controllers/lockScreen.php?type=3`;
        });  

        $('#btn-ingresar').click(function(){
            location.href=`../../recursoshumanos/controllers/lockScreen.php?type=4`;
        });  

        if($('#deleted').val() == 1){
            frm = document.forms['form'];
            for(i=0; ele=frm.elements[i]; i++){
                ele.disabled=true;
            }
        }
    });
</script>   
</body>
</html>














