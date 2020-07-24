<?php
	$servername = "us-cdbr-east-05.cleardb.net";
    $username = "b7550b2dcd9c38";
  	$password = "a16e5057";
  	$dbname = "heroku_fe7e002859673b2";

	$conn = new mysqli($servername, $username, $password, $dbname);
      if($conn->connect_error){
        die("Conexión fallida: ".$conn->connect_error);
      }

    $salida = "";
        

    if (isset($_POST['consulta'])) {
        $q = $conn->real_escape_string($_POST['consulta']);
        $query= "SELECT * FROM cargo_empleados WHERE id_area_cargo=$q";	

        $resultado = $conn->query($query);

        if ($resultado->num_rows>0) {
            $salida.="<label for='cargo'>Cargo</label> 
            <select class='custom-select' name='cargo' id='cargo' required>
            <option selected disabled value=''>Seleccione...</option>";
            
            while ($fila = $resultado->fetch_assoc()) {
                $salida.="<option value=".$fila['id_cargo'].">".utf8_encode($fila['nombre_cargo'])."</option>";
            }
            $salida.="</select>";
        }else{
                $salida.="";
        }
    }

    if (isset($_POST['cargo'])) {
        
        $q = $conn->real_escape_string($_POST['cargo']);
        $query= "SELECT * FROM cargo_empleados WHERE id_cargo=$q";	

        $resultado = $conn->query($query);

        $salida.="<div class='col-md-5 mb-3'>
                        <label for='validationServer11'>Salario base</label>";
        
        if ($resultado->num_rows>0) {
            $resultado=$resultado->fetch_assoc();
        
                $salida.="<input type='text' name='salarioBase' class='form-control' id='validationServer38' value=".$resultado['sueldo_base_cargo']." readonly required>
                </div>
                <div class='col-md-5 mb-3'>
                      <label for='horario'>Jornada</label>
                      <select class='custom-select' name='horario' id='horario' required>
                      <option selected disabled value=''>Seleccione...</option>
                ";
                    $horario= "SELECT * FROM cargo_empleados AS c, cargo_horario AS ch, horario_empleado AS h WHERE (c.id_cargo=ch.id_cargo_ch AND h.id_horario_empleado=ch.id_horario_ch) AND id_cargo=$q";	

                    $horarios = $conn->query($horario);
                    while ($fila = $horarios->fetch_assoc()) {
                        $salida.="<option value=".$fila['id_cargo_horario'].">".utf8_encode($fila['jornada'])."</option>";
                    }
                $salida.="</select>
                </div>";
        }else{
            $salida.="<input type='text' name='salarioBase' class='form-control' id='validationServer38' value='' readonly required>
            </div>
            <div class='col-md-5 mb-3'>
                <label for='horario'>Jornada</label>
                <select class='custom-select' name='horario' id='horario' required>
                <option selected disabled value=''>Seleccione...</option>
                </select>
            </div>";
        } 
    }

    if (isset($_POST['horario'])) {
        $q = $conn->real_escape_string($_POST['horario']);
        $query= "SELECT * FROM cargo_horario AS c, horario_empleado AS h WHERE (c.id_horario_ch=h.id_horario_empleado) AND id_cargo_horario=$q";	

        $resultado = $conn->query($query);

        if ($resultado->num_rows>0) {
             $resultado=$resultado->fetch_assoc();
            $salida.="<div class='col-md-3 mb-3'>
                <label for='validationServer07'>Hora Entrada</label>
                <input type='text' class='form-control' id='validationServer07' value='".$resultado['inicio']."' readonly required>
            </div>
            <div class='col-md-3 mb-3'>
                <label for='validationServer07'>Hora Salida</label>
                <input type='text' class='form-control' id='validationServer07' value='".$resultado['finalizacion']."' readonly required>
            </div> ";

        }
    }

echo $salida;
$conn->close();



