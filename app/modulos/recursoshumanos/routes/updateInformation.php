<?php
    require '../../../../database.php';
    session_start();
    $id = $_SESSION['cedula'];
    
        if(!isset($_POST["btn-actualizar"])){
            $records = $conn->prepare("SELECT * FROM empleados WHERE cedula = :cedula");
            $records->bindParam(':cedula', $id);
            $records->execute();
            $results = $records->fetch(PDO::FETCH_ASSOC);
            $espe = $conn->query("SELECT * FROM especialidades")->fetchAll(PDO::FETCH_OBJ);
       }else{   
                // ARREGLAR LA HORA DE MODIFICACION
                $updated = date('d')."/".date('m')."/".date('Y')." ".date("H").":".date("i").":".date("s");
                $sql = "UPDATE empleados SET nombres=:nombres,apellidos=:apellidos,direccion=:direccion,nacionalidad=:nacionalidad,fechaNacimiento=:fechaNacimiento,distrito=:distrito,ciudad=:ciudad,telefono=:telefono,celular=:celular,email=:email,sexo=:sexo,estadoCivil=:estadoCivil,nombreHijo=:nombreHijo,apellidoHijo=:apellidoHijo,anosHijo=:anosHijo,mesesHijo=:mesesHijo,nombreHijo2=:nombreHijo2,apellidoHijo2=:apellidoHijo2,anosHijo2=:anosHijo2,mesesHijo2=:mesesHijo2,nombreHijo3=:nombreHijo3,apellidoHijo3=:apellidoHijo3,anosHijo3=:anosHijo3,mesesHijo3=:mesesHijo3,nombresContactoEmerg=:nombresContactoEmerg,telefonoContactoEmerg=:telefonoContactoEmerg,celularContactoEmerg=:celularContactoEmerg,nombresContactoEmerg2=:nombresContactoEmerg2,telefonoContactoEmerg2=:telefonoContactoEmerg2,celularContactoEmerg2=:celularContactoEmerg2,titulo=:titulo,institucion=:institucion,fechaIngresoInsti=:fechaIngresoInsti,fechaEgresoInsti=:fechaEgresoInsti,salarioBase=:salarioBase,idcontrato=:idcontrato,especialidad=:especialidad,cargo=:cargo,personal=:personal,area=:area,idhorario=:idhorario,documentosDescription=:documentosDescription,updated_at=:updated_at WHERE cedula=:cedula";
                $stmt = $conn->prepare($sql);

                $stmt->bindParam(':cedula', $_POST['cedula']);
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
                $stmt->bindValue(':updated_at', $updated);
            try{
                if($stmt->execute()){
                    header("Location:profile.php?id=$id");                          
                }
            } catch (PDOException $e) {
                die('Problema: ' . $e->getMessage());
            }
                
       }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


<div class="container mt-3 mb-5 shadow-sm p-3 bg-white rounded">
              <form class="mb-5 mt-1" action="updateInformation.php" method="POST">
                <label class="font-weight-bolder">Datos Personales</label>
                <hr class="mt-1 mb-4 mr-5 ">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                        <label for="validationServer01">Numero de cedula</label>
                        <input type="text" name="cedula" value="<?php echo $results["cedula"]?>" class="form-control" id="validationServer01" readonly>
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
                    <input type="text" name="nombres" class="form-control" value="<?php echo $results["nombres"]?>"  onkeypress="return soloLetras(event)" id="validationServer02" autocomplete="off" required>
                    </div>
                    <div class="col-md-6 mb-3">
                    <label for="validationServer02">Apellidos</label>
                    <input type="text" name="apellidos" class="form-control" value="<?php echo $results["apellidos"]?>" onkeypress="return soloLetras(event)" id="validationServer03" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationServer03">Dirección</label>
                        <input type="text" name="direccion" class="form-control" value="<?php echo $results["direccion"]?>"  id="validationServer04" autocomplete="off"required>
                      </div>
                    <div class="col-md-3 mb-3">
                      <label for="validationServer01">Nacionalidad</label>
                      <input type="text" name="nacionalidad" class="form-control" value="<?php echo $results["nacionalidad"]?>"  onkeypress="return soloLetras(event)" id="validationServer05" autocomplete="off" required>
                    </div>
                    <div class="col-md-3 mb-3">
                      <label for="validationServer16">Fecha de nacimiento</label>
                      <input type="date" name="fechaNacimiento" value="<?php echo $results["fechaNacimiento"]?>"  class="form-control" id="validationServer06" required>
                      <div class="invalid-feedback">
                        <!--mensaje para feedback del campo.-->
                      </div>
                    </div>
                  </div>
              <div class="form-row">
                <div class="col-md-6 mb-3">
                  <label for="validationServer03">Distrito</label>
                  <input type="text" name="distrito" class="form-control" value="<?php echo $results["distrito"]?>"  id="validationServer07" autocomplete="off" required>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="validationServer14">Ciudad</label>
                    <select class="custom-select" name="ciudad" id="validationServer08" required>
                        <option selected="true"><?php echo $results["ciudad"]?></option>
                        <option disabled value="">Seleccione...</option>
                        <option>Guayaquil</option>
                        <option>Quito</option>
                      </select>
                      <div class="invalid-feedback">
                        <!--mensaje para feedback del campo.-->
                      </div>
                  </div>
                <div class="col-md-3 mb-3">
                  <label for="validationServer04">Telefono fijo</label>
                  <input type="text" name="telefono" class="form-control" value="<?php echo $results["telefono"]?>"  onchange="validarTelefono('validationServer09')" onkeypress="return soloNumeros(event)" maxlength="7" id="validationServer09" onpaste="return false" autocomplete="off" required>
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
                    <input type="text" name="celular" class="form-control" value="<?php echo $results["celular"]?>"  onchange="validarCelular('validationServer10')" onkeypress="return soloNumeros(event)" maxlength="10" id="validationServer10" onpaste="return false" autocomplete="off" required>
                    <div class="invalid-feedback">
                        Numero celular invalido.
                    </div>
                    <div class="valid-feedback">
                      Numero celular valido.
                    </div>
                  </div>
                <div class="col-md-4 mb-3">
                    <label for="validationServer05">Correo electronico</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $results["email"]?>"  id="validationServer11" autocomplete="off" required>
                  </div>
                <div class="col-md-2 mb-3">
                  <label for="validationServer06">Sexo</label>
                  <select class="custom-select" name="sexo" id="validationServer12" required>
                    <option selected="true"><?php echo $results["sexo"]?></option>  
                    <option disabled value="">Seleccione...</option>
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
                    <option selected="true"><?php echo $results["estadoCivil"]?></option>
                    <option disabled value="">Seleccione...</option>
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
                  <input type="text" name="titulo" class="form-control" value="<?php echo $results["titulo"]?>" onkeypress="return soloLetras(event)" id="validationServer32" autocomplete="off">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationServer11">Institución</label>
                    <input type="text" name="institucion" class="form-control" value="<?php echo $results["institucion"]?>" onkeypress="return soloLetras(event)" id="validationServer33" autocomplete="off" required>
                  </div>
              </div>
              
              <div class="form-row">
                  <div class="col-md-6 mb-3">
                    <label for="validationServer16">Año de ingreso</label>
                    <input type="date" name="fechaIngresoInsti" value="<?php echo $results["fechaIngresoInsti"]?>" class="form-control" id="validationServer35" required>
                    <div class="invalid-feedback">
                      <!--mensaje para feedback del campo.-->
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="validationServer16">Año de Egreso</label>
                    <input type="date" name="fechaEgresoInsti" value="<?php echo $results["fechaEgresoInsti"]?>" class="form-control" id="validationServer36" required>
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
                    <input type="text" name="created_at" value="<?php echo $results["created_at"]?>" class="form-control" id="validationServer37" readonly>
                  </div>
                  <div class="col-md-4 mb-3">
                      <label for="validationServer11">Salario base</label>
                      <input type="text" name="salarioBase" class="form-control" value="<?php echo $results["salarioBase"]?>" onkeypress="return soloNumeros(event)" id="validationServer38" autocomplete="off" required>
                    </div>
                  <div class="col-md-3 mb-3">
                    <label for="validationServer09">Tipo de contrato</label>
                    <select class="custom-select" name="idcontrato" id="validationServer39" required>
                      <option selected="true"><?php echo $results["idcontrato"]?></option>
                      <option disabled value="">Seleccione...</option>
                      <option>Contrato 1</option>
                      <option>Contrato 2</option>
                      <option>Contrato 3</option>
                    </select>
                    <div class="invalid-feedback">
                      <!--mensaje para feedback del campo.-->
                    </div>
                  </div>
                  <div class="col-md-3 mb-3">
                    <label for="validationServer10">Especialidad</label>
                    <select class="custom-select" name="especialidad" id="validationServer40" required>
                       <option selected="true"><?php echo $results["especialidad"]?></option>
                       <option disabled value="">Seleccione...</option>
                      <?php
                        foreach ($espe as $especialidad):?>
                        <option><?php echo $especialidad->idespecialidad?></option> 
                      <?php 
                        endforeach;
                      ?>                     
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
                          <option selected="true"><?php echo $results["cargo"]?></option>
                          <option disabled value="">Seleccione...</option>
                          <option>Cargo 1</option>
                          <option>Cargo 2</option>
                          <option>Cargo 3</option>
                          </select>
                          <div class="invalid-feedback">
                          <!--mensaje para feedback del campo.-->
                          </div>
                      </div>
                      <div class="col-md-3 mb-3">
                          <label for="validationServer06">Personal</label>
                          <select class="custom-select" name="personal" id="validationServer42" required>
                          <option selected="true"><?php echo $results["personal"]?></option>
                        <option disabled value="">Seleccione...</option>
                            <option>Administrativo</option>
                            <option>Medico</option>
                            <option>Asistencial</option>
                          </select>
                          <div class="invalid-feedback">
                            <!--mensaje para feedback del campo.-->
                          </div>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label for="validationServer07">Área</label>
                          <select class="custom-select" name="area" id="validationServer43" required>
                              <option selected="true"><?php echo $results["area"]?></option>
                              <option disabled value="">Seleccione...</option>
                              <option>1</option>
                              <option>2</option>
                              <option>3</option>
                              </select>
                            <div class="invalid-feedback">
                            <!--mensaje para feedback del campo.-->
                            </div>
                          </div>
                          <div class="col-md-3 mb-3">
                              <label for="validationServer07">Horario</label>
                              <select class="custom-select" name="idhorario" id="validationServer44" required>
                                  <option selected="true"><?php echo $results["idhorario"]?></option>
                                  <option disabled value="">Seleccione...</option>
                                  <option>1</option>
                                  <option>2</option>
                                  <option>3</option>
                                  </select>
                                <div class="invalid-feedback">
                                <!--mensaje para feedback del campo.-->
                                </div>
                              </div>
                  </div>  
                  <label class="font-weight-bolder mt-3">Contactos para casos de emergencia</label>
                  <hr class="mt-1 mb-4 mr-5 ">
                    <div class="form-row">
                      <div class="col-md-8 mb-3">
                        <label for="validationServer08">Nombres y Apellidos</label>
                        <input type="text" name="nombresContactoEmerg" class="form-control" value="<?php echo $results["nombresContactoEmerg"]?>"  onkeypress="return soloLetras(event)" id="validationServer26" autocomplete="off">
                      </div>
                      <div class="col-md-2 mb-3">
                          <label for="validationServer11">Teléfono Fijo</label>
                          <input type="text" name="telefonoContactoEmerg" class="form-control" value="<?php echo $results["telefonoContactoEmerg"]?>" onchange="validarTelefono('validationServer27')" maxlength="7" onkeypress="return soloNumeros(event)" id="validationServer27" autocomplete="off" required>
                          <div class="invalid-feedback">
                            Numero fijo invalido.
                          </div>
                          <div class="valid-feedback">
                            Numero fijo valido.
                          </div>
                      </div>
                      <div class="col-md-2 mb-3">
                        <label for="validationServer11">Teléfono Celular</label>
                        <input type="text" name="celularContactoEmerg" class="form-control" value="<?php echo $results["celularContactoEmerg"]?>" onchange="validarCelular('validationServer28')" maxlength="10" onkeypress="return soloNumeros(event)" id="validationServer28" autocomplete="off" required>
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
                        <input type="text" name="nombresContactoEmerg2" class="form-control" value="<?php echo $results["nombresContactoEmerg2"]?>" onkeypress="return soloLetras(event)" id="validationServer29" autocomplete="off">
                      </div>
                      <div class="col-md-2 mb-3">
                          <label for="validationServer11">Teléfono Fijo</label>
                          <input type="text" name="telefonoContactoEmerg2" class="form-control" value="<?php echo $results["telefonoContactoEmerg2"]?>" onchange="validarTelefono('validationServer30')" maxlength="7" onkeypress="return soloNumeros(event)" id="validationServer30" autocomplete="off" required>
                          <div class="invalid-feedback">
                            Numero fijo invalido.
                          </div>
                          <div class="valid-feedback">
                            Numero fijo valido.
                          </div>
                      </div>
                      <div class="col-md-2 mb-3">
                        <label for="validationServer11">Teléfono Celular</label>
                        <input type="text" name="celularContactoEmerg2" class="form-control" value="<?php echo $results["celularContactoEmerg2"]?>" onchange="validarCelular('validationServer31')" maxlength="10" onkeypress="return soloNumeros(event)" id="validationServer31" autocomplete="off" required>
                        <div class="invalid-feedback">
                            Numero celular invalido.
                          </div>
                          <div class="valid-feedback">
                            Numero celular valido.
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
                        <div class="form-row">
                          <div class="col-md-4 mb-3">
                              <label for="validationServer04">Nombres</label>
                              <input type="text" name="nombreHijo" value="<?php echo $results["nombreHijo"]?>"  class="form-control" onkeypress="return soloLetras(event)" id="validationServer14" autocomplete="off">
                          </div>
                          <div class="col-md-4 mb-3">
                              <label for="validationServer04">Apellidos</label>
                              <input type="text" name="apellidoHijo" class="form-control" value="<?php echo $results["apellidoHijo"]?>"  onkeypress="return soloLetras(event)" id="validationServer15" autocomplete="off">
                          </div>
                          <div class="col-md-2 mb-3">
                              <label for="validationServer04">Años</label>
                              <input type="text" name="anosHijo" class="form-control" value="<?php echo $results["anosHijo"]?>"  onkeypress="return soloNumeros(event)" id="validationServer16" autocomplete="off">
                          </div>
                          <div class="col-md-2 mb-3">
                              <label for="validationServer04">Meses</label>
                              <input type="text" name="mesesHijo" class="form-control" value="<?php echo $results["mesesHijo"]?>"  onkeypress="return soloNumeros(event)" id="validationServer17" autocomplete="off">
                          </div>
                      </div>
                      <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationServer04">Nombres</label>
                            <input type="text" name="nombreHijo2" class="form-control" value="<?php echo $results["nombreHijo2"]?>"  onkeypress="return soloLetras(event)" id="validationServer18" autocomplete="off">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationServer04">Apellidos</label>
                            <input type="text" name="apellidoHijo2" class="form-control" value="<?php echo $results["apellidoHijo2"]?>"  onkeypress="return soloLetras(event)" id="validationServer19" autocomplete="off">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="validationServer04">Años</label>
                            <input type="text" name="anosHijo2" class="form-control" value="<?php echo $results["anosHijo2"]?>"  onkeypress="return soloNumeros(event)" id="validationServer20" autocomplete="off">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="validationServer04">Meses</label>
                            <input type="text" name="mesesHijo2" class="form-control" value="<?php echo $results["mesesHijo2"]?>"  onkeypress="return soloNumeros(event)" id="validationServer21" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row">
                      <div class="col-md-4 mb-3">
                          <label for="validationServer04">Nombres</label>
                          <input type="text" name="nombreHijo3" class="form-control" value="<?php echo $results["nombreHijo3"]?>"  onkeypress="return soloLetras(event)" id="validationServer22" autocomplete="off">
                      </div>
                      <div class="col-md-4 mb-3">
                          <label for="validationServer04">Apellidos</label>
                          <input type="text" name="apellidoHijo3" class="form-control" value="<?php echo $results["apellidoHijo3"]?>"  onkeypress="return soloLetras(event)" id="validationServer23" autocomplete="off">
                      </div>
                      <div class="col-md-2 mb-3">
                          <label for="validationServer04">Años</label>
                          <input type="text" name="anosHijo3" class="form-control" value="<?php echo $results["anosHijo3"]?>"  onkeypress="return soloNumeros(event)" id="validationServer24" autocomplete="off">
                      </div>
                      <div class="col-md-2 mb-3">
                          <label for="validationServer04">Meses</label>
                          <input type="text" name="mesesHijo3" class="form-control" value="<?php echo $results["mesesHijo3"]?>" onkeypress="return soloNumeros(event)" id="validationServer25" autocomplete="off">
                      </div>
                    </div>
                  </div>    
                  <label class="font-weight-bolder mt-3">Descripcion de documentos que adjuntar</label>
                  <hr class="mt-1 mb-4 mr-5 ">
                    <div class="form-row">
                      <div class="col-md-12 mb-3">
                        <textarea name="documentosDescription" class="form-control" id="lugar" rows="3"><?php echo $results["documentosDescription"]?></textarea>
                      </div>        
                    </div>                            
              <hr class="mt-2 mb-3">  
              <button class="btn btn-primary mt-5" type="submit" name="btn-actualizar" id="btn-actualizar">Registrar</button>
            </form>
      </div>







    <!-- fromulario de actualización -->
    <!-- <form action="updateInformation.php" method="POST" class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-confirm-pass">Cedula</label>
            <input class="form-control" type="text" name="cedula" id="account-confirm-pass" value=<?php echo $results["cedula"] ?> readonly>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-fn">First Name</label>
            <input class="form-control" type="text" name="nombres" id="account-fn" value="<?php echo $results["nombres"] ?>">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-ln">Last Name</label>
            <input class="form-control" type="text" name="apellidos" id="account-ln" value="<?php echo $results["apellidos"] ?>">
        </div>
    </div> 
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-pass">Sexo</label>
            <input class="form-control" type="text" name="sexo" id="account-pass" value="<?php echo $results["sexo"] ?>" readonly>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-phone">Phone Number</label>
            <input class="form-control" type="text" name="telefono" id="account-phone" value="<?php echo $results["telefono"] ?>">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-email">E-mail Address</label>
            <input class="form-control" type="email" name="email" id="account-email" value="<?php echo $results["email"] ?>">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-confirm-pass">Dirección</label>
            <input class="form-control" type="text" name="direccion" id="account-confirm-pass" value="<?php echo $results["direccion"] ?>">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-confirm-pass">Nacionalidad</label>
            <input class="form-control" type="text" name="nacionalidad" id="account-confirm-pass" value="<?php echo $results["nacionalidad"] ?>" readonly>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-confirm-pass">Ciudad</label>
            <input class="form-control" type="text" name="ciudad" id="account-confirm-pass" value="<?php echo $results["ciudad"] ?>">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-confirm-pass">Fecha de nacimiento</label>
            <input class="form-control" type="text" name="fechaNacimiento" id="account-confirm-pass" value="<?php echo $results["fechaNacimiento"] ?>" readonly>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-confirm-pass">Estado Civil</label>
            <input class="form-control" type="text" name="estadoCivil" id="account-confirm-pass" value="<?php echo $results["estadoCivil"] ?>">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-confirm-pass">Horario</label>
            <input class="form-control" type="text" name="horario" id="account-confirm-pass" value="<?php echo $results["idhorario"] ?>">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-confirm-pass">N° de contrato</label>
            <input class="form-control" type="text" name="contrato" id="account-confirm-pass" value="<?php echo $results["idcontrato"] ?>" readonly>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-confirm-pass">Salario Base</label>
            <input class="form-control" type="text" name="salarioBase" id="account-confirm-pass" value="<?php echo $results["salarioBase"] ?>">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-confirm-pass">Personal</label>
            <input class="form-control" type="text" name="personal" id="account-confirm-pass" value="<?php echo $results["personal"] ?>">
        </div>
    </div>    
            <div class="col-12">
                <hr class="mt-2 mb-3">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <div class="custom-control custom-checkbox d-block"></div>
                    <button class="btn btn-style-1 btn-primary" type="submit" name="btn-actualizar" id="btn-actualizar">Guardar</button>
                </div>
            </div>
    </form> -->
<script src="../controllers/validation/validation.js"></script>     
</body>
</html>