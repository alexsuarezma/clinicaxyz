<?php
   require 'database.php';
   $creacion = date('d')."/".date('m')."/".date('Y')." ".date("H").":".date("i").":".date("s");
      if(isset($_POST["btn-submit"])){
        $cedula = $_POST['cedula'];
        $records = $conn->prepare('SELECT cedula FROM aspirante WHERE cedula = :ced');
        $records->bindParam(':ced',$cedula);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);

         if ($results['cedula']==$_POST["cedula"]) {/*repetida*/ 
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
                $sql = "INSERT INTO aspirante (cedula,nombres,apellidos,direccion,nacionalidad,fechaNacimiento,ciudad,telefono,celular,email,sexo,estadoCivil,titulo,institucion,anoIngreso,anoEgreso,titulo2,institucion2,anoIngreso2,anoEgreso2,especialidad,especialidad2,especialidad3,anosExperiencia,areaPretendida,horarioPretendido,descriptionPerfil,fileDocument,deleted,created_at,updated_at) VALUES (:cedula,:nombres,:apellidos,:direccion,:nacionalidad,:fechaNacimiento,:ciudad,:telefono,:celular,:email,:sexo,:estadoCivil,:titulo,:institucion,:anoIngreso,:anoEgreso,:titulo2,:institucion2,:anoIngreso2,:anoEgreso2,:especialidad,:especialidad2,:especialidad3,:anosExperiencia,:areaPretendida,:horarioPretendido,:descriptionPerfil,:fileDocument,:deleted,:created_at,:updated_at)";                    
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':cedula', $_POST['cedula']);
                $stmt->bindParam(':nombres',$_POST['nombres']);
                $stmt->bindParam(':apellidos',$_POST['apellidos']);
                $stmt->bindParam(':direccion',$_POST['direccion']);
                $stmt->bindParam(':nacionalidad',$_POST['nacionalidad']);
                $stmt->bindParam(':fechaNacimiento',$_POST['fechaNacimiento']);
                $stmt->bindParam(':ciudad',$_POST['ciudad']); 
                $stmt->bindParam(':telefono',$_POST['telefono']);
                $stmt->bindParam(':celular',$_POST['celular']);
                $stmt->bindParam(':email',$_POST['email']);
                $stmt->bindParam(':sexo',$_POST['sexo']);
                $stmt->bindParam(':estadoCivil',$_POST['estadoCivil']);
                $stmt->bindParam(':titulo',$_POST['titulo']);
                $stmt->bindParam(':institucion',$_POST['institucion']);
                $stmt->bindParam(':anoIngreso',$_POST['anoIngreso']);
                $stmt->bindParam(':anoEgreso',$_POST['anoEgreso']);
                $stmt->bindParam(':titulo2',$_POST['titulo2']);
                $stmt->bindParam(':institucion2',$_POST['institucion2']);
                $stmt->bindParam(':anoIngreso2',$_POST['anoIngreso2']);
                $stmt->bindParam(':anoEgreso2',$_POST['anoEgreso2']);
                $stmt->bindParam(':especialidad',$_POST['especialidad']);
                $stmt->bindParam(':especialidad2',$_POST['especialidad2']);
                $stmt->bindParam(':especialidad3',$_POST['especialidad3']);
                $stmt->bindParam(':anosExperiencia',$_POST['anosExperiencia']);
                $stmt->bindParam(':areaPretendida',$_POST['areaPretendida']);
                $stmt->bindParam(':horarioPretendido',$_POST['horarioPretendido']);
                $stmt->bindParam(':descriptionPerfil',$_POST['descriptionPerfil']);
                $stmt->bindParam(':fileDocument', $archivo);
                $stmt->bindValue(':deleted', 0, PDO::PARAM_INT);
                $stmt->bindValue(':created_at', $creacion);
                $stmt->bindValue(':updated_at', null, PDO::PARAM_INT);
              
                  if($stmt->execute()){
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
                  <input type="text" name="nacionalidad" class="form-control" onkeypress="return soloLetras(event)" id="validationServer05" autocomplete="off" required>
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
              <label for="validationServer03">Distrito</label>
              <input type="text" name="distrito" class="form-control" id="validationServer07" autocomplete="off" required>
            </div>
            <div class="col-md-3 mb-3">
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
            <div class="col-md-3 mb-3">
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
   
      
          <label class="font-weight-bolder mt-3">Antecedentes acádemicos y profesionales</label>
          <hr class="mt-1 mb-4 mr-5 ">
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationServer08">Titulo / Profesión</label>
              <input type="text" name="titulo" class="form-control" onkeypress="return soloLetras(event)" id="validationServer32" autocomplete="off" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="validationServer11">Institución</label>
                <input type="text" name="institucion" class="form-control" onkeypress="return soloLetras(event)" id="validationServer33" autocomplete="off" required>
              </div>
          </div>
          
          <div class="form-row">
              <div class="col-md-6 mb-3">
                <label for="validationServer16">Año de ingreso</label>
                <input type="text" name="anoIngreso" class="form-control" id="validationServer35" onkeypress="return soloNumeros(event)" maxlength="4" required>
                <div class="invalid-feedback">
                  <!--mensaje para feedback del campo.-->
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="validationServer16">Año de Egreso</label>
                <input type="text" name="anoEgreso" class="form-control" id="validationServer36" onkeypress="return soloNumeros(event)" maxlength="4" required>
                    <div class="invalid-feedback">
                        <!--mensaje para feedback del campo.-->
                    </div>
              </div>    
            </div>
            <hr class="mt-1 mb-4 mr-5 ">
            <div class="form-row">
              <div class="col-md-6 mb-3">
                <label for="validationServer08">Titulo / Profesión</label>
                <input type="text" name="titulo2" class="form-control" onkeypress="return soloLetras(event)" id="validationServer32" autocomplete="off" required>
              </div>
              <div class="col-md-6 mb-3">
                  <label for="validationServer11">Institución</label>
                  <input type="text" name="institucion2" class="form-control" onkeypress="return soloLetras(event)" id="validationServer33" autocomplete="off" required>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                  <label for="validationServer16">Año de ingreso</label>
                  <input type="date" name="anoIngreso2" class="form-control" id="validationServer35" onkeypress="return soloNumeros(event)" maxlength="4"required>
                  <div class="invalid-feedback">
                    <!--mensaje para feedback del campo.-->
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="validationServer16">Año de Egreso</label>
                  <input type="date" name="anoEgreso2" class="form-control" id="validationServer36" onkeypress="return soloNumeros(event)" maxlength="4" required>
                      <div class="invalid-feedback">
                          <!--mensaje para feedback del campo.-->
                      </div>
                </div>    
              </div>

            <label class="font-weight-bolder mt-3">Información ocupacional</label>
            <hr class="mt-1 mb-4 mr-5 ">
            <div class="form-row">
              <div class="col-md-4 mb-3">
                <label for="validationServer08">Especialidad 1</label>
                <input type="text" name="especialidad" class="form-control" id="validationServer37" onkeypress="return soloLetras(event)" autocomplete="off" required>
              </div>
              <div class="col-md-4 mb-3">
                  <label for="validationServer11">Especialidad 2</label>
                  <input type="text" name="especialidad2" class="form-control" onkeypress="return soloLetras(event)" id="validationServer38" autocomplete="off" required>
                </div>
                <div class="col-md-4 mb-3">
                  <label for="validationServer11">Especialidad 3</label>
                  <input type="text" name="especialidad3" class="form-control" onkeypress="return soloLetras(event)" id="validationServer38" autocomplete="off" required>
                </div>
            </div>
         
            
            <div class="form-row">
              <div class="col-md-4 mb-3">
                <label for="validationServer11">Años de experiencia</label>
                <input type="text" name="anosExperiencia" class="form-control" onkeypress="return soloNumeros(event)" maxlength="4" id="validationServer38" autocomplete="off" required>
              </div>
              <div class="col-md-4 mb-3">
                <label for="validationServer10">Area pretendida</label>
                <input type="text" name="areaPretendida" class="form-control" onkeypress="return soloLetras(event)" id="validationServer38" autocomplete="off" required>
              </div>
              <div class="col-md-4 mb-3">
                <label for="validationServer07">Horario pretendido</label>
                <select class="custom-select" name="horarioPretendido" id="validationServer44" required>
                    <option selected disabled value="">Seleccione...</option>
                    <option>Matutino</option>
                    <option>Vespertino</option>
                    <option>Nocturno</option>
                    <option>Rotativo</option>
                    <option>Disponibilidad horaria</option>
                    </select>
                  <div class="invalid-feedback">
                  <!--mensaje para feedback del campo.-->
                  </div>
                </div>
            </div>
                      
            <label class="font-weight-bolder mt-3">¡Adjunta tu curriculum! (Solo se aceptan .PDF)</label>
            <hr class="mt-1 mb-4 mr-5 ">
              <div class="form-row">
                <label for="validationServer07">Breve descripcion sobre ti</label>
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

