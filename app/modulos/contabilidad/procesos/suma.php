
<?php

	$conexion=mysqli_connect('us-cdbr-east-05.cleardb.net','b7550b2dcd9c38','a16e5057','heroku_fe7e002859673b2');	

	?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<br>
	
		<?php
		$sql="SELECT SUM(total_eg) as mtotal FROM egresos ";
		$result=mysqli_query($conexion,$sql);
		$mostrar=mysqli_fetch_array($result);
	?>
		<tr>
			

			<?php 
			$_SESSION['mtotal'] = $mostrar['mtotal'];
			echo $mostrar ['mtotal']?>
			
			
		
</body>
</html>