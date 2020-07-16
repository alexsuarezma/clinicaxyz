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
        $query= "SELECT * FROM credencial_base WHERE id_credencial=$q";	

        $resultado = $conn->query($query);

        if ($resultado->num_rows>0) {
            $resultado = $resultado->fetch_assoc();
            $modulo_rrhh = "";
            $contabilidad = "";
            $modulo_suministros = "";
            $ctas_medicas = "";
            $modulo_pacientes = "";
            $modulo_seguridad = "";
            $paciente = "";
            if($resultado['modulo_rrhh']==1){$modulo_rrhh = "checked";}else{$modulo_rrhh = "";}
            if($resultado['modulo_contabilidad']==1){$contabilidad = "checked";}else{$contabilidad = "";}
            if($resultado['modulo_suministros']==1){$modulo_suministros = "checked";}else{$modulo_suministros = "";}
            if($resultado['modulo_ctas_medicas']==1){$ctas_medicas = "checked";}else{$ctas_medicas = "";}
            if($resultado['modulo_pacientes']==1){$modulo_pacientes = "checked";}else{$modulo_pacientes = "";}
            if($resultado['modulo_seguridad']==1){$modulo_seguridad = "checked";}else{$modulo_seguridad = "";}
            if($resultado['paciente']==1){$paciente = "checked";}else{$paciente = "";}

            $salida.="<hr class='mt-1 mb-4 mr-5'>
            <div class='form-row'>
            <div class='form-group col-md-4'>
              <label>Nombre de la credencial</label>
              <input type='text' class='form-control' value='".utf8_encode($resultado['nombre_credencial'])."' readonly>
            </div>           
          </div>      
          <div class='form-row'>
            <div class='custom-control custom-checkbox custom-control-inline'>
              <input type='checkbox' class='custom-control-input' ".$modulo_rrhh." readonly>
              <label class='custom-control-label'>Acceso RRHH</label>
            </div>
            <div class='custom-control custom-checkbox custom-control-inline'>
              <input type='checkbox' class='custom-control-input' ".$contabilidad." readonly>
              <label class='custom-control-label'>Acceso Contabilidad</label>
            </div> 
            <div class='custom-control custom-checkbox custom-control-inline'>
              <input type='checkbox' class='custom-control-input' ".$modulo_suministros." readonly>
              <label class='custom-control-label'>Acceso Suministros</label>
            </div>
            <div class='custom-control custom-checkbox custom-control-inline'>
            <input type='checkbox' class='custom-control-input' ".$ctas_medicas." readonly>
              <label class='custom-control-label'>Acceso Ctas Medicas</label>
            </div>
            <div class='custom-control custom-checkbox custom-control-inline'>
            <input type='checkbox' class='custom-control-input' ".$modulo_pacientes." readonly>
              <label class='custom-control-label'>Acceso Pacientes</label>
            </div>
            <div class='custom-control custom-checkbox custom-control-inline'>
              <input type='checkbox' class='custom-control-input' ".$modulo_seguridad." readonly>
              <label class='custom-control-label'>Acceso Seguridad</label>
            </div>  
            <div class='custom-control custom-checkbox custom-control-inline'>
              <input type='checkbox' class='custom-control-input' ".$paciente." readonly>
              <label class='custom-control-label'>Paciente</label>
            </div>  
          </div>";
        }
    }else{
        $salida.="";
    }



echo $salida;
$conn->close();



