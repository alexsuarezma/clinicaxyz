

<?php 

	class conectar{
		public function conexion(){
			
		
	
$host="us-cdbr-east-05.cleardb.net";
$port=3306;
$socket="";
$user="b7550b2dcd9c38";
$password="a16e5057";
$dbname="heroku_fe7e002859673b2";

$conexion = new mysqli($host, $user, $password, $dbname, $port, $socket)
	or die ('Could not connect to the database server' . mysqli_connect_error());

//$con->close();
	return $conexion;

		}
	}

 ?>


 