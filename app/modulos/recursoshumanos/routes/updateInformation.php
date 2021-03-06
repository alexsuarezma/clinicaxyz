<?php
    require '../../../../database.php';
    require '../../seguridad/controllers/functions/Auditoria.php';
    session_start();
    date_default_timezone_set('America/Guayaquil');
    $id = $_SESSION['cedula'];
    
    $updated = date('d')."/".date('m')."/".date('Y')." ".date("H").":".date("i").":".date("s");

    $ciudades = $conn->query("SELECT * FROM ciudades ORDER BY nombre ASC")->fetchAll(PDO::FETCH_OBJ);
    $areas = $conn->query("SELECT * FROM area_empleados ORDER BY nombre_area ASC")->fetchAll(PDO::FETCH_OBJ);
    $especialidades = $conn->query("SELECT * FROM especialidades ORDER BY descripcion ASC")->fetchAll(PDO::FETCH_OBJ);
    
        if(!isset($_POST["btn-actualizar"])){
            $records = $conn->prepare("SELECT * FROM empleados AS e, cargo_empleados AS c, horario_empleado AS h, cargo_horario AS ch, area_empleados AS a, ciudades AS ci WHERE (e.id_cargo_horario_emp = ch.id_cargo_horario 
            AND ch.id_horario_ch = h.id_horario_empleado AND ch.id_cargo_ch = c.id_cargo AND c.id_area_cargo = a.id_area AND ci.idciudades = e.id_ciudad_emp) AND id_empleados = :cedula");  
            $records->bindParam(':cedula', $id);
            $records->execute();
            $results = $records->fetch(PDO::FETCH_ASSOC);

                if($results['medico']==1){    
                    $medico = $conn->prepare("SELECT * FROM empleados_medico AS m, especialidades AS e WHERE (m.id_especialidad_medico = e.idespecialidades) AND id_empleados_medico = :cedula");
                    $medico->bindParam(':cedula', $id);
                    $medico->execute();
                    $resultMedico = $medico->fetch(PDO::FETCH_ASSOC);     
                }
            
            $estudios = $conn->query("SELECT * FROM estudios_empleados WHERE id_empleados_est = $id")->fetchAll(PDO::FETCH_OBJ);
            $experiencia = $conn->query("SELECT * FROM expe_laboral_emp WHERE id_empleados_expe = $id")->fetchAll(PDO::FETCH_OBJ);
            $referencias = $conn->query("SELECT * FROM referencias_empleado WHERE id_empleados_refe = $id")->fetchAll(PDO::FETCH_OBJ);
            $contactos = $conn->query("SELECT * FROM contacto_emergencia WHERE id_empleados_contac = $id")->fetchAll(PDO::FETCH_OBJ);
            $hijos = $conn->query("SELECT * FROM hijos_empleados WHERE id_empleados_hijos = $id")->fetchAll(PDO::FETCH_OBJ);

            
       }else{ 
         
            $records = $conn->prepare("SELECT * FROM empleados AS e, cargo_horario AS ch WHERE e.id_cargo_horario_emp = ch.id_cargo_horario AND id_empleados = :cedula");
            $records->bindParam(':cedula', $_POST['cedula']);
            $records->execute();
            $results = $records->fetch(PDO::FETCH_ASSOC);

                  if($results['medico']==1){
                      
                      if($_POST['cargo']==22){
                        //update
                          $sql = "UPDATE empleados_medico SET id_especialidad_medico=:id_especialidad_medico WHERE id_empleados_medico=:id_empleados";
                          $stmt = $conn->prepare($sql);
                          $stmt->bindParam(':id_empleados', $_POST['cedula']);
                          $stmt->bindParam(':id_especialidad_medico', $_POST['especialidad']);
                          $stmt->execute();
                      }else{
                            //delete
                            $sql = "DELETE FROM empleados_medico WHERE id_empleados_medico=:id_empleados";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':id_empleados', $_POST['cedula']);
                            $stmt->execute();

                            $sql = "UPDATE empleados SET medico=:medico WHERE id_empleados=:id_empleados";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':id_empleados', $_POST['cedula']);
                            $stmt->bindValue(':medico', 0, PDO::PARAM_INT);
                            $stmt->execute();

                        }
                      
                  }else{
                      //INSERT
                      if($_POST['cargo'] == 22){
                          $sql = "INSERT INTO empleados_medico 
                          (id_empleados_medico,id_especialidad_medico) VALUES (:id_empleados_medico,:id_especialidad_medico)";                    
                          $stmt = $conn->prepare($sql);
                          $stmt->bindParam(':id_especialidad_medico',$_POST["especialidad"]);
                          $stmt->bindParam(':id_empleados_medico',$_POST["cedula"]);
                          $stmt->execute();
                          
                          //medico = 1
                          $sql = "UPDATE empleados SET medico=:medico WHERE id_empleados=:id_empleados";
                          $stmt = $conn->prepare($sql);
                          $stmt->bindParam(':id_empleados', $_POST['cedula']);
                          $stmt->bindValue(':medico', 1, PDO::PARAM_INT);
                          $stmt->execute();
                      }
                  }
              
              //BUSCAR CREDENCIALBASE DEL CARGO NUEVO
              $credencialCargoNuevo = $conn->prepare('SELECT id_credencialbase_cargo FROM cargo_empleados WHERE id_cargo = :id_cargo');
              $credencialCargoNuevo->bindParam(':id_cargo',$_POST['cargo']);
              $credencialCargoNuevo->execute();
              $resultadoCredencialNuevo = $credencialCargoNuevo->fetch(PDO::FETCH_ASSOC);

              //BUSCAR CREDENCIALBASE DEL CARGO ANTERIOR
              $credencialCargoAnterior = $conn->prepare('SELECT id_credencialbase_cargo FROM cargo_empleados WHERE id_cargo = :id_cargo');
              $credencialCargoAnterior->bindParam(':id_cargo',$results['id_cargo_ch']);
              $credencialCargoAnterior->execute();
              $resultadoCredencialAnterior = $credencialCargoAnterior->fetch(PDO::FETCH_ASSOC);

              if($resultadoCredencialNuevo['id_credencialbase_cargo'] != $resultadoCredencialAnterior['id_credencialbase_cargo']){

                    //BUSCAR CREDENCIAL ANTERIOR EN USUARIO_CREDENCIAL CON EL ID_USUARIO_EMP
                    $credencialBase = $conn->query("SELECT * FROM usuario_credencial WHERE id_usuario_uc =".$results['id_usuario_emp']." AND id_credencialbase_uc =".$resultadoCredencialAnterior['id_credencialbase_cargo'])->rowCount();

                    if($credencialBase>0){
                      //CAMBIAR USUARIO/CREDENCIAL en donde el id del usuario empleado y la credencial base anterior sean 
                      $sql = "UPDATE usuario_credencial SET id_credencialbase_uc=:id_credencialbase_uc WHERE id_usuario_uc=:id_usuario_uc AND id_credencialbase_uc=:id_cargo_emp";
                      $stmt = $conn->prepare($sql);
                      $stmt->bindParam(':id_usuario_uc', $results['id_usuario_emp']);
                      $stmt->bindParam(':id_credencialbase_uc', $resultadoCredencialNuevo['id_credencialbase_cargo']);
                      $stmt->bindParam(':id_cargo_emp',$resultadoCredencialAnterior['id_credencialbase_cargo']);
                      $stmt->execute();
                    }else{
                      //SI NO EXISTE UNA CREDENCIAL PARA ESE USUARIO CON ESA CREDENCIAL BASE YA ANEXADA
                      $sql = "INSERT INTO usuario_credencial (id_usuario_uc,id_credencialbase_uc) VALUES 
                      (:id_usuario_uc,:id_credencialbase_uc)";
                      $stmt = $conn->prepare($sql);
                      $stmt->bindParam(':id_usuario_uc', $results['id_usuario_emp']);
                      $stmt->bindParam(':id_credencialbase_uc', $resultadoCredencialNuevo['id_credencialbase_cargo']);
                      $stmt->execute();
                    }                 
              }
            

              //UPDATE EMPLEADO
                $sql = "UPDATE empleados SET nombres=:nombres,apellidos=:apellidos,direccion=:direccion,nacionalidad=:nacionalidad,fecha_nacimiento=:fecha_nacimiento,parroquia=:parroquia,
                id_ciudad_emp=:id_ciudad_emp,telefono=:telefono,celular=:celular,email=:email,sexo=:sexo,estado_civil=:estado_civil,nombres_conyuge=:nombres_conyuge,apellidos_conyuge=:apellidos_conyuge,
                id_cargo_horario_emp=:id_cargo_horario_emp,update_at=:update_at WHERE id_empleados=:id_empleados";
                $stmt = $conn->prepare($sql);

                $stmt->bindParam(':id_empleados', $_POST['cedula']);
                // $stmt->bindValue(':profileimage', null, PDO::PARAM_INT);
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
                $stmt->bindValue(':update_at', $updated);
                $stmt->bindParam(':id_cargo_horario_emp',$_POST['horario']);
                


            try{
                if($stmt->execute()){

                      for($i=1;$i<=$_POST['hijosGet'];$i++){
                        //Actualizar en la tabla hijos_empleados
                          $sql = "UPDATE hijos_empleados SET nombres_hijo=:nombres_hijo,apellidos_hijo=:apellidos_hijo,anos_hijo=:anos_hijo,meses_hijo=:meses_hijo WHERE id_hijosemple=:id_hijosemple";
                          $stmt = $conn->prepare($sql);
                          $stmt->bindParam(':nombres_hijo',$_POST["nombreHijoup$i"]);
                          $stmt->bindParam(':apellidos_hijo',$_POST["apellidoHijoup$i"]);
                          $stmt->bindParam(':anos_hijo',$_POST["anosHijoup$i"]);
                          $stmt->bindParam(':meses_hijo',$_POST["mesesHijoup$i"]);
                          $stmt->bindParam(':id_hijosemple',$_POST["idHijo$i"]);
                          $stmt->execute();
                      }

                      if($_POST['numeroHijos']>1){
                          for($i=1;$i<$_POST['numeroHijos'];$i++){
                            $rowHijo = $i+1;
                            //Insertar nuevo hijo del empleado en la tabla hijos_empleados
                            $sql = "INSERT INTO hijos_empleados 
                            (nombres_hijo,apellidos_hijo,anos_hijo,meses_hijo,id_empleados_hijos) VALUES (:nombres_hijo,:apellidos_hijo,:anos_hijo,:meses_hijo,:id_empleados_hijos)"; 
                              $stmt = $conn->prepare($sql);
                              $stmt->bindParam(':nombres_hijo',$_POST["nombreHijo$rowHijo"]);
                              $stmt->bindParam(':apellidos_hijo',$_POST["apellidoHijo$rowHijo"]);
                              $stmt->bindParam(':anos_hijo',$_POST["anosHijo$rowHijo"]);
                              $stmt->bindParam(':meses_hijo',$_POST["mesesHijo$rowHijo"]);
                              $stmt->bindParam(':id_empleados_hijos',$_POST["cedula"]);
                              $stmt->execute();
                          }
                      }

                      for($i=1;$i<=2;$i++){
                        //Insertar en la tabla antecedentesAcademicos
                        $sql = "UPDATE contacto_emergencia SET nombres_contacemergencia=:nombres_contacemergencia,apellidos_contacemergencia=:apellidos_contacemergencia,telefono_contacemergencia=:telefono_contacemergencia,celular_contacemergencia=:celular_contacemergencia WHERE id_contacemergencia=:id_contacemergencia";                    
                        $stmt = $conn->prepare($sql);                              
                        $stmt->bindParam(':nombres_contacemergencia',$_POST["nombresContactoEmerg$i"]);
                        $stmt->bindParam(':apellidos_contacemergencia',$_POST["apellidosContactoEmerg$i"]);
                        $stmt->bindParam(':telefono_contacemergencia',$_POST["telefonoContactoEmerg$i"]);
                        $stmt->bindParam(':celular_contacemergencia',$_POST["celularContactoEmerg$i"]);
                        $stmt->bindParam(':id_contacemergencia', $_POST["idContac$i"]);
                        $stmt->execute();
                      }
                      
                      for($i=1;$i<=4;$i++){
                        //Update en la tabla referencias_empleado
                        $sql = "UPDATE referencias_empleado SET nombres_refe=:nombres_refe,apellidos_refe=:apellidos_refe,telefono_refe=:telefono_refe,celular_refe=:celular_refe WHERE id_refeemp=:id_refeemp";                    
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':nombres_refe',$_POST["nombresRefe$i"]);
                        $stmt->bindParam(':apellidos_refe',$_POST["apellidosRefe$i"]);
                        $stmt->bindParam(':telefono_refe',$_POST["telefonoRefe$i"]);
                        $stmt->bindParam(':celular_refe',$_POST["celularRefe$i"]);
                        $stmt->bindParam(':id_refeemp', $_POST["idRefe$i"]);
                        $stmt->execute();
                      }

                      for($i=1;$i<=$_POST['countAcademico'];$i++){
                        //Insertar en la tabla antecedentesAcademicos
                        $sql = "UPDATE estudios_empleados SET titulo_estudiosempleados=:titulo_estudiosempleados,institucion_estudiosempleados=:institucion_estudiosempleados,fecha_ingreso=:fecha_ingreso,fecha_egreso=:fecha_egreso WHERE id_estudiosempleados=:id_estudiosempleados";                    
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':titulo_estudiosempleados',$_POST["titulo$i"]);
                        $stmt->bindParam(':institucion_estudiosempleados',$_POST["institucion$i"]);
                        $stmt->bindParam(':fecha_ingreso',$_POST["anoIngreso$i"]);
                        $stmt->bindParam(':fecha_egreso',$_POST["anoEgreso$i"]);
                        $stmt->bindParam(':id_estudiosempleados', $_POST["idAcadem$i"]);
                        $stmt->execute();
                      }

                      for($i=1;$i<=$_POST["countExperiencia"];$i++){
                        //Insertar en la tabla experiencia laboral
                        $sql = "UPDATE expe_laboral_emp SET nombre_emp=:nombre_emp,naturaleza_emp=:naturaleza_emp,direccion=:direccion,cargo=:cargo,anos=:anos,meses=:meses WHERE id_expeemp=:id_expeemp";                    
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':nombre_emp',$_POST["empresa$i"]);
                        $stmt->bindParam(':naturaleza_emp',$_POST["naturalezaEmpresa$i"]);
                        $stmt->bindParam(':direccion',$_POST["direccion$i"]);
                        $stmt->bindParam(':cargo',$_POST["cargo$i"]);
                        $stmt->bindParam(':anos',$_POST["ano$i"]);
                        $stmt->bindParam(':meses',$_POST["meses$i"]);
                        $stmt->bindParam(':id_expeemp', $_POST["idExpe$i"]);
                        $stmt->execute();
                      }
                    $auditoria = new Auditoria(utf8_decode('Actualización'), 'rrhh',utf8_decode("Se actualizo información del perfil ".$results['nombres']." ".$results['apellidos'].", cedula: ".$_SESSION['cedula']),$_SESSION['user_id'],null);
                    $auditoria->Registro($conn);
                    header("Location:profile.php?id=$id");                          
                }
            } catch (PDOException $e) {
                die('Problema: ' . $e->getMessage());
            }
          
       }

?>
<!DOCTYPE html>
<html lang="es">
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
                        <input type="text" name="cedula" value="<?php echo $results["id_empleados"]?>" class="form-control" id="validationServer01" readonly>
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
                      <input type="date" name="fechaNacimiento" value="<?php echo $results["fecha_nacimiento"]?>"  class="form-control" id="validationServer06" required>
                      <div class="invalid-feedback">
                        <!--mensaje para feedback del campo.-->
                      </div>
                    </div>
                  </div>
              <div class="form-row">
                <div class="col-md-6 mb-3">
                  <label for="validationServer03">Parroquia</label>
                  <input type="text" name="parroquia" class="form-control" value="<?php echo $results["parroquia"]?>"  id="validationServer07" autocomplete="off" required>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="validationServer14">Ciudad</label>
                    <select class="custom-select" name="ciudad" id="validationServer08" required>
                        <option selected="true" value="<?php echo $results['idciudades'];?>"><?php echo $results['nombre']?></option>
                        <option disabled value="">Seleccione...</option>
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
                    <option selected="true"><?php echo $results["estado_civil"]?></option>
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
                <?php
                $countAcadem = 0;
                    foreach ($estudios as $estudiosEmpleado):
                      $countAcadem++;
                ?>       
                      <input name="idAcadem<?php echo $countAcadem;?>" style="display:none;" id="idAcadem" value="<?php echo $estudiosEmpleado->id_estudiosempleados;?>">
                        <div class="form-row">
                          <div class="col-md-6 mb-3">
                            <label for="validationServer08">Título / Profesión</label>
                            <input type="text" name="titulo<?php echo $countAcadem;?>" class="form-control" value="<?php echo $estudiosEmpleado->titulo_estudiosempleados?>" onkeypress="return soloLetras(event)" id="validationServer32" autocomplete="off" required>
                          </div>
                          <div class="col-md-6 mb-3">

                              <label for="validationServer11">Institución</label>
                              <input type="text" name="institucion<?php echo $countAcadem;?>" class="form-control" value="<?php echo $estudiosEmpleado->institucion_estudiosempleados?>" onkeypress="return soloLetras(event)" id="validationServer33" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-row">
                          <div class="col-md-6 mb-3">
                            <label for="validationServer16">Año de Ingreso</label>
                            <input type="date" name="anoIngreso<?php echo $countAcadem;?>" class="form-control" value="<?php echo $estudiosEmpleado->fecha_ingreso?>" id="validationServer35" required>
                            <div class="invalid-feedback">
                              <!--mensaje para feedback del campo.-->
                            </div>
                          </div>
                          <div class="col-md-6 mb-3">
                            <label for="validationServer16">Año de Egreso</label>
                            <input type="date" name="anoEgreso<?php echo $countAcadem;?>" class="form-control" value="<?php echo $estudiosEmpleado->fecha_egreso?>" id="validationServer36" required>
                              <div class="invalid-feedback">
                                  <!--mensaje para feedback del campo.-->
                              </div>
                          </div>    
                        </div>
                      
                    <hr class="mt-1 mb-4 mr-5">
                <?php 
                    endforeach;
                ?>    
                <input style="display:none;" name="countAcademico" value="<?php echo $countAcadem;?>">
                <label class="font-weight-bolder mt-3">Experiencia laboral</label>
                <hr class="mt-1 mb-4 mr-5 ">
                <?php
                $countExpe = 0;
                    foreach ($experiencia as $expeEmpleado):
                      $countExpe++;
                ?>
                    
                    <div class="form-row">
                    <input name="idExpe<?php echo $countExpe;?>" style="display:none;" id="idAcadem" value="<?php echo $expeEmpleado->id_expeemp;?>">
                        <div class="col-md-4 mb-3">
                          <label for="validationServer08">Empresa</label>
                          <input type="text" name="empresa<?php echo $countExpe;?>" class="form-control" value="<?php echo $expeEmpleado->nombre_emp?>" onkeypress="return soloLetras(event)" id="validationServer32" autocomplete="off" required>
                        </div>
                        <div class="col-md-5 mb-3">
                          <label for="validationServer16">Dirección</label>
                          <input type="text" name="direccion<?php echo $countExpe;?>" class="form-control" value="<?php echo $expeEmpleado->direccion?>" id="validationServer35" required>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label for="validationServer16">Cargo</label>
                          <input type="text" name="cargo<?php echo $countExpe;?>" class="form-control" id="validationServer36" value="<?php echo $expeEmpleado->cargo?>" onkeypress="return soloLetras(event)" required>
                        </div>    
                        <div class="col-md-2 mb-3">
                          <label for="validationServer16">Años</label>
                          <input type="text" name="ano<?php echo $countExpe;?>" class="form-control" value="<?php echo $expeEmpleado->anos?>" onkeypress="return soloNumeros(event)" maxlength="2" id="validationServer36" required>
                        </div>  
                        <div class="col-md-2 mb-3">
                          <label for="validationServer16">Meses</label>
                          <input type="text" name="meses<?php echo $countExpe;?>" class="form-control" value="<?php echo $expeEmpleado->meses?>" onchange="soloMeses(this);" onkeypress="return soloNumeros(event)" maxlength="2" id="validationServer36" required>
                          <div class="invalid-feedback">
                              Debes colocar un rango de 12 meses.
                          </div>
                          <div class="valid-feedback">
                              Correcto.
                          </div> 
                        </div>  
                        <div class="col-md-5 mb-3 mr-3">
                          <label for="validationServer11">Naturaleza de la Empresa</label>
                          <input type="text" name="naturalezaEmpresa<?php echo $countExpe;?>" class="form-control" value="<?php echo $expeEmpleado->naturaleza_emp?>" onkeypress="return soloLetras(event)" id="validationServer33" autocomplete="off" required>
                        </div>
                    </div>
                <hr class="mt-1 mb-4 mr-5">
                <?php 
                    endforeach;
                ?>  
                <input style="display:none;" name="countExperiencia" value="<?php echo $countExpe;?>">  
                <label class="font-weight-bolder mt-3">Referencias</label>
                <hr class="mt-1 mb-4 mr-5 ">
                <?php
                  $countRefe = 0;
                    foreach ($referencias as $referenciasEmpleado):
                      $countRefe++;
                ?>
                <?php
                    if($referenciasEmpleado->tipo_refe == 1){
                        echo '<label class="font-weight-bolder mt-1 ml-2">Personal</label>';
                    }else{
                        echo '<label class="font-weight-bolder mt-1 ml-2">Laboral</label>';
                    }
                ?>
                  <div class="form-row">
                  <input name="idRefe<?php echo $countRefe;?>" style="display:none;" id="idRefe" value="<?php echo $referenciasEmpleado->id_refeemp;?>">
                    <div class="col-md-4 mb-3">
                      <label for="validationServer08">Nombres</label>
                      <input type="text" name="nombresRefe<?php echo $countRefe?>" class="form-control" value="<?php echo $referenciasEmpleado->nombres_refe?>" id="validationServer37" onkeypress="return soloLetras(event)" autocomplete="off" required>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="validationServer08">Apellidos</label>
                      <input type="text" name="apellidosRefe<?php echo $countRefe?>" class="form-control" id="validationServer37" value="<?php echo $referenciasEmpleado->apellidos_refe?>" onkeypress="return soloLetras(event)" autocomplete="off" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="validationServer11">N° de teléf.</label>
                        <input type="text" name="telefonoRefe<?php echo $countRefe?>" class="form-control" value="<?php echo $referenciasEmpleado->telefono_refe?>" onchange="validarTelefono('referenciatel<?php echo $countRefe?>')"  onkeypress="return soloNumeros(event)" maxlength="7" id="referenciatel<?php echo $countRefe?>" autocomplete="off" required>
                        <div class="invalid-feedback">
                            Numero fijo invalido.
                          </div>
                          <div class="valid-feedback">
                            Numero fijo valido.
                          </div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="validationServer11">N° celular</label>
                        <input type="text" name="celularRefe<?php echo $countRefe?>" class="form-control" value="<?php echo $referenciasEmpleado->celular_refe?>" onchange="validarCelular('referenciacel<?php echo $countRefe?>')" onkeypress="return soloNumeros(event)" maxlength="10" id="referenciacel<?php echo $countRefe?>" autocomplete="off" required>
                        <div class="invalid-feedback">
                          Numero celular invalido.
                        </div>
                        <div class="valid-feedback">
                          Numero celular valido.
                        </div>
                    </div>
                  </div>
                <?php 
                    endforeach;
                ?>  
                 <?php if($results['medico']==1): ?>  
                    <label class="font-weight-bolder mt-3">MEDICO ESPECIALISTA <span class="badge badge-info"> #MEDICO</span></label>
                    <hr class="mt-1 mb-4 mr-5">
                      <div class="form-row">
                          <div class="col-md-4 mb-3">
                              <label for="validationServer02">Especialidad</label>
                              <select class="custom-select" name="especialidad" id="row-especialidad" required>
                              <option selected="true" value="<?php echo $resultMedico['idespecialidades'];?>"><?php echo utf8_encode($resultMedico["descripcion"]);?></option>  
                              <option disabled value="">Seleccione...</option>
                              <?php
                              foreach ($especialidades as $especialidadEmpleado):
                              ?>
                                <option value="<?php echo $especialidadEmpleado->idespecialidades;?>"><?php echo utf8_encode($especialidadEmpleado->descripcion);?></option>
                              <?php 
                                endforeach;
                              ?>  
                              </select>
                              <div class="valid-feedback">
                                  EL PERSONAL ES MEDICO. PORFAVOR, ESCOGE UNA ESPECIALIDAD...
                              </div>
                        </div>
                      </div>   
                 <?php else: ?>
                    <label class="font-weight-bolder mt-3">Especialidad <span class="badge badge-warning"> #NO ES MEDICO, si actualizas a personal Medico deberas escoger especialidad *</span></label>
                        <hr class="mt-1 mb-4 mr-5">
                        <div class="form-row">
                          <div class="col-md-4 mb-3">
                            <label for="validationServer09">Especialidad</label>
                            <select class="custom-select" name="especialidad" id="row-especialidad" required disabled="true">
                              <option selected disabled value="">Seleccione...</option>
                              <?php
                              foreach ($especialidades as $especialidadEmpleado):
                              ?>
                                <option value="<?php echo $especialidadEmpleado->idespecialidades;?>"><?php echo utf8_encode($especialidadEmpleado->descripcion);?></option>
                              <?php 
                                endforeach;
                              ?>  
                            </select>
                            <div class="valid-feedback">
                                EL EMPLEADO AHORA SERA MEDICO. PORFAVOR, ESCOGE UNA ESPECIALIDAD...
                            </div>
                          </div>
                        </div>
                <?php endif; ?>
                
                <label class="font-weight-bolder mt-3">Información ocupacional</label>
                <hr class="mt-1 mb-4 mr-5 ">
                <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="area">Área</label>
                            <select class="custom-select" name="area" id="area" required>
                            <option selected="true" value="<?php echo $results['id_area'];?>"><?php echo utf8_encode($results["nombre_area"])?></option>
                                <option disabled value="">Seleccione...</option>
                                <?php
                                 foreach ($areas as $areaEmpleado):
                                ?>
                                <option value="<?php echo $areaEmpleado->id_area;?>"><?php echo utf8_encode($areaEmpleado->nombre_area);?></option>
                                <?php 
                                  endforeach;
                                ?> 
                                </select>
                        </div>
                        <div class="col-md-6 mb-3" id="objeto">
                            <label for="cargo">Cargo</label>
                            <select class="custom-select" name="cargo" id="cargo" required>
                            <option selected="true" value="<?php echo $results['id_cargo'];?>"><?php echo utf8_encode($results['nombre_cargo'])?></option>
                            <option disabled value="">Seleccione...</option>
                            </select>
                        </div>
                  </div>  
                  <div class="form-row" id="sueldo">
                    <div class="col-md-5 mb-3">
                        <label for="validationServer11">Salario base</label>
                        <input type="text" name="salarioBase" class="form-control" value="<?php echo $results["sueldo_base_cargo"]?>" readonly required>
                    </div>
                    <div class="col-md-5 mb-3">
                    <label for="horario">Jornada</label>
                      <select class="custom-select" name="horario" id="horario" required>
                          <option selected="true" value="<?php echo $results['id_cargo_horario'];?>"><?php echo utf8_encode($results['jornada'])?></option>
                          <option disabled value="">Seleccione...</option>
                      </select>
                    </div>  
                    </div>
                <div class="form-row" id="jornadaHora">
                  <div class="col-md-5 mb-3">
                      <label for="validationServer07">Hora Entrada</label>
                      <input type="text" class="form-control" name="" id="validationServer44" value="<?php echo $results["inicio"]?>" readonly>
                  </div>
                  <div class="col-md-5 mb-3">
                      <label for="validationServer07">Hora Salida</label>
                      <input type="text" class="form-control" name="" id="validationServer44" value="<?php echo $results["finalizacion"]?>" readonly>
                  </div> 
                </div>
                <div class="form-row">
                  <div class="col-md-5 mb-3">
                    <label for="validationServer08">Fecha ingreso</label>
                    <input type="text" name="created_at" value="<?php echo $results["created_at"]?>" class="form-control" id="validationServer37" readonly>
                  </div>
                </div>
                <label class="font-weight-bolder mt-3">Contactos para casos de emergencia</label>
                <hr class="mt-1 mb-4 mr-5 ">
                <?php
                    $cont = 1;
                    foreach ($contactos as $contactosEmpleado):
                ?>
                  <div class="form-row">
                  <input name="idContac<?php echo $cont;?>" style="display:none;" id="idContac" value="<?php echo $contactosEmpleado->id_contacemergencia;?>">
                    <div class="col-md-4 mb-3">
                      <label for="validationServer08">Nombres</label>
                      <input type="text" name="nombresContactoEmerg<?php echo $cont;?>" class="form-control" value="<?php echo $contactosEmpleado->nombres_contacemergencia?>" onkeypress="return soloLetras(event)" id="validationServer26" autocomplete="off">
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="validationServer08">Apellidos</label>
                      <input type="text" name="apellidosContactoEmerg<?php echo $cont;?>" class="form-control" value="<?php echo $contactosEmpleado->apellidos_contacemergencia?>" onkeypress="return soloLetras(event)" id="validationServer26" autocomplete="off">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="validationServer11">Teléfono Fijo</label>
                        <input type="text" name="telefonoContactoEmerg<?php echo $cont;?>" class="form-control" value="<?php echo $contactosEmpleado->telefono_contacemergencia?>" onchange="validarTelefono('validationServer27')" maxlength="7" onkeypress="return soloNumeros(event)" id="validationServer27" autocomplete="off" required>
                        <div class="invalid-feedback">
                          Numero fijo invalido.
                        </div>
                        <div class="valid-feedback">
                          Numero fijo valido.
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                      <label for="validationServer11">Teléfono Celular</label>
                      <input type="text" name="celularContactoEmerg<?php echo $cont;?>" class="form-control" value="<?php echo $contactosEmpleado->celular_contacemergencia?>" onchange="validarCelular('validationServer28')" maxlength="10" onkeypress="return soloNumeros(event)" id="validationServer28" autocomplete="off" required>
                      <div class="invalid-feedback">
                        Numero celular invalido.
                      </div>
                      <div class="valid-feedback">
                        Numero celular valido.
                      </div>
                    </div>
                  </div>
                <?php 
                  $cont++;
                  endforeach;
                ?>
              <?php if(empty($hijos)): ?>  
                <div class="form-row">
                    <div class="col-md-9">
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
                            <div class="col-md-3"></div>
                            <div class="col-md-3"></div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2"></div>
                            <div class="col-md-1"><i class="fa fa-plus-circle mt-4" name="add" id="add" aria-hidden="true" style="cursor:pointer; font-size:25px;" title="agregar"></i></div>   
                            <div class="col-md-1"><i class="fa fa-minus-circle mt-4" name="remove" id="remove" aria-hidden="true" style="cursor:pointer; font-size:25px;" title="eliminar"></i></button></div>
                  </div>                      
                      <?php
                          $hijoGet = 0;
                          foreach ($hijos as $hijosEmpleado):
                            $hijoGet++;
                      ?>
                        <div class="form-row">
                            <div class="col-md-3 mb-3">
                                <label for="validationServer04">Nombres</label>
                                <input type="text" name="nombreHijo<?php echo $hijoGet;?>" class="form-control" value="<?php echo $hijosEmpleado->nombres_hijo?>" onkeypress="return soloLetras(event)" id="validationServer14" autocomplete="off">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="validationServer04">Apellidos</label>
                                <input type="text" name="apellidoHijo<?php echo $hijoGet;?>" class="form-control" value="<?php echo $hijosEmpleado->apellidos_hijo?>" onkeypress="return soloLetras(event)" id="validationServer15" autocomplete="off">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="validationServer04">Años</label>
                                <input type="text" name="anosHijo<?php echo $hijoGet;?>" class="form-control" value="<?php echo $hijosEmpleado->anos_hijo?>" onkeypress="return soloNumeros(event)" maxlength="2" id="validationServer16" autocomplete="off">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="validationServer04">Meses</label>
                                <input type="text" name="mesesHijo<?php echo $hijoGet;?>" onchange="soloMeses(this);" class="form-control" value="<?php echo $hijosEmpleado->meses_hijo?>" onkeypress="return soloNumeros(event)" maxlength="2" id="validationServer17" autocomplete="off">
                                <div class="invalid-feedback">
                                    Debes colocar un rango de 12 meses.
                                </div>
                                <div class="valid-feedback">
                                    Correcto.
                                </div> 
                            </div>
                            <div onclick="window.location='../controllers/deleteRows.php?ced=<?php echo $id;?>&id=<?php echo $hijosEmpleado->id_hijosemple;?>&table=hijos_empleados&nameId=id_hijosemple';" class="col-md-1"><i class="fa fa-trash mt-4" name="remove-deleted" id="remove-deleted" aria-hidden="true" style="cursor:pointer; font-size:25px;" title="Eliminar fila"></i></button></div>
                        </div>
                      <?php 
                          endforeach;
                      ?>   
                        <input name="hijosGet" style="display:none;" id="hijosGet" value="<?php echo $hijoGet;?>">
                        <input name="numeroHijos" style="display:none;" id="numeroHijos" value="<?php echo 1;?>">
                        <!-- <button name="enviar" id="enviar">enviar</button> -->
                  </div>
                </div>  
              <?php else: ?>
                    <label class="font-weight-bolder mt-3">Hijos</label>
                    <hr class="mt-1 mr-5 ">
                    <div id="radio-hijos" class="form-group shadow-sm p-3 bg-white rounded">
                      <div class=""id="dynamic_field">
                      <div class="form-row">
                                <div class="col-md-3"></div>
                                <div class="col-md-3"></div>
                                <div class="col-md-2"></div>
                                <div class="col-md-2"></div>
                                <div class="col-md-1"><i class="fa fa-plus-circle mt-4" name="add" id="add" aria-hidden="true" style="cursor:pointer; font-size:25px;" title="agregar"></i></div>   
                                <div class="col-md-1"><i class="fa fa-minus-circle mt-4" name="remove" id="remove" aria-hidden="true" style="cursor:pointer; font-size:25px;" title="eliminar"></i></button></div>
                      </div>                      
                          <?php
                              $hijoGet = 0;
                              foreach ($hijos as $hijosEmpleado):
                                $hijoGet++;
                          ?>
                            <div class="form-row">
                            <input name="idHijo<?php echo $hijoGet;?>" style="display:none;" id="idHijo" value="<?php echo $hijosEmpleado->id_hijosemple;?>">
                                <div class="col-md-3 mb-3">
                                    <label for="validationServer04">Nombres</label>
                                    <input type="text" name="nombreHijoup<?php echo $hijoGet;?>" class="form-control" value="<?php echo $hijosEmpleado->nombres_hijo?>" onkeypress="return soloLetras(event)" id="validationServer14" autocomplete="off">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="validationServer04">Apellidos</label>
                                    <input type="text" name="apellidoHijoup<?php echo $hijoGet;?>" class="form-control" value="<?php echo $hijosEmpleado->apellidos_hijo?>" onkeypress="return soloLetras(event)" id="validationServer15" autocomplete="off">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="validationServer04">Años</label>
                                    <input type="text" name="anosHijoup<?php echo $hijoGet;?>" class="form-control" value="<?php echo $hijosEmpleado->anos_hijo?>" onkeypress="return soloNumeros(event)" maxlength="2" id="validationServer16" autocomplete="off">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="validationServer04">Meses</label>
                                    <input type="text" name="mesesHijoup<?php echo $hijoGet;?>" onchange="soloMeses(this);" class="form-control" value="<?php echo $hijosEmpleado->meses_hijo?>" onkeypress="return soloNumeros(event)" maxlength="2" id="validationServer17" autocomplete="off">
                                    <div class="invalid-feedback">
                                        Debes colocar un rango de 12 meses.
                                    </div>
                                    <div class="valid-feedback">
                                        Correcto.
                                    </div> 
                                </div>
                                <div onclick="window.location='../controllers/deleteRows.php?ced=<?php echo $id;?>&id=<?php echo $hijosEmpleado->id_hijosemple;?>&table=hijos_empleados&nameId=id_hijosemple';" class="col-md-1"><i class="fa fa-trash mt-4" name="remove-deleted" id="remove-deleted" aria-hidden="true" style="cursor:pointer; font-size:25px;" title="Eliminar fila"></i></button></div>
                            </div>
                          <?php 
                              endforeach;
                          ?>   
                            <input name="hijosGet" id="hijosGet" style="display:none;" value="<?php echo $hijoGet;?>">
                            <input name="numeroHijos" id="numeroHijos" style="display:none;" value="<?php echo 1;?>">
                            <!-- <button name="enviar" id="enviar">enviar</button> -->
                      </div>
                    </div>  
              <?php endif; ?>
                  <label class="font-weight-bolder mt-3">Descripcion de documentos que adjuntar</label>
                  <hr class="mt-1 mb-4 mr-5 ">
                    <div class="form-row">
                      <div class="col-md-12 mb-3">
                        <textarea name="documentosDescription" class="form-control" id="lugar" rows="3"><?php echo $results["documentos_descripcion"]?></textarea>
                      </div>        
                    </div>                            
              <hr class="mt-2 mb-3">  
              <button class="btn btn-primary mt-5" type="submit" name="btn-actualizar" id="btn-actualizar">Guardar cambios</button>
            </form>
      </div>  
<script src="../controllers/validation/validation.js"></script>
<script type="text/javascript" src="../components/scripts/jquery.min.js"></script>    
<script type="text/javascript" src="../components/scripts/consultas.js"></script>         
</body>
</html>