<?php
  require '../../../../database.php';
  require '../components/layout.php';
    $created = date('d')."/".date('m')."/".date('Y');
    $creacion = date('d')."/".date('m')."/".date('Y')." ".date("H").":".date("i").":".date("s");
    
    //$_FILES["fileDocument"];
    //$permitidos = array("application/pdf");
   


      if(!isset($_POST["btn-submit"])){
        // $results = $conn->query("SELECT * FROM especialidades")->fetchAll(PDO::FETCH_OBJ);
      }else{   
          $cedula = $_POST['cedula'];
          $records = $conn->prepare('SELECT cedula FROM empleados WHERE cedula = :ced');
          $records->bindParam(':ced',$cedula);
          $records->execute();
          $results = $records->fetch(PDO::FETCH_ASSOC);

           if ($results['cedula']==$_POST["cedula"]) {/*repetida*/ 
                echo "<script language='javascript'>alert('La cedula que intenta ingresar ya esta registrada en el sistema.');</script>";
           }else{
              // CREATE
               $ruta = "../assets/static/contratos/";
               $archivo = $ruta.$_FILES["fileDocument"]["name"];
            if(!file_exists($ruta)){
              mkdir($ruta);
            }

            if(!file_exists($archivo)){
              $resultado = @move_uploaded_file($_FILES["fileDocument"]["tmp_name"],$archivo);
              if($resultado){
                //seguardo
              }else{
                //nose guardo
              }
            }else{
              echo "ya existe";
            }
                  try {
                    $sql = "INSERT INTO empleados (cedula,profileimage,nombres,apellidos,direccion,nacionalidad,fechaNacimiento,distrito,ciudad,telefono,celular,email,sexo,estadoCivil,hijos,nombreHijo,apellidoHijo,anosHijo,mesesHijo,nombreHijo2,apellidoHijo2,anosHijo2,mesesHijo2,nombreHijo3,apellidoHijo3,anosHijo3,mesesHijo3,nombresContactoEmerg,telefonoContactoEmerg,celularContactoEmerg,nombresContactoEmerg2,telefonoContactoEmerg2,celularContactoEmerg2,titulo,institucion,fechaIngresoInsti,fechaEgresoInsti,salarioBase,idcontrato,especialidad,cargo,personal,area,idhorario,documentosDescription,fileDocument,disponible,deleted,created_at,updated_at) VALUES (:cedula,:profileimage,:nombres,:apellidos,:direccion,:nacionalidad,:fechaNacimiento,:distrito,:ciudad,:telefono,:celular,:email,:sexo,:estadoCivil,:hijos,:nombreHijo,:apellidoHijo,:anosHijo,:mesesHijo,:nombreHijo2,:apellidoHijo2,:anosHijo2,:mesesHijo2,:nombreHijo3,:apellidoHijo3,:anosHijo3,:mesesHijo3,:nombresContactoEmerg,:telefonoContactoEmerg,:celularContactoEmerg,:nombresContactoEmerg2,:telefonoContactoEmerg2,:celularContactoEmerg2,:titulo,:institucion,:fechaIngresoInsti,:fechaEgresoInsti,:salarioBase,:idcontrato,:especialidad,:cargo,:personal,:area,:idhorario,:documentosDescription,:fileDocument,:disponible,:deleted,:created_at,:updated_at)";                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':cedula', $_POST['cedula']);
                    $stmt->bindValue(':profileimage', null, PDO::PARAM_INT);
                    $stmt->bindParam(':nombres',$_POST['nombres']);
                    $stmt->bindParam(':apellidos',$_POST['apellidos']);
                    $stmt->bindParam(':direccion',$_POST['direccion']);
                    $stmt->bindParam(':nacionalidad',$_POST['nacionalidad']);
                    $stmt->bindParam(':fechaNacimiento',$_POST['fechaNacimiento']);
                    $stmt->bindParam(':distrito',$_POST['distrito']); 
                    $stmt->bindParam(':ciudad',$_POST['ciudad']); 
                    $stmt->bindParam(':telefono',$_POST['telefono']);
                    $stmt->bindParam(':celular',$_POST['celular']);
                    $stmt->bindParam(':email',$_POST['email']);
                    $stmt->bindParam(':sexo',$_POST['sexo']);
                    $stmt->bindParam(':estadoCivil',$_POST['estadoCivil']);
                    $stmt->bindValue(':hijos',0, PDO::PARAM_INT);
                    $stmt->bindParam(':nombreHijo',$_POST['nombreHijo']);
                    $stmt->bindParam(':apellidoHijo',$_POST['apellidoHijo']);
                    $stmt->bindParam(':anosHijo',$_POST['anosHijo']);
                    $stmt->bindParam(':mesesHijo',$_POST['mesesHijo']);
                    $stmt->bindParam(':nombreHijo2',$_POST['nombreHijo2']);
                    $stmt->bindParam(':apellidoHijo2',$_POST['apellidoHijo2']);
                    $stmt->bindParam(':anosHijo2',$_POST['anosHijo2']);
                    $stmt->bindParam(':mesesHijo2',$_POST['mesesHijo2']);
                    $stmt->bindParam(':nombreHijo3',$_POST['nombreHijo3']);
                    $stmt->bindParam(':apellidoHijo3',$_POST['apellidoHijo3']);
                    $stmt->bindParam(':anosHijo3',$_POST['anosHijo3']);
                    $stmt->bindParam(':mesesHijo3',$_POST['mesesHijo3']);
                    $stmt->bindParam(':nombresContactoEmerg',$_POST['nombresContactoEmerg']);
                    $stmt->bindParam(':telefonoContactoEmerg',$_POST['telefonoContactoEmerg']);
                    $stmt->bindParam(':celularContactoEmerg',$_POST['celularContactoEmerg']);
                    $stmt->bindParam(':nombresContactoEmerg2',$_POST['nombresContactoEmerg2']);
                    $stmt->bindParam(':telefonoContactoEmerg2',$_POST['telefonoContactoEmerg2']);
                    $stmt->bindParam(':celularContactoEmerg2',$_POST['celularContactoEmerg2']);
                    $stmt->bindParam(':titulo',$_POST['titulo']);
                    $stmt->bindParam(':institucion',$_POST['institucion']);
                    $stmt->bindParam(':fechaIngresoInsti',$_POST['fechaIngresoInsti']);
                    $stmt->bindParam(':fechaEgresoInsti',$_POST['fechaEgresoInsti']);
                    $stmt->bindParam(':salarioBase',$_POST['salarioBase']);
                    $stmt->bindParam(':idcontrato',$_POST['idcontrato']);
                    $stmt->bindParam(':especialidad',$_POST['especialidad']);
                    $stmt->bindParam(':cargo',$_POST['cargo']);
                    $stmt->bindParam(':personal',$_POST['personal']);
                    $stmt->bindParam(':area',$_POST['area']);
                    $stmt->bindParam(':idhorario',$_POST['idhorario']);
                    $stmt->bindParam(':documentosDescription',$_POST['documentosDescription']);
                    $stmt->bindParam(':fileDocument', $archivo);
                    $stmt->bindValue(':deleted', 0, PDO::PARAM_INT);
                    $stmt->bindValue(':disponible', 1, PDO::PARAM_INT);
                    $stmt->bindValue(':created_at', $creacion);
                    $stmt->bindValue(':updated_at', null, PDO::PARAM_INT);
                  
                      if($stmt->execute()){
                            for($i=1;$i<=$_POST['numeroHijos'];$i++){
                              //Insertar en la tabla hijos_empleados
                                // var_dump($_POST["nombreHijo$i"]);
                                // var_dump($_POST["apellidoHijo$i"]);
                                // var_dump($_POST["anosHijo$i"]);
                                // var_dump($_POST["mesesHijo$i"]);
                            }
                          header("Location:profile.php?id=$cedula");                          
                      }
                  } catch (PDOException $e) {
                      die('Problema: ' . $e->getMessage());
                  }
            } 
      }

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
    <title>Recursos Humanos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/dashboard/">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">  
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
        <h1 class="h2">Nuevo empleado</h1>
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
          
          <div class="container mt-3 mb-5 shadow-sm p-3 bg-white rounded">
              <form class="mr-4 ml-4 mb-5 mt-3" action="create.php" method="POST" enctype="multipart/form-data">
                <label class="font-weight-bolder">Datos Personales</label>
                <hr class="mt-1 mb-4 mr-5 ">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                        <label for="validationServer01">Numero de cedula</label>
                        <input type="text" name="cedula" class="form-control" id="validationServer01" onkeypress="return soloNumeros(event)" onchange="verificarCedula()" maxlength="10" onpaste="return false" autocomplete="off" required>
                        <div class="invalid-feedback">
                            Numero de cedula invalida.
                        </div>
                        <div class="valid-feedback">
                          Numero de cedula valida.
                        </div>
                        </div>
                    </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                    <label for="validationServer01">Nombres</label>
                    <input type="text" name="nombres" class="form-control" onkeypress="return soloLetras(event)" id="validationServer02" autocomplete="off" required>
                    </div>
                    <div class="col-md-6 mb-3">
                    <label for="validationServer02">Apellidos</label>
                    <input type="text" name="apellidos" class="form-control" onkeypress="return soloLetras(event)" id="validationServer03" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationServer03">Dirección</label>
                        <input type="text" name="direccion" class="form-control" id="validationServer04" autocomplete="off"required>
                      </div>
                    <div class="col-md-3 mb-3">
                      <label for="validationServer01">Nacionalidad</label>
                      <select class="custom-select" name="nacionalidad" id="validationServer05" required>
                        <option selected disabled value="">Seleccione...</option>
                        <option>Ecuatoriana</option>
                        <option>Venezolana</option>
                        <option>Cubana</option>
                        <option>Argentina</option>
                        <option>Colombiana</option>
                        <option>Peruana</option>
                        <option>Chilena</option>
                      </select>
                      <!-- <input type="text" name="nacionalidad" class="form-control" onkeypress="return soloLetras(event)" id="validationServer05" autocomplete="off" required> -->
                    </div>
                    <div class="col-md-3 mb-3">
                      <label for="validationServer16">Fecha de nacimiento</label>
                      <input type="date" name="fechaNacimiento" class="form-control" id="validationServer06" required>
                      <div class="invalid-feedback">
                        <!--mensaje para feedback del campo.-->
                      </div>
                    </div>
                  </div>
              <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationServer14">Ciudad</label>
                    <select class="custom-select" name="ciudad" id="validationServer08" required>
                        <option selected disabled value="">Seleccione...</option>
                        <option>Guayaquil</option>
                        <option>Quito</option>
                      </select>
                      <div class="invalid-feedback">
                        <!--mensaje para feedback del campo.-->
                      </div>
                  </div>
                <div class="col-md-6 mb-3">
                  <label for="validationServer04">Telefono fijo</label>
                  <input type="text" name="telefono" class="form-control" onchange="validarTelefono('validationServer09')" onkeypress="return soloNumeros(event)" maxlength="7" id="validationServer09" onpaste="return false" autocomplete="off" required>
                  <div class="invalid-feedback">
                    Numero fijo invalido.
                  </div>
                  <div class="valid-feedback">
                    Numero fijo valido.
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-3 mb-3">
                    <label for="validationServer05">Telefono celular</label>
                    <input type="text" name="celular" class="form-control" onchange="validarCelular('validationServer10')" onkeypress="return soloNumeros(event)" maxlength="10" id="validationServer10" onpaste="return false" autocomplete="off" required>
                    <div class="invalid-feedback">
                        Numero celular invalido.
                    </div>
                    <div class="valid-feedback">
                      Numero celular valido.
                    </div>
                  </div>
                <div class="col-md-4 mb-3">
                    <label for="validationServer05">Correo electronico</label>
                    <input type="email" name="email" class="form-control" id="validationServer11" autocomplete="off" required>
                  </div>
                <div class="col-md-2 mb-3">
                  <label for="validationServer06">Sexo</label>
                  <select class="custom-select" name="sexo" id="validationServer12" required>
                    <option selected disabled value="">Seleccione...</option>
                    <option>Hombre</option>
                    <option>Mujer</option>
                  </select>
                  <div class="invalid-feedback">
                    <!--mensaje para feedback del campo.-->
                  </div>
                </div>
                <div class="col-md-3 mb-3">
                  <label for="validationServer07">Estado Civil</label>
                  <select class="custom-select" name="estadoCivil" id="validationServer13" required>
                    <option selected disabled value="">Seleccione...</option>
                    <option>Soltero</option>
                    <option>Casado</option>
                    <option>Union Libre</option>
                    <option>Viudo</option>
                  </select>
                  <div class="invalid-feedback">
                    <!--mensaje para feedback del campo.-->
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-9 mb-3">
                  <label class="font-weight-bolder mt-3">¿Tiene hijos?</label>
                </div>        
                  <div class="col-md-1 form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                    <label class="form-check-label" for="inlineRadio1">SI</label>
                  </div>
                  <div class="col-md-1 form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2" checked>
                    <label class="form-check-label" for="inlineRadio2">NO</label>
                  </div>
              </div>
              <div id="radio-hijos" style="display: none;" class="form-group shadow-sm p-3 bg-white rounded">
                <div class=""id="dynamic_field">
                      <div class="form-row">
                          <div class="col-md-3 mb-3">
                              <label for="validationServer04">Nombres</label>
                              <input type="text" name="nombreHijo1" class="form-control" onkeypress="return soloLetras(event)" id="validationServer14" autocomplete="off">
                          </div>
                          <div class="col-md-3 mb-3">
                              <label for="validationServer04">Apellidos</label>
                              <input type="text" name="apellidoHijo1" class="form-control" onkeypress="return soloLetras(event)" id="validationServer15" autocomplete="off">
                          </div>
                          <div class="col-md-2 mb-3">
                              <label for="validationServer04">Años</label>
                              <input type="text" name="anosHijo1" class="form-control" onkeypress="return soloNumeros(event)" maxlength="2" id="validationServer16" autocomplete="off">
                          </div>
                          <div class="col-md-2 mb-3">
                              <label for="validationServer04">Meses</label>
                              <input type="text" name="mesesHijo1" class="form-control" onkeypress="return soloNumeros(event)" maxlength="2" id="validationServer17" autocomplete="off">
                          </div>
                          <div class="col-md-1"><i class="fa fa-plus-circle ml-5 mt-4" name="add" id="add" aria-hidden="true" style="cursor:pointer; font-size:25px;" title="agregar"></i></div>   
                          <div class="col-md-1"><i class="fa fa-minus-circle mt-4" name="remove" id="remove" aria-hidden="true" style="cursor:pointer; font-size:25px;" title="eliminar"></i></button></div>
                      </div>
                      <input  name="numeroHijos" style="display:none;" id="numeroHijos" value="<?php echo 1;?>">
                      <!-- <button name="enviar" id="enviar">enviar</button> -->
                  </div>
              </div>
              <label class="font-weight-bolder mt-3">Contactos para casos de emergencia</label>
              <hr class="mt-1 mb-4 mr-5 ">
                <div class="form-row">
                  <div class="col-md-8 mb-3">
                    <label for="validationServer08">Nombres y Apellidos</label>
                    <input type="text" name="nombresContactoEmerg" class="form-control" onkeypress="return soloLetras(event)" id="validationServer26" autocomplete="off">
                  </div>
                  <div class="col-md-2 mb-3">
                      <label for="validationServer11">Teléfono Fijo</label>
                      <input type="text" name="telefonoContactoEmerg" class="form-control" onchange="validarTelefono('validationServer27')" maxlength="7" onkeypress="return soloNumeros(event)" id="validationServer27" autocomplete="off" required>
                      <div class="invalid-feedback">
                        Numero fijo invalido.
                      </div>
                      <div class="valid-feedback">
                        Numero fijo valido.
                      </div>
                  </div>
                  <div class="col-md-2 mb-3">
                    <label for="validationServer11">Teléfono Celular</label>
                    <input type="text" name="celularContactoEmerg" class="form-control" onchange="validarCelular('validationServer28')" maxlength="10" onkeypress="return soloNumeros(event)" id="validationServer28" autocomplete="off" required>
                    <div class="invalid-feedback">
                      Numero celular invalido.
                    </div>
                    <div class="valid-feedback">
                      Numero celular valido.
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-8 mb-3">
                    <label for="validationServer08">Nombres y Apellidos</label>
                    <input type="text" name="nombresContactoEmerg2" class="form-control" onkeypress="return soloLetras(event)" id="validationServer29" autocomplete="off">
                  </div>
                  <div class="col-md-2 mb-3">
                      <label for="validationServer11">Teléfono Fijo</label>
                      <input type="text" name="telefonoContactoEmerg2" class="form-control" onchange="validarTelefono('validationServer30')" maxlength="7" onkeypress="return soloNumeros(event)" id="validationServer30" autocomplete="off" required>
                      <div class="invalid-feedback">
                        Numero fijo invalido.
                      </div>
                      <div class="valid-feedback">
                        Numero fijo valido.
                      </div>
                  </div>
                  <div class="col-md-2 mb-3">
                    <label for="validationServer11">Teléfono Celular</label>
                    <input type="text" name="celularContactoEmerg2" class="form-control" onchange="validarCelular('validationServer31')" maxlength="10" onkeypress="return soloNumeros(event)" id="validationServer31" autocomplete="off" required>
                    <div class="invalid-feedback">
                        Numero celular invalido.
                      </div>
                      <div class="valid-feedback">
                        Numero celular valido.
                      </div>
                  </div>
                </div>
          
              <label class="font-weight-bolder mt-3">Antecedentes acádemicos y profesionales</label>
              <hr class="mt-1 mb-4 mr-5 ">
              <div class="form-row">
                <div class="col-md-6 mb-3">
                  <label for="validationServer08">Titulo / Profesión</label>
                  <input type="text" name="titulo" class="form-control" onkeypress="return soloLetras(event)" id="validationServer32" autocomplete="off">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationServer11">Institución</label>
                    <input type="text" name="institucion" class="form-control" onkeypress="return soloLetras(event)" id="validationServer33" autocomplete="off" required>
                  </div>
              </div>
              
              <div class="form-row">
                  <div class="col-md-6 mb-3">
                    <label for="validationServer16">Año de ingreso</label>
                    <input type="date" name="fechaIngresoInsti" class="form-control" id="validationServer35" required>
                    <div class="invalid-feedback">
                      <!--mensaje para feedback del campo.-->
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="validationServer16">Año de Egreso</label>
                    <input type="date" name="fechaEgresoInsti" class="form-control" id="validationServer36" required>
                        <div class="invalid-feedback">
                            <!--mensaje para feedback del campo.-->
                        </div>
                  </div>    
                </div>

                <label class="font-weight-bolder mt-3">Información ocupacional</label>
                <hr class="mt-1 mb-4 mr-5 ">
                <div class="form-row">
                  <div class="col-md-2 mb-3">
                    <label for="validationServer08">Fecha ingreso</label>
                    <input type="text" name="created_at" class="form-control" value="<?php echo $created?>" id="validationServer37" readonly>
                  </div>
                  <div class="col-md-4 mb-3">
                      <label for="validationServer11">Salario base</label>
                      <input type="text" name="salarioBase" class="form-control" onkeypress="return soloNumeros(event)" id="validationServer38" autocomplete="off" required>
                    </div>
                  <div class="col-md-3 mb-3">
                    <label for="validationServer09">Tipo de contrato</label>
                    <select class="custom-select" name="idcontrato" id="validationServer39" required>
                      <option selected disabled value="">Seleccione...</option>
                      <option>Contrato 1</option>
                      <option>Contrato 2</option>
                      <option>Contrato 3</option>
                    </select>
                    <div class="invalid-feedback">
                      <!--mensaje para feedback del campo.-->
                    </div>
                  </div>
                </div>
                
                <div class="form-row">
                      <div class="col-md-3 mb-3">
                          <label for="validationServer15">Cargo</label>
                          <select class="custom-select" name="cargo" id="validationServer41" required>
                          <option selected disabled value="">Seleccione...</option>
                          <option>Jefe de Relaciones Humanas</option>
                          <option>Gerente de RRHH</option>
                          <option>Administrativo de RRHH</option>
                          <option>Gerente de Administracion</option>
                          <option>Secretaria de Gerencia</option>
                          <option>Cajera</option>
                          <option>Recepcionista Digitadora</option>
                          <option>Auditor Medico</option>
                          <option>Secretaria de erencia</option>
                          <option>Director Medico</option>
                          <option>Jefa de Enfermeria</option>
                          <option>Enfermera Consultorios Externos</option>
                          <option>Enfermera Clínica</option>
                          <option>Técnicos Paramédicos</option>
                          <option>Auxiliares de Servicio</option>
                          <option>Asistente de Logística</option>
                          <option>Operario de Limpieza</option>
                          <option>Guardia</option>
                          <option>Gerente de Finanzas</option>
                          <option>Encargado de Contabilidad</option>
                          <option>Administrativo Contable</option>
                          <option>Asistente Contable</option>
                          <option>Contador</option>
                          <option>Medico de Cardiología</option>
                          <option>Asistente de Cardiología</option>
                          </select>
                          <div class="invalid-feedback">
                          <!--mensaje para feedback del campo.-->
                          </div>
                      </div>
                      <div class="col-md-3 mb-3">
                          <label for="validationServer06">Personal</label>
                          <select class="custom-select" name="personal" id="validationServer42" required>
                            <option selected disabled value="">Seleccione...</option>
                            <option>Administrativo</option>
                            <option>Medico</option>
                            <option>Asistencial</option>
                            <option>Directivo</option>
                          </select>
                          <div class="invalid-feedback">
                            <!--mensaje para feedback del campo.-->
                          </div>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label for="validationServer07">Área</label>
                          <select class="custom-select" name="area" id="validationServer43" required>
                              <option selected disabled value="">Seleccione...</option>
                              <option>Recursos Humanos</option>
                              <option>Administracion</option>
                              <option>Asistencia Medica</option>
                              <option>Suministro</option>
                              <option>Higiene, Seguridad y Limpieza</option>
                              <option>Finanzas y contabilidad</option>
                              <option>Especialidades</option>
                              </select>
                            <div class="invalid-feedback">
                            <!--mensaje para feedback del campo.-->
                            </div>
                          </div>
                          <div class="col-md-3 mb-3">
                              <label for="validationServer07">Horario</label>
                              <select class="custom-select" name="idhorario" id="validationServer44" required>
                                  <option selected disabled value="">Seleccione...</option>
                                  <option>Matutino</option>
                                  <option>Vespertino</option>
                                  </select>
                                <div class="invalid-feedback">
                                <!--mensaje para feedback del campo.-->
                                </div>
                              </div>
                  </div>
                <label class="font-weight-bolder mt-3">Descripcion de documentos que adjuntar</label>
                <hr class="mt-1 mb-4 mr-5 ">
                  <div class="form-row">
                    <div class="col-md-12 mb-3">
                      <textarea name="documentosDescription" class="form-control" id="lugar" rows="3"></textarea>
                    </div>        
                  </div>  
                  <div class="input-group mb-3">
                  <div class="custom-file">
                    <input name="fileDocument" type="file" class="form-control" onchange="return validarExtdoc()" id="fileDocument" accept="application/pdf" aria-describedby="inputGroupFileAddon01" required>
                  </div>
                </div>

                
              <hr class="mt-2 mb-3">  
              <button class="btn btn-primary mt-5" type="submit" name="btn-submit" id="btn-submit">Registrar</button>
            </form>
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
        <script src="../controllers/validation/validation.js"></script>         
      </body>
</html>
