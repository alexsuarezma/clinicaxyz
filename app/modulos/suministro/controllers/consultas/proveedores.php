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
        $query= "SELECT * FROM proveedores WHERE idproveedor=$q AND deleted = 0";

        $resultado = $conn->query($query);

        if ($resultado->num_rows>0) {
            // $resultado = $resultado->fetch_assoc();
            while ($fila = $resultado->fetch_assoc()) {
            $salida.="   <div class='form-row'>
            <div class='form-group col-md-6'>
                <label for='provIde'>Numero identificación</label>
                <input type='text' class='form-control' name='provIde' id='provIde' value=".$fila['numero_identificacion_pro']." disabled>
            </div>
        </div>
        <div class='form-row'>
            <div class='form-group col-md-6'>
                <label for='razSocial'>Razon Social Empresa</label>
                <input type='text' class='form-control' name='razSocial' id='razSocial' value=".$fila['razon_social_empresa_pro']." disabled>
            </div>
            <div class='form-group col-md-6'>
                <label for='nomRepresent'>Nombre Representante Legal</label>
                <input type='text' class='form-control' name='nomRepresent' id='nomRepresent' value=".$fila['nombre_representante_legal_pro']." disabled>
            </div>
        </div>
        <div class='form-row'>
            <div class='form-group col-md-4'>
                <label for='direc'>Dirección</label>
                <input type='text' class='form-control' name='direc' id='direc' value=".$fila['direccion_pro']." disabled>
            </div>
            <div class='form-group col-md-4'>
                <label for='ciud'>Ciudad</label>
                <input type='text' class='form-control' name='ciud' id='ciud' value=".$fila['ciudad_pro']." disabled>
            </div>
            <div class='form-group col-md-4'>
                <label for='tele'>Telefono</label>
                <input type='text' class='form-control' name='tele' id='tele' value=".$fila['telefono_1_pro']." disabled>
            </div>
        </div>";
                
            }               
        }
    }else{
        $salida.="";
    }



echo $salida;
$conn->close();

