<?php 
include ("conexión.php");
$cedula =

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
echo $ruta;
?>