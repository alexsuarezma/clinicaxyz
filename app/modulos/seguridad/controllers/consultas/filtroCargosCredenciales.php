<?php
session_start();
	$servername = "us-cdbr-east-05.cleardb.net";
    $username = "b7550b2dcd9c38";
  	$password = "a16e5057";
  	$dbname = "heroku_fe7e002859673b2";

	$conn = new mysqli($servername, $username, $password, $dbname);
      if($conn->connect_error){
        die("Conexión fallida: ".$conn->connect_error);
      }

    $salida = "";
	   
	$query= "SELECT * FROM cargo_empleados AS c, area_empleados AS a, credencial_base AS cb WHERE c.id_area_cargo = a.id_area AND c.id_credencialbase_cargo = cb.id_credencial ORDER BY nombre_cargo ASC LIMIT 25";

	

    if (isset($_POST['consulta'])) {
		$q = $conn->real_escape_string($_POST['consulta']);
		$query= "SELECT * FROM cargo_empleados AS c, area_empleados AS a, credencial_base AS cb WHERE (c.id_area_cargo = a.id_area AND c.id_credencialbase_cargo = cb.id_credencial) AND (nombre_area LIKE '%$q%' OR nombre_cargo LIKE '%$q%' OR nombre_credencial LIKE '$q')";	
    }

    $resultado = $conn->query($query);

    if ($resultado->num_rows>0) {
    $comilla= '"';
        $salida.="<table class='table'>
        <thead class='thead-dark'>
        <tr>
            <th scope='col'>Area</th>
            <th scope='col'>Cargo</th>
            <th scope='col'>Nombre Credencial Asignada</th>
            <th scope='col'></th>

        </tr>
        </thead>
        <tbody>";

            while ($fila = $resultado->fetch_assoc()) {
                $salida.="
                    <tr>
                        <th scope='row'>".utf8_encode($fila['nombre_area'])."</th>
                        <td>".utf8_encode($fila['nombre_cargo'])."</td>
                        <td>".utf8_encode($fila['nombre_credencial'])."</td>";
           
                        if($_SESSION['actualizar'] != false):
                        
                            $salida.="<td>
                                    <div class='d-flex justify-content-end'>
                                        <a onclick='cambiarCredencial($comilla".$fila['id_cargo']."$comilla,$comilla".$fila['id_credencial']."$comilla,$comilla".utf8_encode($fila['nombre_cargo'])."$comilla,$comilla".utf8_encode($fila['nombre_credencial'])."$comilla)' data-toggle='modal' href='#updateCredencialAsignada'><i class='far fa-edit' style='color:red; font-size:20px;' title='Editar Credencial del cargo ".utf8_encode($fila['nombre_cargo'])."'></i></a>
                                    </div>                      
                                    </td>";

          
                        else:
                   
                            $salida.="<td></td>";
                       
                        endif;
                     
                            $salida.="</tr>";
            }

        $salida.="</tbody>
        </table>";

    }else{
        $salida.="<h4>No hay datos.</h4>";
    }


    echo $salida;

    $conn->close();


