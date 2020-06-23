<?php 
	require_once "../clases/conexion.php";
	require_once "../clases/crud.php";
	$obj= new crud();

	$datos=array(
		$_POST['cod_cta'],
		$_POST['nom_cta'],
		$_POST['tipo_cta'],
		$_POST['ing_cta'],
		$_POST['egre_cta'],
		
				);

	echo $obj->agregar($datos);
	

 ?>