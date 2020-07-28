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
	   
	$query= "SELECT * FROM empleados AS e, cargo_empleados AS c, horario_empleado AS h, cargo_horario AS ch, area_empleados AS a
	 WHERE (e.id_cargo_horario_emp = ch.id_cargo_horario AND ch.id_horario_ch = h.id_horario_empleado AND ch.id_cargo_ch = c.id_cargo AND c.id_area_cargo = a.id_area) AND (nombres NOT LIKE '') AND (deleted=0) ORDER By id_empleados LIMIT 25";

	

    if (isset($_POST['consulta'])) {
		$q = $conn->real_escape_string($_POST['consulta']);
		$query= "SELECT * FROM empleados AS e, cargo_empleados AS c, horario_empleado AS h, cargo_horario AS ch, area_empleados AS a WHERE (e.id_cargo_horario_emp = ch.id_cargo_horario AND ch.id_horario_ch = h.id_horario_empleado AND ch.id_cargo_ch = c.id_cargo AND c.id_area_cargo = a.id_area) AND (id_empleados LIKE '%$q%' OR nombres LIKE '%$q%' OR apellidos LIKE '%$q%' OR nombre_area LIKE '%$q%' OR jornada LIKE '%$q%' OR nombre_cargo LIKE '$q') AND (deleted=0)";	
    }

    $resultado = $conn->query($query);

    if ($resultado->num_rows>0) {


    	while ($fila = $resultado->fetch_assoc()) {
			if($fila['medico']==1){ 
				$medico = "<span class='badge badge-pill badge-info'>#MEDICO</span>";
				$id = $fila['id_empleados'];
				$sql= "SELECT * FROM empleados_medico AS m, especialidades AS e WHERE (m.id_especialidad_medico = e.idespecialidades) AND id_empleados_medico = $id";	
				$especialidad = $conn->query($sql);
				$resultadoEspecialidad = $especialidad->fetch_assoc();				
				$nombreEspecialidad = "<span class='font-weight-bold'>Medico, especialista: </span>".utf8_encode($resultadoEspecialidad['descripcion']).".</br>";
			}else{ 
				$medico = "";
				$nombreEspecialidad="";
			}
			$salida.="<div class='col-xl-3 col-lg-3 col-md-3 col-sm-4 col-12'>
						<figure class='user-card green'>
							<figcaption>
								<img src=".$fila['profileimage']." alt='Imagen de perfil' class='profile'>
								
								<h5>".$fila['nombres']." ".$fila['apellidos']."</h5>
								<h6>".$fila['id_empleados']."</h6>
								<p><span class='font-weight-bold'>Personal Jornada: </span>".$fila['jornada'].".</br> <span class='font-weight-bold'>Cargo: </span> ".utf8_encode($fila['nombre_cargo']).".</br> <span class='font-weight-bold'>Area: </span> ".utf8_encode($fila['nombre_area']).".</br> ".$nombreEspecialidad."</p>
								<ul class='contacts'>
									<li>
											".$fila['email']."
									</li>
									<li>
										<!-- Para concatenar variables usamos & y luego todo se repite-->
										<a href='profile.php?id=".$fila['id_empleados']."'>
											Dirigete al perfil!!->
										</a>
									</li>
								</ul>
								<div class='clearfix'>
									<span class='badge badge-pill badge-success'>DISPONIBLE</span>
									<span class='badge badge-pill badge-orange'>En jornada</span>
									".$medico."
								</div>
							</figcaption>
						</figure>
					</div>";
    	}

    }else{
		$salida.="<div class='col-xl-3 col-lg-3 col-md-3 col-sm-4 col-12'>
					<figure class='user-card green'>
						<figcaption>
							<h5>SIN DATOS FILTRADOS</h5>
							<div class='clearfix'>
								<span class='badge badge-pill badge-success'>USARIO NO ENCONTRADO</span>
								<span class='badge badge-pill badge-orange'>NO ENCONTRADO</span>
							</div>
						</figcaption>
					</figure>
				</div>";
    }


    echo $salida;

    $conn->close();


