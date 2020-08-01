<?php 
	require_once "../clases/conexion.php";
	require_once "../clases/crud.php";
	$obj= new crud();

	$datos=array(
		$_POST['cod_ctaU'],
		$_POST['nom_ctaU'],
		$_POST['tipo_ctaU'],
		$_POST['ing_ctaU'],
		$_POST['egre_ctaU'],
		$_POST['idcta']
				);

	echo $obj->actualizar($datos);
	

 ?>