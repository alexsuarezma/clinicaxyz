<?php

session_start();

$servername = "us-cdbr-east-05.cleardb.net";
$username = "b7550b2dcd9c38";
$password = "a16e5057";
$dbname = "heroku_fe7e002859673b2";

$con = new mysqli($servername, $username, $password, $dbname);
    if($con->connect_error){
        die("Conexión fallida: ".$con->connect_error);
    }


    $salida = "";
     
    
	$query= "SELECT * FROM empleados AS e, cargo_empleados AS ca, cargo_horario AS ch, usuario AS u, usuario_credencial AS uc, credencial_base AS c WHERE (e.id_cargo_horario_emp = ch.id_cargo_horario AND ch.id_cargo_ch = ca.id_cargo AND uc.id_usuario_uc = u.id_usuario AND e.id_usuario_emp = u.id_usuario AND c.id_credencial = uc.id_credencialbase_uc) ORDER BY username ASC LIMIT 25";	

    if (isset($_POST['consulta'])) {
		$q = $con->real_escape_string($_POST['consulta']);
		$query= "SELECT * FROM empleados AS e, cargo_empleados AS ca, cargo_horario AS ch, usuario AS u, usuario_credencial AS uc, credencial_base AS c WHERE (e.id_cargo_horario_emp = ch.id_cargo_horario AND ch.id_cargo_ch = ca.id_cargo AND uc.id_usuario_uc = u.id_usuario AND e.id_usuario_emp = u.id_usuario AND c.id_credencial = uc.id_credencialbase_uc) AND (id_empleados LIKE '%$q%' OR nombres LIKE '%$q%' OR nombre_cargo LIKE '%$q%' OR apellidos LIKE '%$q%' OR nombre_credencial LIKE '$q')";	
    }

    $resultado = $con->query($query);

    if ($resultado->num_rows>0) {
    $comilla= '"';

        $salida.="<table class='table'>
        <thead class='thead-dark'>
        <tr>
            <th scope='col'>Cedula</th>
            <th scope='col'>Nombre</th>
            <th scope='col'>Apellido</th>
            <th scope='col'>Cargo</th>
            <th scope='col'>Nombre Credencial</th>
            <th scope='col'>Nombre de Usuario</th>
            <th scope='col'></th>

        </tr>
        </thead>
        <tbody>";

            while ($fila = $resultado->fetch_assoc()) {
               
                if($_SESSION['insertar'] == false || $_SESSION['actualizar'] == false):
                   
                        $salida.=" <tr>
                                    <th scope='row'>".utf8_encode($fila['id_empleados'])."</th>
                                    <td>".utf8_encode($fila['nombres'])."</td>
                                    <td>".utf8_encode($fila['apellidos'])."</td>
                                    <td>".utf8_encode($fila['nombre_cargo'])."</td>
                                    <td>".utf8_encode($fila['nombre_credencial'])."</td>
                                    <td>".utf8_encode($fila['username'])."</td>
                                    <td></td>
                                </tr>";
                
                else:
                
                    $salida.="<tr>
                            <th scope='row'>".utf8_encode($fila['id_empleados'])."</th>
                            <td>".utf8_encode($fila['nombres'])."</td>
                            <td>".$fila['apellidos']."</td>
                            <td>".utf8_encode($fila['nombre_cargo'])."</td>
                            <td>".utf8_encode($fila['nombre_credencial'])."</td>
                            <td>".utf8_encode($fila['username'])."</td>
                            <td>
                              <div class='d-flex justify-content-end'>";
                    
                                if($_SESSION['borrado_fisico'] == true):
                        
                                    $salida.="<a class='text-secondary' href='../controllers/borrarCredencialUsuario.php?idUser=".$fila['id_usuario_uc']."&idCredencial=".$fila['id_credencial']."'><i class='fas fa-user-slash mr-2' style='font-size:20px;' title='Eliminar la credencial al usuario ".utf8_encode($fila['username'])."'></i></a>";
                
                                endif;
                            
                                if($_SESSION['crear_usuarios'] == true):
                             
                                    $salida.="<a onclick='agregarCredencial($comilla".$fila['id_empleados']."$comilla,$comilla".$fila['id_usuario_uc']."$comilla,$comilla".$fila['id_usuario_credencial']."$comilla,$comilla".$fila['id_credencial']."$comilla,$comilla".utf8_encode($fila['nombre_credencial'])."$comilla,$comilla".utf8_encode($fila['nombres'])."$comilla,$comilla".utf8_encode($fila['apellidos'])."$comilla,$comilla".utf8_encode($fila['username'])."$comilla)' class='text-secondary' data-toggle='modal' href='#agregarCredencial'><i class='fas fa-user-plus mr-2' style='font-size:20px;' title='Agrega una nueva credencial al usuario ".utf8_encode($fila['username'])."'></i></a>";
                       
                                endif;
                        $salida.="
                                <a onclick='eliminarCredencial($comilla".$fila['id_empleados']."$comilla,$comilla".$fila['id_usuario_uc']."$comilla,$comilla".$fila['id_usuario_credencial']."$comilla,$comilla".$fila['id_credencial']."$comilla,$comilla".utf8_encode($fila['nombre_credencial'])."$comilla,$comilla".utf8_encode($fila['nombres'])."$comilla,$comilla".utf8_encode($fila['apellidos'])."$comilla,$comilla".utf8_encode($fila['username'])."$comilla)' data-toggle='modal' href='#updateCredencialAsignada'><i class='fas fa-user-edit' style='color:red; font-size:20px;' title='Editar Credencial del usuario ".utf8_encode($fila['username'])."'></i></a>
                              </div>                      
                            </td>
                        </tr>";
                endif; 
            }

        $salida.="</tbody>
        </table>";

    }else{
        $salida.="<h4>No hay datos.</h4>";
    }


    echo $salida;

    $con->close();


