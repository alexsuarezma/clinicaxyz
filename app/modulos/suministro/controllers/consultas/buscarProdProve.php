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
        $query= "SELECT * FROM producto_has_proveedor AS has, proveedores AS pv, productos AS pd WHERE (has.idproveedor_has=pv.idproveedor AND has.idproducto_has=pd.idproducto) AND idproveedor=$q AND has.deleted = 0";

        $resultado = $conn->query($query);

        if ($resultado->num_rows>0) {
            $salida.="<label for='producto'>PRODUCTO</label> 
            <select class='custom-select' name='producto' id='producto' required>
            <option selected disabled value=''>Seleccione...</option>";
            
            while ($fila = $resultado->fetch_assoc()) {
                $salida.="<option value=".$fila['idproducto_has_proveedor'].">".utf8_encode($fila['nombre_pr'])."</option>";
            }
            $salida.="</select>";
        }else{
                $salida.="";
        }

    }else{
        $salida.="No existe PROVEEDOR asociado a este PRODUCTO.";
    }



echo $salida;
$conn->close();

