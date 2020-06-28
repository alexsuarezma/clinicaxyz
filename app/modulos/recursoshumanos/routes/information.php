<?php
    require '../../../../database.php';
    session_start();

    $id = $_SESSION['cedula'];    
            $records = $conn->prepare("SELECT * FROM empleados AS e, cargo_empleados AS c, personal_empleados AS p, area_empleados AS a, ciudades AS ci WHERE (c.id_cargo = e.id_cargo_emp AND p.id_personal = e.id_personal_emp AND a.id_area = e.id_area_emp AND ci.idciudades = e.id_ciudad_emp) AND id_empleados = :cedula");
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
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <div class="container mb-5 shadow-sm p-3 bg-white rounded">
            <label class="font-weight-bolder">Datos Personales</label>
            <hr class="mt-1 mb-4 mr-5 ">
            <div class="form-row">
                <div class="col-md-6 mb-3">
                <label for="validationServer01">Numero de cedula</label>
                <input type="text" name="cedula" class="form-control"  value="<?php echo $results["id_empleados"] ?>" disabled="">
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
                    <input type="text" name="apellidos" class="form-control"  value="<?php echo $results["fecha_nacimiento"] ?>" disabled="">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationServer01">Parroquia</label>
                    <input type="text" name="nombres" class="form-control" value="<?php echo $results["parroquia"]?>" disabled="">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationServer02">Ciudad</label>
                    <input type="text" name="apellidos" class="form-control"  value="<?php echo $results['nombre'] ?>" disabled="">
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
                    <input type="text" name="apellidos" class="form-control"  value="<?php echo $results["estado_civil"] ?>" disabled="">
                </div>
            </div>
            <label class="font-weight-bolder mt-3">Antecedentes acádemicos y profesionales</label>
            <hr class="mt-1 mb-4 mr-5">
                <?php
                    foreach ($estudios as $estudiosEmpleado):
                ?>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationServer01">Titulo / Profesión</label>
                            <input type="text" name="nombres" class="form-control" value="<?php echo $estudiosEmpleado->titulo_estudiosempleados?>" disabled="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationServer02">Institución</label>
                            <input type="text" name="apellidos" class="form-control"  value="<?php echo $estudiosEmpleado->institucion_estudiosempleados?>" disabled="">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationServer02">Año de ingreso</label>
                            <input type="text" name="apellidos" class="form-control" value="<?php echo $estudiosEmpleado->fecha_ingreso?>" disabled="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationServer02">Año de Egreso</label>
                            <input type="text" name="apellidos" class="form-control" value="<?php echo $estudiosEmpleado->fecha_egreso?>" disabled="">
                        </div>
                    </div>
                    <hr class="mt-1 mb-4 mr-5">
                <?php 
                    endforeach;
                ?>    
                <?php if($results['medico']==1): ?>  
                    <label class="font-weight-bolder mt-3">MEDICO ESPECIALISTA <span class="badge badge-info"> #MEDICO</span></label>
                    <hr class="mt-1 mb-4 mr-5">
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationServer02">Especialidad</label>
                            <input type="text" name="apellidos" class="form-control" value="<?php echo utf8_encode($resultMedico["descripcion"])?>" disabled="">
                        </div>
                    </div>          
                <?php endif; ?>
         
            <label class="font-weight-bolder mt-3">Información ocupacional</label>
            <hr class="mt-1 mb-4 mr-5">
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="validationServer02">Fecha Ingreso</label>
                    <input type="text" name="apellidos" class="form-control" value="<?php echo $results["created_at"]?>" disabled="">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationServer02">Salario Base</label>
                    <input type="text" name="apellidos" class="form-control" value="<?php echo $results["salario_base"]?>" disabled="">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationServer02">Contrato</label>
                    <input type="text" name="apellidos" class="form-control" value="<?php echo $results["idcontrato"]?>" disabled="">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <label for="validationServer02">Cargo</label>
                    <input type="text" name="apellidos" class="form-control" value="<?php echo utf8_encode($results['nombre_cargo'])?>" disabled="">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationServer02">Personal</label>
                    <input type="text" name="apellidos" class="form-control" value="<?php echo utf8_encode($results['nombre_personal'])?>" disabled="">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationServer02">Área</label>
                    <input type="text" name="apellidos" class="form-control" value="<?php echo utf8_encode($results['nombre_area'])?>" disabled="">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationServer02">Horario</label>
                    <input type="text" name="apellidos" class="form-control" value="<?php echo $results["horario"]?>" disabled="">
                </div>
            </div>
            <label class="font-weight-bolder mt-3">Experiencia laboral</label>
                <hr class="mt-1 mb-4 mr-5 ">
            <?php
                foreach ($experiencia as $expeEmpleado):
            ?>
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label for="validationServer08">Empresa</label>
                        <input type="text" name="empresa1" class="form-control" value="<?php echo $expeEmpleado->nombre_emp?>" disabled="">
                    </div>
                    <div class="col-md-5 mb-3">
                        <label for="validationServer16">Dirección</label>
                        <input type="text" name="direccion1" class="form-control" value="<?php echo $expeEmpleado->direccion?>" disabled="">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="validationServer16">Cargo</label>
                        <input type="text" name="cargo1" class="form-control" value="<?php echo $expeEmpleado->cargo?>" disabled="">
                    </div>    
                    <div class="col-md-2 mb-3">
                        <label for="validationServer16">Años</label>
                        <input type="text" name="ano1" class="form-control"value="<?php echo $expeEmpleado->anos?>" disabled="">
                    </div>  
                    <div class="col-md-2 mb-3">
                        <label for="validationServer16">Meses</label>
                        <input type="text" name="meses1" class="form-control" value="<?php echo $expeEmpleado->meses?>" disabled="">
                    </div>  
                    <div class="col-md-5 mb-3 mr-3">
                        <label for="validationServer11">Naturaleza de la Empresa</label>
                        <input type="text" name="naturalezaEmpresa1" class="form-control" value="<?php echo $expeEmpleado->naturaleza_emp?>" disabled="">
                    </div>
                </div>
                <hr class="mt-1 mb-4 mr-5">
            <?php 
                endforeach;
            ?>  

            <label class="font-weight-bolder mt-3">Contactos para casos de emergencia</label>
            <hr class="mt-1 mb-4 mr-5">
                <?php
                    foreach ($contactos as $contactosEmpleado):
                ?>
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <label for="validationServer01">Nombres</label>
                        <input type="text" name="nombres" class="form-control" value="<?php echo $contactosEmpleado->nombres_contacemergencia?>" disabled="">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="validationServer01">Apellidos</label>
                        <input type="text" name="nombres" class="form-control" value="<?php echo $contactosEmpleado->apellidos_contacemergencia?>" disabled="">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="validationServer02">Telf. Fijo</label>
                        <input type="text" name="apellidos" class="form-control" value="<?php echo $contactosEmpleado->telefono_contacemergencia?>" disabled="">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="validationServer02">Celular </label>
                        <input type="text" name="apellidos" class="form-control" value="<?php echo $contactosEmpleado->celular_contacemergencia?>" disabled="">
                    </div>
                </div>
                <?php 
                    endforeach;
                ?>  
            <label class="font-weight-bolder mt-3">Informacion de hijos </label>
            <hr class="mt-1 mb-4 mr-5 ">
                <?php
                    foreach ($hijos as $hijosEmpleado):
                ?>
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label for="validationServer04">Nombres</label>
                        <input type="text" name="nombreHijo" value="<?php echo $hijosEmpleado->nombres_hijo?>"  class="form-control" disabled="">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="validationServer04">Apellidos</label>
                        <input type="text" name="apellidoHijo" class="form-control" value="<?php echo $hijosEmpleado->apellidos_hijo?>" disabled="">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="validationServer04">Años</label>
                        <input type="text" name="anosHijo" class="form-control" value="<?php echo $hijosEmpleado->anos_hijo?>"  disabled="">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="validationServer04">Meses</label>
                        <input type="text" name="mesesHijo" class="form-control" value="<?php echo $hijosEmpleado->meses_hijo?>" disabled="">
                    </div>
                </div>   
                <?php 
                    endforeach;
                ?>   
                <label class="font-weight-bolder mt-3">Referencias</label>
                <hr class="mt-1 mb-4 mr-5 ">
                <?php
                    foreach ($referencias as $referenciasEmpleado):
                ?>
                <?php
                    if($referenciasEmpleado->tipo_refe == 1){
                        echo '<label class="font-weight-bolder mt-1 ml-2">Personal</label>';
                    }else{
                        echo '<label class="font-weight-bolder mt-1 ml-2">Laboral</label>';
                    }
                    ?>
                    <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label for="validationServer08">Nombres</label>
                        <input type="text" name="nombresRefe1" class="form-control" value="<?php echo $referenciasEmpleado->nombres_refe?>" disabled="">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="validationServer08">Apellidos</label>
                        <input type="text" name="apellidosRefe1" class="form-control" value="<?php echo $referenciasEmpleado->apellidos_refe?>" disabled="">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="validationServer11">N° de teléf.</label>
                        <input type="text" name="telefonoRefe1" class="form-control" value="<?php echo $referenciasEmpleado->telefono_refe?>" disabled="">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="validationServer11">Número celular</label>
                        <input type="text" name="celularRefe1" class="form-control" value="<?php echo $referenciasEmpleado->celular_refe?>" disabled="">
                    </div>
                    </div>
                    <hr class="mt-1 mb-1 mr-5">
                <?php 
                    endforeach;
                ?>  
            <label class="font-weight-bolder mt-3">Descripcion de documentos que adjuntar</label>
            <hr class="mt-1 mb-4 mr-5 ">
            <div class="form-row">
                <div class="col-md-12 mb-3">
                <textarea name="documentosDescription" class="form-control" id="lugar" rows="3" disabled=""><?php echo $results["documentos_descripcion"]?></textarea>
                </div>        
            </div>   
            <a href="../components/viewDocuments.php?contrato=<?php echo $results["fileDocument"]?>">Visualizar Documentos</a>
        </div> 
        <hr class="mt-2 mb-3">
        </div>
</body>
</html>