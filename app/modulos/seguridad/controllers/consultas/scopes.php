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
        $query= "SELECT * FROM scope WHERE id_scope=$q";	

        $resultado = $conn->query($query);

        if ($resultado->num_rows>0) {
            $resultado = $resultado->fetch_assoc();
            $lectura = "";
            $escritura = "";
            $actualizar = "";
            $actInformacion = "";
            $deleteLogic = "";
            $deleteFisic = "";
            $crearUser = "";
            if($resultado['lectura']==1){$lectura = "checked";}else{$lectura = "";}
            if($resultado['insertar']==1){$escritura = "checked";}else{$escritura = "";}
            if($resultado['actualizar']==1){$actualizar = "checked";}else{$actualizar = "";}
            if($resultado['actualizar_informacion']==1){$actInformacion = "checked";}else{$actInformacion = "";}
            if($resultado['borrado_logico']==1){$deleteLogic = "checked";}else{$deleteLogic = "";}
            if($resultado['borrado_fisico']==1){$deleteFisic = "checked";}else{$deleteFisic = "";}
            if($resultado['crear_usuarios']==1){$crearUser = "checked";}else{$crearUser = "";}

            $salida.="<hr class='mt-1 mb-4 mr-5'>
            <div class='form-row'>
            <div class='form-group col-md-4'>
              <label>Descripción del Scope</label>
              <input type='text' class='form-control' value='".utf8_encode($resultado['descripcion_rol'])."' readonly>
            </div>      
            <div class='form-group col-md-4'>
              <label>Nivel del Scope</label>
              <input type='text' class='form-control' value='".$resultado['nivel_scope']."' readonly>
            </div>      
          </div>      
          <div class='form-row'>
            <div class='custom-control custom-checkbox custom-control-inline'>
              <input type='checkbox' class='custom-control-input' ".$lectura." readonly>
              <label class='custom-control-label'>Leer</label>
            </div>
            <div class='custom-control custom-checkbox custom-control-inline'>
              <input type='checkbox' class='custom-control-input' ".$escritura." readonly>
              <label class='custom-control-label'>Insertar</label>
            </div> 
            <div class='custom-control custom-checkbox custom-control-inline'>
              <input type='checkbox' class='custom-control-input' ".$actualizar." readonly>
              <label class='custom-control-label'>Actualizar</label>
            </div>
            <div class='custom-control custom-checkbox custom-control-inline'>
            <input type='checkbox' class='custom-control-input' ".$actInformacion." readonly>
              <label class='custom-control-label'>Información Sensible</label>
            </div>
            <div class='custom-control custom-checkbox custom-control-inline'>
            <input type='checkbox' class='custom-control-input' ".$deleteLogic." readonly>
              <label class='custom-control-label'>Borrador Logico</label>
            </div>
            <div class='custom-control custom-checkbox custom-control-inline'>
              <input type='checkbox' class='custom-control-input' ".$deleteFisic." readonly>
              <label class='custom-control-label'>Borrado Fisico</label>
            </div>  
            <div class='custom-control custom-checkbox custom-control-inline'>
              <input type='checkbox' class='custom-control-input' ".$crearUser." readonly>
              <label class='custom-control-label'>Crear Usuario</label>
            </div>  
          </div>";
        }
    }else{
        $salida.="";
    }



echo $salida;
$conn->close();



