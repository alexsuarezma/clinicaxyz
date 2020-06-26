<?php
  require '../../../../database.php';
  require '../components/layout.php';
    $created = date('d')."/".date('m')."/".date('Y');
    $hora = (date("H")-7);
    $creacion = date('d')."/".date('m')."/".date('Y')." ".$hora.":".date("i").":".date("s");
    
    $ciudades = $conn->query("SELECT * FROM ciudades ORDER BY nombre ASC")->fetchAll(PDO::FETCH_OBJ);
    $cargos = $conn->query("SELECT * FROM cargo_empleados ORDER BY nombre_cargo ASC")->fetchAll(PDO::FETCH_OBJ);
    $personal = $conn->query("SELECT * FROM personal_empleados ORDER BY nombre_personal ASC")->fetchAll(PDO::FETCH_OBJ);
    $areas = $conn->query("SELECT * FROM area_empleados ORDER BY nombre_area ASC")->fetchAll(PDO::FETCH_OBJ);
    
   


      if(!isset($_POST["btn-submit"])){
        // $results = $conn->query("SELECT * FROM especialidades")->fetchAll(PDO::FETCH_OBJ);
      }else{   
          $cedula = $_POST['cedula'];
          $records = $conn->prepare('SELECT id_empleados FROM empleados WHERE id_empleados = :ced');
          $records->bindParam(':ced',$cedula);
          $records->execute();
          $results = $records->fetch(PDO::FETCH_ASSOC);

           if ($results['id_empleados']==$_POST["cedula"]) {/*repetida*/ 
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
                    $sql = "INSERT INTO empleados 
(id_empleados,profileimage,nombres,apellidos,direccion,nacionalidad,fecha_nacimiento,parroquia,id_ciudad_emp,telefono,celular,email,sexo,estado_civil,
nombres_conyuge,apellidos_conyuge,salario_base,horario,documentos_descripcion,fileDocument,disponible,deleted,created_at,update_at,id_area_emp,id_cargo_emp,id_personal_emp) VALUES (:id_empleados,:profileimage,:nombres,:apellidos,:direccion,:nacionalidad,:fecha_nacimiento,:parroquia,:id_ciudad_emp,:telefono,:celular,:email,:sexo,:estado_civil,:nombres_conyuge,:apellidos_conyuge,:salario_base,:horario,:documentos_descripcion,:fileDocument,:disponible,:deleted,:created_at,:update_at,:id_area_emp,:id_cargo_emp,:id_personal_emp)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':id_empleados', $_POST['cedula']);
                    $stmt->bindValue(':profileimage', null, PDO::PARAM_INT);
                    $stmt->bindParam(':nombres',$_POST['nombres']);
                    $stmt->bindParam(':apellidos',$_POST['apellidos']);
                    $stmt->bindParam(':direccion',$_POST['direccion']);
                    $stmt->bindParam(':nacionalidad',$_POST['nacionalidad']);
                    $stmt->bindParam(':fecha_nacimiento',$_POST['fechaNacimiento']);
                    $stmt->bindParam(':parroquia',$_POST['parroquia']); 
                    $stmt->bindParam(':id_ciudad_emp',$_POST['ciudad']); 
                    $stmt->bindParam(':telefono',$_POST['telefono']);
                    $stmt->bindParam(':celular',$_POST['celular']);
                    $stmt->bindParam(':email',$_POST['email']);
                    $stmt->bindParam(':sexo',$_POST['sexo']);
                    $stmt->bindParam(':estado_civil',$_POST['estadoCivil']);
                    $stmt->bindParam(':nombres_conyuge',$_POST['nombresConyuge']);
                    $stmt->bindParam(':apellidos_conyuge',$_POST['apellidosConyuge']);
                    $stmt->bindParam(':salario_base',$_POST['salarioBase']);
                    $stmt->bindParam(':horario',$_POST['idhorario']);
                    $stmt->bindParam(':documentos_descripcion',$_POST['documentosDescription']);
                    $stmt->bindParam(':fileDocument', $archivo);
                    $stmt->bindValue(':deleted', 0, PDO::PARAM_INT);
                    $stmt->bindValue(':disponible', 1, PDO::PARAM_INT);
                    $stmt->bindValue(':created_at', $creacion);
                    $stmt->bindValue(':update_at', null, PDO::PARAM_INT);
                    $stmt->bindParam(':id_area_emp',$_POST['area']);
                    $stmt->bindParam(':id_cargo_emp',$_POST['cargo']);
                    $stmt->bindParam(':id_personal_emp',$_POST['personal']);
                    
                  
                      if($stmt->execute()){
                            for($i=1;$i<=$_POST['numeroHijos'];$i++){
                              //Insertar en la tabla hijos_empleados
                                $sql = "INSERT INTO hijos_empleados 
                                (nombres_hijo,apellidos_hijo,anos_hijo,meses_hijo,id_empleados_hijos) VALUES (:nombres_hijo,:apellidos_hijo,:anos_hijo,:meses_hijo,:id_empleados_hijos)";                    
                                $stmt = $conn->prepare($sql);
                                $stmt->bindParam(':nombres_hijo',$_POST["nombreHijo$i"]);
                                $stmt->bindParam(':apellidos_hijo',$_POST["apellidoHijo$i"]);
                                $stmt->bindParam(':anos_hijo',$_POST["anosHijo$i"]);
                                $stmt->bindParam(':meses_hijo',$_POST["mesesHijo$i"]);
                                $stmt->bindParam(':id_empleados_hijos',$_POST["cedula"]);
                                $stmt->execute();
                            }

                            for($i=1;$i<=$_POST['antecedentesAcadem'];$i++){
                              //Insertar en la tabla antecedentesAcademicos
                              $sql = "INSERT INTO estudios_empleados 
                              (titulo_estudiosempleados,institucion_estudiosempleados,fecha_ingreso,fecha_egreso,id_empleados_est) VALUES (:titulo_estudiosempleados,:institucion_estudiosempleados,:fecha_ingreso,:fecha_egreso,:id_empleados_est)";                    
                              $stmt = $conn->prepare($sql);
                              $stmt->bindParam(':titulo_estudiosempleados',$_POST["titulo$i"]);
                              $stmt->bindParam(':institucion_estudiosempleados',$_POST["institucion$i"]);
                              $stmt->bindParam(':fecha_ingreso',$_POST["anoIngreso$i"]);
                              $stmt->bindParam(':fecha_egreso',$_POST["anoEgreso$i"]);
                              $stmt->bindParam(':id_empleados_est', $_POST['cedula']);
                              $stmt->execute();
    
                            }
    
                            for($i=1;$i<=$_POST['experienciaLaboral'];$i++){
                              //Insertar en la tabla experiencia laboral
                              $sql = "INSERT INTO expe_laboral_emp (nombre_emp,naturaleza_emp,direccion,cargo,anos,meses,id_empleados_expe) VALUES (:nombre_emp,:naturaleza_emp,:direccion,:cargo,:anos,:meses,:id_empleados_expe)";                    
                              $stmt = $conn->prepare($sql);
                              $stmt->bindParam(':nombre_emp',$_POST["empresa$i"]);
                              $stmt->bindParam(':naturaleza_emp',$_POST["naturalezaEmpresa$i"]);
                              $stmt->bindParam(':direccion',$_POST["direccion$i"]);
                              $stmt->bindParam(':cargo',$_POST["cargo$i"]);
                              $stmt->bindParam(':anos',$_POST["ano$i"]);
                              $stmt->bindParam(':meses',$_POST["meses$i"]);
                              $stmt->bindParam(':id_empleados_expe', $_POST['cedula']);
                              $stmt->execute();
                            }
    
                            for($i=1;$i<=2;$i++){
                              //Insertar en la tabla antecedentesAcademicos
                              $sql = "INSERT INTO contacto_emergencia (nombres_contacemergencia,apellidos_contacemergencia,telefono_contacemergencia,celular_contacemergencia,id_empleados_contac) VALUES (:nombres_contacemergencia,:apellidos_contacemergencia,:telefono_contacemergencia,:celular_contacemergencia,:id_empleados_contac)";                    
                              $stmt = $conn->prepare($sql);                              
                              $stmt->bindParam(':nombres_contacemergencia',$_POST["nombresContactoEmerg$i"]);
                              $stmt->bindParam(':apellidos_contacemergencia',$_POST["apellidosContactoEmerg$i"]);
                              $stmt->bindParam(':telefono_contacemergencia',$_POST["telefonoContactoEmerg$i"]);
                              $stmt->bindParam(':celular_contacemergencia',$_POST["celularContactoEmerg$i"]);
                              $stmt->bindParam(':id_empleados_contac', $_POST['cedula']);
                              $stmt->execute();
                            }
                            
                            for($i=1;$i<=4;$i++){
                              //Insertar en la tabla antecedentesAcademicos
                              $sql = "INSERT INTO referencias_empleado (tipo_refe,nombres_refe,apellidos_refe,telefono_refe,celular_refe,id_empleados_refe) VALUES (:tipo_refe,:nombres_refe,:apellidos_refe,:telefono_refe,:celular_refe,:id_empleados_refe)";                    
                              $stmt = $conn->prepare($sql);
                              if($i<=2){
                                // personal
                                $stmt->bindValue(':tipo_refe', 1, PDO::PARAM_INT);
                              }else{
                                $stmt->bindValue(':tipo_refe', 2, PDO::PARAM_INT);
                              }
                              
                              $stmt->bindParam(':nombres_refe',$_POST["nombresRefe$i"]);
                              $stmt->bindParam(':apellidos_refe',$_POST["apellidosRefe$i"]);
                              $stmt->bindParam(':telefono_refe',$_POST["telefonoRefe$i"]);
                              $stmt->bindParam(':celular_refe',$_POST["celularRefe$i"]);
                              $stmt->bindParam(':id_empleados_refe', $_POST['cedula']);
                              $stmt->execute();
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
  printLayout('../index.php', '../../../../index.html', 'contrato.php', 'personal.php', 'reclutamiento.php', 'historialPersonal.php');
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
                <div class="col-md-3 mb-3">
                          <label for="validationServer03">Parroquía</label>
                          <input type="text" name="parroquia" class="form-control" id="validationServer04" autocomplete="off"required>
                        </div>
                  <div class="col-md-3 mb-3">
                  <label for="validationServer14">Ciudad</label>
                  <select class="custom-select" name="ciudad" id="validationServer08" required>
                      <option selected disabled value="">Seleccione...</option>
                      <?php
                      foreach ($ciudades as $ciudadesAspirante):
                      ?>
                      <option value="<?php echo $ciudadesAspirante->idciudades;?>"><?php echo utf8_encode($ciudadesAspirante->nombre);?></option>
                      <?php 
                      endforeach;
                      ?>  
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
                <label class="font-weight-bolder mt-3">Antecedentes acádemicos y profesionales</label>
                <hr class="mt-1 mb-4 mr-5 ">
                <div class=""id="dynamic_field_academico">
                    <div class="form-row">
                      <div class="form-row">
                        <div class="col-md-12 mb-3">
                          <label for="validationServer08">Título / Profesión</label>
                          <input type="text" name="titulo1" class="form-control" onkeypress="return soloLetras(event)" id="validationServer32" autocomplete="off" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationServer11">Institución</label>
                            <input type="text" name="institucion1" class="form-control" onkeypress="return soloLetras(event)" id="validationServer33" autocomplete="off" required>
                          </div>
                      </div>
                      <div class="form-row">
                        <div class="col-md-10 ml-2 mb-3">
                          <label for="validationServer16">Año de Ingreso</label>
                          <input type="date" name="anoIngreso1" class="form-control"id="validationServer35" required>
                          <div class="invalid-feedback">
                            <!--mensaje para feedback del campo.-->
                          </div>
                        </div>
                        <div class="col-md-10 ml-2 mb-3">
                          <label for="validationServer16">Año de Egreso</label>
                          <input type="date" name="anoEgreso1" class="form-control" id="validationServer36" required>
                            <div class="invalid-feedback">
                                <!--mensaje para feedback del campo.-->
                            </div>
                      </div>    
                    </div>
                        <div class="col-md-1"><i class="fa fa-plus-circle ml-5 mt-4" name="add" id="add-aspirante" aria-hidden="true" style="cursor:pointer; font-size:25px;" title="agregar"></i></div>   
                        <div class="col-md-1"><i class="fa fa-minus-circle mt-4" name="remove" id="remove-academico" aria-hidden="true" style="cursor:pointer; font-size:25px;" title="eliminar"></i></button></div>
                    </div>
                    <hr class="mt-1 mb-4 mr-5">
                    <input  name="antecedentesAcadem" style="display: none;" id="antecedentesAcadem" value="<?php echo 1;?>">
                </div>
                <label class="font-weight-bolder mt-3">Experiencia laboral</label>
                <hr class="mt-1 mb-4 mr-5 ">
                <div class=""id="dynamic_field_experiencia">
                    <div class="form-row">
                
                            <div class="col-md-4 mb-3">
                              <label for="validationServer08">Empresa</label>
                              <input type="text" name="empresa1" class="form-control" onkeypress="return soloLetras(event)" id="validationServer32" autocomplete="off" required>
                            </div>
                            <div class="col-md-5 mb-3">
                              <label for="validationServer16">Dirección</label>
                              <input type="text" name="direccion1" class="form-control" id="validationServer35" required>
                            </div>
                            <div class="col-md-3 mb-3">
                              <label for="validationServer16">Cargo</label>
                              <input type="text" name="cargo1" class="form-control" id="validationServer36" onkeypress="return soloLetras(event)" required>
                            </div>    
                            <div class="col-md-2 mb-3">
                              <label for="validationServer16">Años</label>
                              <input type="text" name="ano1" class="form-control" onkeypress="return soloNumeros(event)" maxlength="2" id="validationServer36" required>
                            </div>  
                            <div class="col-md-2 mb-3">
                              <label for="validationServer16">Meses</label>
                              <input type="text" name="meses1" class="form-control" onkeypress="return soloNumeros(event)" maxlength="2" id="validationServer36" required>
                            </div>  
                            <div class="col-md-5 mb-3 mr-3">
                              <label for="validationServer11">Naturaleza de la Empresa</label>
                              <input type="text" name="naturalezaEmpresa1" class="form-control" onkeypress="return soloLetras(event)" id="validationServer33" autocomplete="off" required>
                            </div>
                  
                        <div class="col-md-1 ml-5"><i class="fa fa-plus-circle ml-5 mt-4" name="add" id="add-experiencia" aria-hidden="true" style="cursor:pointer; font-size:25px;" title="agregar"></i></div>   
                        <div class="col-md-1"><i class="fa fa-minus-circle mt-4" name="remove" id="remove-experiencia" aria-hidden="true" style="cursor:pointer; font-size:25px;" title="eliminar"></i></button></div>
                    </div>
                    <hr class="mt-1 mb-4 mr-5">
                    <input  name="experienciaLaboral" style="display: none;" id="experienciaLaboral" value="<?php echo 1;?>">
                </div>
                <label class="font-weight-bolder mt-3">Referencias</label>
                <hr class="mt-1 mb-4 mr-5 ">
                <label class="font-weight-bolder mt-3 ml-2">Personales</label>
                <div class="form-row">
                  <div class="col-md-4 mb-3">
                    <label for="validationServer08">Nombres</label>
                    <input type="text" name="nombresRefe1" class="form-control" id="validationServer37" onkeypress="return soloLetras(event)" autocomplete="off" required>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="validationServer08">Apellidos</label>
                    <input type="text" name="apellidosRefe1" class="form-control" id="validationServer37" onkeypress="return soloLetras(event)" autocomplete="off" required>
                  </div>
                  <div class="col-md-2 mb-3">
                      <label for="validationServer11">Número de teléfono</label>
                      <input type="text" name="telefonoRefe1" class="form-control" onchange="validarTelefono('referenciatel1')"  onkeypress="return soloNumeros(event)" maxlength="7" id="referenciatel1" autocomplete="off" required>
                      <div class="invalid-feedback">
                          Numero fijo invalido.
                        </div>
                        <div class="valid-feedback">
                          Numero fijo valido.
                        </div>
                   </div>
                  <div class="col-md-2 mb-3">
                      <label for="validationServer11">Número celular</label>
                      <input type="text" name="celularRefe1" class="form-control" onchange="validarCelular('referenciacel1')" onkeypress="return soloNumeros(event)" maxlength="10" id="referenciacel1" autocomplete="off" required>
                      <div class="invalid-feedback">
                        Numero celular invalido.
                      </div>
                      <div class="valid-feedback">
                        Numero celular valido.
                      </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-4 mb-3">
                    <label for="validationServer08">Nombres</label>
                    <input type="text" name="nombresRefe2" class="form-control" id="validationServer37" onkeypress="return soloLetras(event)" autocomplete="off" required>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="validationServer08">Apellidos</label>
                    <input type="text" name="apellidosRefe2" class="form-control" id="validationServer37" onkeypress="return soloLetras(event)" autocomplete="off" required>
                  </div>
                  <div class="col-md-2 mb-3">
                      <label for="validationServer11">Número de teléfono</label>
                      <input type="text" name="telefonoRefe2" class="form-control" onchange="validarTelefono('referenciatel2')" onkeypress="return soloNumeros(event)" maxlength="7" id="referenciatel2" autocomplete="off" required>
                      <div class="invalid-feedback">
                          Numero fijo invalido.
                        </div>
                        <div class="valid-feedback">
                          Numero fijo valido.
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                      <label for="validationServer11">Número celular</label>
                      <input type="text" name="celularRefe2" class="form-control" onchange="validarCelular('referenciacel2')" onkeypress="return soloNumeros(event)" maxlength="10" id="referenciacel2" autocomplete="off" required>
                      <div class="invalid-feedback">
                        Numero celular invalido.
                      </div>
                      <div class="valid-feedback">
                        Numero celular valido.
                      </div>
                    </div>
                </div>

                <label class="font-weight-bolder mt-3 ml-2">Laborales</label>
                <div class="form-row">
                  <div class="col-md-4 mb-3">
                    <label for="validationServer08">Nombres</label>
                    <input type="text" name="nombresRefe3" class="form-control" id="validationServer37" onkeypress="return soloLetras(event)" autocomplete="off" required>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="validationServer08">Apellidos</label>
                    <input type="text" name="apellidosRefe3" class="form-control" id="validationServer37" onkeypress="return soloLetras(event)" autocomplete="off" required>
                  </div>
                  <div class="col-md-2 mb-3">
                      <label for="validationServer11">Número de teléfono</label>
                      <input type="text" name="telefonoRefe3" class="form-control" onchange="validarTelefono('referenciatel3')" onkeypress="return soloNumeros(event)" maxlength="7" id="referenciatel3" autocomplete="off" required>
                      <div class="invalid-feedback">
                          Numero fijo invalido.
                        </div>
                        <div class="valid-feedback">
                          Numero fijo valido.
                        </div>    
                  </div>
                  <div class="col-md-2 mb-3">
                      <label for="validationServer11">Número celular</label>
                      <input type="text" name="celularRefe3" class="form-control" onchange="validarCelular('referenciacel3')" onkeypress="return soloNumeros(event)" maxlength="10" id="referenciacel3" autocomplete="off" required>
                      <div class="invalid-feedback">
                        Numero celular invalido.
                      </div>
                      <div class="valid-feedback">
                        Numero celular valido.
                      </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-4 mb-3">
                    <label for="validationServer08">Nombres</label>
                    <input type="text" name="nombresRefe4" class="form-control" id="validationServer37" onkeypress="return soloLetras(event)" autocomplete="off" required>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="validationServer08">Apellidos</label>
                    <input type="text" name="apellidosRefe4" class="form-control" id="validationServer37" onkeypress="return soloLetras(event)" autocomplete="off" required>
                  </div>
                  <div class="col-md-2 mb-3">
                      <label for="validationServer11">Número de teléfono</label>
                      <input type="text" name="telefonoRefe4" class="form-control" onchange="validarTelefono('referenciatel4')"onkeypress="return soloNumeros(event)" maxlength="7" id="referenciatel4" autocomplete="off" required>
                      <div class="invalid-feedback">
                          Numero fijo invalido.
                        </div>
                        <div class="valid-feedback">
                          Numero fijo valido.
                        </div>
                  </div>
                  <div class="col-md-2 mb-3">
                      <label for="validationServer11">Número celular</label>
                      <input type="text" name="celularRefe4" class="form-control" onchange="validarCelular('referenciacel4')" onkeypress="return soloNumeros(event)" maxlength="10" id="referenciacel4" autocomplete="off" required>
                      <div class="invalid-feedback">
                        Numero celular invalido.
                      </div>
                      <div class="valid-feedback">
                        Numero celular valido.
                      </div>
                  </div>
                </div>
                <label class="font-weight-bolder mt-3">Contactos para casos de emergencia</label>
                <hr class="mt-1 mb-4 mr-5 ">
                  <div class="form-row">
                    <div class="col-md-4 mb-3">
                      <label for="validationServer08">Nombres</label>
                      <input type="text" name="nombresContactoEmerg1" class="form-control" onkeypress="return soloLetras(event)" id="validationServer26" autocomplete="off">
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="validationServer08">Apellidos</label>
                      <input type="text" name="apellidosContactoEmerg1" class="form-control" onkeypress="return soloLetras(event)" id="validationServer26" autocomplete="off">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="validationServer11">Teléfono Fijo</label>
                        <input type="text" name="telefonoContactoEmerg1" class="form-control" onchange="validarTelefono('validationServer27')" maxlength="7" onkeypress="return soloNumeros(event)" id="validationServer27" autocomplete="off" required>
                        <div class="invalid-feedback">
                          Numero fijo invalido.
                        </div>
                        <div class="valid-feedback">
                          Numero fijo valido.
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                      <label for="validationServer11">Teléfono Celular</label>
                      <input type="text" name="celularContactoEmerg1" class="form-control" onchange="validarCelular('validationServer28')" maxlength="10" onkeypress="return soloNumeros(event)" id="validationServer28" autocomplete="off" required>
                      <div class="invalid-feedback">
                        Numero celular invalido.
                      </div>
                      <div class="valid-feedback">
                        Numero celular valido.
                      </div>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-md-4 mb-3">
                      <label for="validationServer08">Nombres</label>
                      <input type="text" name="nombresContactoEmerg2" class="form-control" onkeypress="return soloLetras(event)" id="validationServer29" autocomplete="off">
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="validationServer08">Apellidos</label>
                      <input type="text" name="apellidosContactoEmerg2" class="form-control" onkeypress="return soloLetras(event)" id="validationServer29" autocomplete="off">
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
                <label class="font-weight-bolder mt-3">Información ocupacional</label>
                <hr class="mt-1 mb-4 mr-5 ">
                <div class="form-row">
                  <div class="col-md-2 mb-3">
                    <label for="validationServer08">Fecha ingreso</label>
                    <input type="text" name="created_at" class="form-control" value="<?php echo $created?>" id="validationServer37" readonly>
                  </div>
                  <div class="col-md-4 mb-3">
                      <label for="validationServer11">Salario base</label>
                      <input type="text" onkeypress="return filterFloat(event,this);" name="salarioBase" class="form-control" maxlength="7" id="validationServer38" autocomplete="off" required/>
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
                          <?php
                          foreach ($cargos as $cargosEmpleado):
                          ?>
                          <option value="<?php echo $cargosEmpleado->id_cargo;?>"><?php echo utf8_encode($cargosEmpleado->nombre_cargo);?></option>
                          <?php 
                          endforeach;
                          ?>  
                          </select>
                          <div class="invalid-feedback">
                          <!--mensaje para feedback del campo.-->
                          </div>
                      </div>
                      <div class="col-md-3 mb-3">
                          <label for="validationServer06">Personal</label>
                          <select class="custom-select" name="personal" id="validationServer42" required>
                            <option selected disabled value="">Seleccione...</option>
                            <?php
                            foreach ($personal as $personalEmpleado):
                            ?>
                            <option value="<?php echo $personalEmpleado->id_personal;?>"><?php echo utf8_encode($personalEmpleado->nombre_personal);?></option>
                            <?php 
                            endforeach;
                            ?> 
                          </select>
                          <div class="invalid-feedback">
                            <!--mensaje para feedback del campo.-->
                          </div>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label for="validationServer07">Área</label>
                          <select class="custom-select" name="area" id="validationServer43" required>
                              <option selected disabled value="">Seleccione...</option>
                              <?php
                              foreach ($areas as $areaEmpleado):
                              ?>
                              <option value="<?php echo $areaEmpleado->id_area;?>"><?php echo utf8_encode($areaEmpleado->nombre_area);?></option>
                              <?php 
                              endforeach;
                              ?> 
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
                                  <option>Jornada Completa</option>
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
