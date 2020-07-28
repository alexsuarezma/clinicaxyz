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
        $query= "SELECT * FROM producto_has_proveedor AS has, proveedores AS pv, productos AS pd WHERE (has.idproveedor_has=pv.idproveedor AND has.idproducto_has=pd.idproducto) AND idproducto=$q AND has.deleted = 0";

        $resultado = $conn->query($query);

        if ($resultado->num_rows>0) {
            // $resultado = $resultado->fetch_assoc();
            $salida.="
            <table class='table colored-header datatable project-list'>
            <thead>
                <tr>
                    <th>Identificación</th>
                    <th>Razon Social</th>
                    <th>Representante</th>
                    <th>Direccion</th>
                </tr>
            </thead>
            <tbody>
            ";
            while ($fila = $resultado->fetch_assoc()) {
                $deleted = $conn->query("SELECT * FROM proveedores WHERE idproveedor=".$fila['idproveedor']);
                $deleted =$deleted->fetch_assoc();

                $salida.="
                        <tr>
                            <th>".$fila['numero_identificacion_pro']."</th>";

                            if($deleted['deleted']==1){
                                $salida.="<td><span class='font-weight-bold text-danger'>(proveedor eliminado)</span></br>".$fila['razon_social_empresa_pro']."</td>";
                            }else{
                                $salida.="<td>".$fila['razon_social_empresa_pro']."</td>";
                            }

                $salida.="
                            <td>".$fila['nombre_representante_legal_pro']."</td>
                            <td>".$fila['direccion_pro']."</td>
                        </tr>";
                
            }               
            $salida.="    </tbody>
                </table>";
        }
    }else{
        $salida.="";
    }



echo $salida;
$conn->close();

