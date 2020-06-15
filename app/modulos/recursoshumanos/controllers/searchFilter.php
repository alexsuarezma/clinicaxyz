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
	$p = $conn->real_escape_string($_POST['personal']);
	var_dump($p);
    $query = "SELECT * FROM empleados WHERE (nombres NOT LIKE '') AND (deleted=0) AND (personal='$p') ORDER By cedula LIMIT 25";

    if (isset($_POST['consulta'])) {
		$q = $conn->real_escape_string($_POST['consulta']);
    	$query = "SELECT * FROM empleados WHERE (cedula LIKE '%$q%' OR nombres LIKE '%$q%' OR apellidos LIKE '%$q%' OR sexo LIKE '%$q%' OR ciudad LIKE '$q') AND (deleted=0) AND (personal='$p')";
    }

    $resultado = $conn->query($query);

    if ($resultado->num_rows>0) {


    	while ($fila = $resultado->fetch_assoc()) {
			$salida.="<div class='col-xl-3 col-lg-3 col-md-3 col-sm-4 col-12'>
						<figure class='user-card green'>
							<figcaption>
								<img src='https://bootdey.com/img/Content/avatar/avatar1.png' alt='Milestone Admin' class='profile'>
								
								<h5>".$fila['nombres']." ".$fila['apellidos']."</h5>
								<h6>".$fila['cedula']."</h6>
								<p>Personal ".$fila['personal'].". ".$fila['cargo']."Capacitado en la especialidad de ".$fila['especialidad']."</p>
								<ul class='contacts'>
									<li>
											".$fila['email']."
									</li>
									<li>
										<!-- Para concatenar variables usamos & y luego todo se repite-->
										<a href='profile.php?id=".$fila['cedula']."'>
											Dirigete al perfil!!->
										</a>
									</li>
								</ul>
								<div class='clearfix'>
									<span class='badge badge-pill badge-success'>DISPONIBLE</span>
									<span class='badge badge-pill badge-orange'>En jornada</span>
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



?>