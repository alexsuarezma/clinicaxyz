<?php 
include ("conexion.php");
$cedula = $_POST["ced"];

$nombre=$_FILES['arc']['name'];
$guardado=$_FILES['arc']['tmp_name'];

if(!file_exists('arc')){
	mkdir('arc',0777,true);
	if(file_exists('arc')){
		if(move_uploaded_file($guardado, 'arc/'.$nombre)){
			echo "Archivo guardado con exito";
		}else{
			echo "Archivo no se pudo guardar";
		}
	}
}else{
	if(move_uploaded_file($guardado, 'arc/'.$nombre)){
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