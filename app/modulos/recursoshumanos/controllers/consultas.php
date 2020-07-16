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

        $salida.="<label for='validationServer11'>Salario base</label>";
        
        if ($resultado->num_rows>0) {
            $resultado=$resultado->fetch_assoc();
        
            
            if($resultado['sueldo_base_cargo']!= NULL){
                $salida.="<input type='text' name='salarioBase' class='form-control' id='validationServer38' value=".$resultado['sueldo_base_cargo']." readonly required>";
            }else{
                $salida.="<input type='text' name='salarioBase' class='form-control' id='validationServer38' readonly required>";
            }   
        }else{
            $salida.="<input type='text' name='salarioBase' class='form-control' id='validationServer38' readonly required>";
        }  
    }

echo $salida;
$conn->close();



