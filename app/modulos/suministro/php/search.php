<?php
/*
	require 'conexion.php';

	$salida="";
	$query= "SELECT * FROM producto";

	if(isset($_POST['consulta']))
	{
		$q= mysqli_real_escape_string($_POST['consulta']);
		$query= "SELECT id,serie,nombre,descripcion,categoria FROM producto
		WHERE name LIKE '%".$q."%' OR name LIKE '%".$q."%' OR descripcion LIKE '%".$q."%' OR categoria LIKE '%".$q."%' ";

	}

	$resultado= mysqli_query($conexion,$query);

	if($resultado)
	{
		$salida.="<table class='tabla_datos'>
								<thead>
									<tr>
										<td>id</td>
										<td>Serie</td>
										<td>Nombre</td>
										<td>Desrcripcion</td>
										<td>Categoria</td>
									</tr>
								</thead>
								<tbody";
		
								while($fila= $resultado->fetch_assoc())
								{
									$salida.="<tr>
															<td>".$fila['id']."</td>
															<td>".$fila['serie']."</td>
															<td>".$fila['nombre']."</td>
															<td>".$fila['categoria']."</td>
														</tr>";
								}
								
								$salida.="</tbody></table>";

	}

	else
	{
		$salida.="no hay datos";
	}

	echo $salida;

	mysqli_close();*/
?>