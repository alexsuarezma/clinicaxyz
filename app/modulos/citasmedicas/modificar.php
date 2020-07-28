<?php 
include 'conexion.php';

$id_paciente=$_POST['cedula'];
$id_cita=$_POST['idcitas'];
$observacion=$_POST['observacion'];
$tratamiento=$_POST['tratamiento'];
$medicamento=$_POST['medicamento'];

$sentencia="UPDATE citas 
SET observacion = '$observacion' and tratamiento='$tratamiento' and medicamento='$medicamento'
WHERE idcitas='$id_cita'  and idpacientes=0958548125";


 	    		  echo ("<script LANGUAGE='JavaScript'>
    window.alert('Modificado con exito! ');
    window.location.href='historial_clinico.php ';
    </script>");


?>