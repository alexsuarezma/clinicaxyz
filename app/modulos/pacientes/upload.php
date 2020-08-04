<?php 
include ("conexion.php");
$cedula = $_POST["ced"];
$archi = $_FILES["arc"];
$nombre=$_FILES['arc']['name'];
$guardado=$_FILES['arc']['tmp_name'];

$consultar = "SELECT idpacientes FROM pacientes WHERE idpacientes = $cedula";


$conex = mysqli_connect("localhost","root","","heroku_fe7e002859673b2");

if(!$conex){
    echo 'error al conectar la base de datos';
}
else{
    echo 'conectado a la abse de datos';
}



if($consultar = $cedula)
{
	echo $cedula;
}
else
{
	echo 'usuario no existe';
}



if(!file_exists('archi')){
	mkdir('archi',0777,true);
	if(file_exists('archi')){
		if(move_uploaded_file($guardado, 'archi/'.$nombre)){
			echo "Archivo guardado con exito";
		}else{
			echo "Archivo no se pudo guardar";
		}
	}
}else{
	if(move_uploaded_file($guardado, 'archi/'.$nombre)){
		echo "Archivo guardado con exito";
	}else{
		echo "Archivo no se pudo guardar";
	}
}

$ruta='arc/'.$nombre;
$registro="INSERT INTO doc(cedula, ruta) VALUES ('$cedula','$ruta')";
$resultado = mysqli_query ($conectar,$registro);

if($resultado ){
?>
<br>
<h3> arhivo registrado exitosamente en base de datos</h3>
<?php
}else{
    ?>
    <br>
    <h3> falla al registrar archivo en base de datos </h3>
    <?php
}

?>