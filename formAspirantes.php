<?php
   require 'database.php';
   $hora = (date("H")-7);
   $creacion = date('d')."/".date('m')."/".date('Y')." ".$hora.":".date("i").":".date("s");
   $ciudades = $conn->query("SELECT * FROM ciudades ORDER BY nombre ASC")->fetchAll(PDO::FETCH_OBJ);

      if(isset($_POST["btn-submit"])){
        
        $records = $conn->prepare('SELECT id_aspirante FROM aspirantes WHERE id_aspirante = :ced');
        $records->bindParam(':ced',$_POST['cedula']);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);

         if ($results['id_aspirante']==$_POST["cedula"]) {/*repetida*/ 
              echo "<script language='javascript'>alert('Ya has enviado una postulacion antes, te contactaremos lo antes posible.');</script>";
         }else{

            $ruta = "app/modulos/recursoshumanos/assets/static/postulantes/";
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
              $ruta = "../assets/static/postulantes/";
              $archivo = $ruta.$_FILES["fileDocument"]["name"];
              try {
                $sql = "INSERT INTO aspirantes (id_aspirante,img_profile,nombres,apellidos,direccion,nacionalidad,fecha_nacimiento,parroquia,ciudad,telefono,celular,email,sexo,estado_civil,cargo_postula,sueldo_espe,disp_horario,descripcion,fileDocument,deleted,created_at,update_at) VALUES (:id_aspirante,:img_profile,:nombres,:apellidos,:direccion,:nacionalidad,:fecha_nacimiento,:parroquia,:ciudad,:telefono,:celular,:email,:sexo,:estado_civil,:cargo_postula,:sueldo_espe,:disp_horario,:descripcion,:fileDocument,:deleted,:created_at,:update_at)";                    

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id_aspirante', $_POST['cedula']);
                $stmt->bindValue(':img_profile', null, PDO::PARAM_INT);
                $stmt->bindParam(':nombres',$_POST['nombres']);
                $stmt->bindParam(':apellidos',$_POST['apellidos']);
                $stmt->bindParam(':direccion',$_POST['direccion']);
                $stmt->bindParam(':nacionalidad',$_POST['nacionalidad']);
                $stmt->bindParam(':fecha_nacimiento',$_POST['fechaNacimiento']);
                $stmt->bindParam(':parroquia',$_POST['parroquia']); 
                $stmt->bindParam(':ciudad',$_POST['ciudad']); 
                $stmt->bindParam(':telefono',$_POST['telefono']);
                $stmt->bindParam(':celular',$_POST['celular']);
                $stmt->bindParam(':email',$_POST['email']);
                $stmt->bindParam(':sexo',$_POST['sexo']);
                $stmt->bindParam(':estado_civil',$_POST['estadoCivil']);
                $stmt->bindParam(':cargo_postula',$_POST['cargoPostula']);
                $stmt->bindParam(':sueldo_espe',$_POST['sueldoEspe']);
                $stmt->bindParam(':disp_horario',$_POST['dispHorario']);
                $stmt->bindParam(':descripcion',$_POST['descriptionPerfil']);
                $stmt->bindParam(':fileDocument', $archivo);
                $stmt->bindValue(':deleted', 0, PDO::PARAM_INT);
                $stmt->bindValue(':created_at', $creacion);
                $stmt->bindValue(':update_at', null, PDO::PARAM_INT);
              
                  if($stmt->execute()){
                        for($i=1;$i<=$_POST['antecedentesAcadem'];$i++){
                          //Insertar en la tabla antecedentesAcademicos
                          $sql = "INSERT INTO estudios_aspirantes (titulo,institucion,fecha_ingreso,fecha_egreso,id_aspirante_est) VALUES (:titulo,:institucion,:fecha_ingreso,:fecha_egreso,:id_aspirante_est)";                    
                          $stmt = $conn->prepare($sql);
                          $stmt->bindParam(':titulo',$_POST["titulo$i"]);
                          $stmt->bindParam(':institucion',$_POST["institucion$i"]);
                          $stmt->bindParam(':fecha_ingreso',$_POST["anoIngreso$i"]);
                          $stmt->bindParam(':fecha_egreso',$_POST["anoEgreso$i"]);
                          $stmt->bindParam(':id_aspirante_est', $_POST['cedula']);
                          $stmt->execute();

                        }

                        for($i=1;$i<=$_POST['experienciaLaboral'];$i++){
                          //Insertar en la tabla experiencia laboral
                          $sql = "INSERT INTO expe_laboral (nombre_emp,naturaleza_emp,direccion,cargo,anos,meses,id_aspirante_expe) VALUES (:nombre_emp,:naturaleza_emp,:direccion,:cargo,:anos,:meses,:id_aspirante_expe)";                    
                          $stmt = $conn->prepare($sql);
                          $stmt->bindParam(':nombre_emp',$_POST["titulo$i"]);
                          $stmt->bindParam(':naturaleza_emp',$_POST["institucion$i"]);
                          $stmt->bindParam(':direccion',$_POST["anoIngreso$i"]);
                          $stmt->bindParam(':cargo',$_POST["anoEgreso$i"]);
                          $stmt->bindParam(':anos',$_POST["anoEgreso$i"]);
                          $stmt->bindParam(':meses',$_POST["anoEgreso$i"]);
                          $stmt->bindParam(':id_aspirante_expe', $_POST['cedula']);
                          $stmt->execute();
                        }

                        for($i=1;$i<=4;$i++){
                          //Insertar en la tabla antecedentesAcademicos
                          $sql = "INSERT INTO referencias (tipo_refe,nombres_refe,apellidos_refe,telefono_refe,celular_refe,id_aspirante_refe) VALUES (:tipo_refe,:nombres_refe,:apellidos_refe,:telefono_refe,:celular_refe,:id_aspirante_refe)";                    
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
                          $stmt->bindParam(':id_aspirante_refe', $_POST['cedula']);
                          $stmt->execute();
                        }
                        
                        

                      header("Location:thanksyou.html");                          
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
    <title>Formulario | Aspirante</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/carousel/">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">  

    <!-- Bootstrap core CSS -->
    <link href="../assets/dist/css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="assets/styles/component/carousel.css" rel="stylesheet">
  </head>
  <body>
    <header>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="index.html">
      <span className="font-weight-bold">Clinica</span>
      <span className="font-weight-ligth">XYZ</span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
        <a class="nav-link" href="#">Citas medicas<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Pacientes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="app/modulos/recursoshumanos/index.php">Recursos humanos<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Suministros</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contabilidad</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Seguridad</a>
        </li>
      </ul>
    </div>
  </nav>
</header>

<main role="main">

  <!-- Marketing messaging and featurettes
  ================================================== -->
  <!-- Wrap the rest of the page in another container to center all the content. -->

  <div class="container mt-5">
    <h2>Registra el formulario de aspirante, te contactaremos!</h2>
  </div>
  <div class="container marketing">

        <div class="container mt-3 mb-5 shadow-sm p-3 bg-white rounded">
          <form class="mr-4 ml-4 mb-5 mt-3" action="formAspirantes.php" method="POST" enctype="multipart/form-data">
            <label class="font-weight-bolder">Datos Personales del Postulante</label>
            <hr class="mt-1 mb-4 mr-5 ">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                    <label for="validationServer01">Número de cédula</label>
                    <input type="text" name="cedula" class="form-control" id="validationServer01" onkeypress="return soloNumeros(event)" onchange="verificarCedula()" maxlength="10" onpaste="return false" autocomplete="off" required>
                    <div class="invalid-feedback">
                        Número de cédula invalida.
                    </div>
                    <div class="valid-feedback">
                        Número de cédula valida.
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
              <label for="validationServer03">Parroquia</label>
              <input type="text" name="parroquia" class="form-control" id="validationServer07" onkeypress="return soloLetras(event)" autocomplete="off" required>
            </div>
            <div class="col-md-3 mb-3">
                <label for="validationServer14">Ciudad</label>
                <select class="custom-select" name="ciudad" id="validationServer08" onkeypress="return soloLetras(event)" required>
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
            <div class="col-md-3 mb-3">
              <label for="validationServer04">Teléfono fijo</label>
              <input type="text" name="telefono" class="form-control" onchange="validarTelefono('validationServer09')" onkeypress="return soloNumeros(event)" maxlength="7" id="validationServer09" onpaste="return false" autocomplete="off" required>
              <div class="invalid-feedback">
                Número fijo invalido.
              </div>
              <div class="valid-feedback">
                Número fijo valido.
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-3 mb-3">
                <label for="validationServer05">Teléfono celular</label>
                <input type="text" name="celular" class="form-control" onchange="validarCelular('validationServer10')" onkeypress="return soloNumeros(event)" maxlength="10" id="validationServer10" onpaste="return false" autocomplete="off" required>
                <div class="invalid-feedback">
                    Número celular invalido.
                </div>
                <div class="valid-feedback">
                    Número celular valido.
                </div>
              </div>
            <div class="col-md-4 mb-3">
                <label for="validationServer05">Correo electrónico</label>
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
                <option>Unión Libre</option>
                <option>Viudo</option>
              </select>
              <div class="invalid-feedback">
                <!--mensaje para feedback del campo.-->
              </div>
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
                    <input type="date" name="anoIngreso1" class="form-control" id="validationServer35" required>
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
              </div>
              <div class="col-md-2 mb-3">
                  <label for="validationServer11">Número celular</label>
                  <input type="text" name="celularRefe1" class="form-control" onchange="validarCelular('referenciacel1')" onkeypress="return soloNumeros(event)" maxlength="10" id="referenciacel1" autocomplete="off" required>
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
                  <input type="text" name="telefonoRefe2" class="form-control" onkeypress="return soloNumeros(event)" maxlength="7" id="validationServer38" autocomplete="off" required>
                </div>
                <div class="col-md-2 mb-3">
                  <label for="validationServer11">Número celular</label>
                  <input type="text" name="celularRefe2" class="form-control" onkeypress="return soloNumeros(event)" maxlength="10" id="validationServer38" autocomplete="off" required>
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
                  <input type="text" name="telefonoRefe3" class="form-control" onkeypress="return soloNumeros(event)" maxlength="7" id="validationServer38" autocomplete="off" required>
              </div>
              <div class="col-md-2 mb-3">
                  <label for="validationServer11">Número celular</label>
                  <input type="text" name="celularRefe3" class="form-control" onkeypress="return soloNumeros(event)" maxlength="10" id="validationServer38" autocomplete="off" required>
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
                  <input type="text" name="telefonoRefe4" class="form-control" onkeypress="return soloNumeros(event)" maxlength="7" id="validationServer38" autocomplete="off" required>
              </div>
              <div class="col-md-2 mb-3">
                  <label for="validationServer11">Número celular</label>
                  <input type="text" name="celularRefe4" class="form-control" onkeypress="return soloNumeros(event)" maxlength="10" id="validationServer38" autocomplete="off" required>
              </div>
            </div>
            <label class="font-weight-bolder mt-3">Datos de oferta de empleo</label>
            <hr class="mt-1 mb-4 mr-5 ">
            <div class="form-row">
              <div class="col-md-4 mb-3">
                <label for="validationServer11">Sueldo esperado</label>
                <input type="text" name="sueldoEspe" class="form-control" onkeypress="return soloNumeros(event)" maxlength="4" id="validationServer38" autocomplete="off" required>
              </div>
              <div class="col-md-4 mb-3">
                <label for="validationServer10">Cargo al que postula</label>
                <input type="text" name="cargoPostula" class="form-control" onkeypress="return soloLetras(event)" id="validationServer38" autocomplete="off" required>
              </div>
              <div class="col-md-4 mb-3">
                <label for="validationServer07">Disponibilidad</label>
                <input type="text" name="dispHorario" class="form-control" onkeypress="return soloLetras(event)" id="validationServer38" autocomplete="off" required>
                </div>
            </div>
                      
            <label class="font-weight-bolder mt-3">¡Adjunta tu curriculum! (Solo se aceptan .PDF)</label>
            <hr class="mt-1 mb-4 mr-5 ">
              <div class="form-row">
                <label for="validationServer07">Breve descripción sobre ti</label>
                <div class="col-md-12 mb-3">
                  <textarea name="descriptionPerfil" class="form-control" id="lugar" rows="3"></textarea>
                </div>        
              </div>  
              <div class="input-group mb-3">
              <div class="custom-file">
                <input name="fileDocument" type="file" class="form-control" id="fileDocument" accept="application/pdf" aria-describedby="inputGroupFileAddon01" required>
              </div>
            </div>

            
          <hr class="mt-2 mb-3">  
          <button class="btn btn-primary mt-5" type="submit" name="btn-submit" id="btn-submit">Postular</button>
        </form>
    </div>

  </div><!-- /.container -->


  <!-- FOOTER -->
  <footer class="container">
    <p class="float-right"><a href="#">Back to top</a></p>
    <p>&copy; 2020-2021 8sb, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
  </footer>
</main>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>  <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="../assets/dist/js/bootstrap.bundle.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="app/modulos/recursoshumanos/controllers/validation/validation.js"></script>  
    </body>
</html>

