<?php 
 error_reporting(E_ALL ^ E_NOTICE);
 date_default_timezone_set('AMERICA/GUAYAQUIL');
	include 'conexion.php';
	$id_paciente_re=$_POST['id_pa'];
	$num_tj=$_POST['numero_tarjeta'];
	$contrasenia=$_POST['contrasenia'];
	$tipo=$_POST['tipo'];
	$hora=$_POST['hora'];
	$saldo="";
	$especialidad=$_POST['especialidad'];
	$especialista=$_POST['id_doc'];
	$fecha=$_POST['fecha'];
	$hora=$_POST['hora'];


	$sentencia_tj="SELECT tu.*,pa.*,us.*,tj.* from tarjeta_usuario as tu join tarjetas as tj on tu.id_tarjeta_tu=tj.idtarjetas 
join usuario as us 	on tu.id_usuario_tu = us.id_usuario join pacientes as pa on pa.id_usuario_pac=tu.id_usuario_tu
 where pa.idpacientes= $id_paciente_re and tj.numero_tarjeta='$num_tj' and tj.contrasenia_tarjeta='$contrasenia' ";
 $resultado=mysqli_query($conexion,$sentencia_tj);

$mostrar=mysqli_num_rows($resultado);
$mostrar_row=mysqli_fetch_array($resultado);

$saldo=$mostrar_row['saldo_tarjeta'];
$id_tj=$mostrar_row['idtarjetas'];

if ($mostrar>0) {
	

if ($saldo>15) {




	
	
} else{ 
	 echo ("<script LANGUAGE='JavaScript'>
    window.alert('Saldo insuficiente');
    window.history.back();
    </script>");

}

  $fecha_de_registro=Date("Y-m-d H-i-s");


                $consulta_fecha="SELECT * from citas where fecha='$fecha' ";
                $sql_conteo=mysqli_query($conexion,$consulta_fecha);
                $conteo=mysqli_num_rows($sql_conteo);

                if ($conteo < 13 ) {
                	    
                        $sql_consulta="SELECT * from citas_medica where fecha='$fecha' and id_hora='$hora' and id_empleados= '$especialista' ";
                        $sql_consulta_conteo=mysqli_query($conexion,$sql_consulta);
                        $total=mysqli_num_rows($sql_consulta_conteo);
                	    if ($total<1) {

                	    	   $guardar_cita="INSERT into citas values('','$fecha','$hora','$id_paciente_re','Pendiente','','','')";

    mysqli_query($conexion, $guardar_cita);


    						$id=mysqli_insert_id($conexion);

                $sql_docdor="SELECT * from empleados_medico where id_empleados_medico= '$especialista' ";
                $resultado_doctor=mysqli_query($conexion,$sql_docdor);
                $row_doc=mysqli_fetch_array($resultado_doctor);
                $id_doc=$row_doc['id_medico'];

                  $registrar="INSERT INTO  citas_medicos values ('','$id','$id_doc')";

                  mysqli_query($conexion,$registrar);


                  $guardar_cita="INSERT INTO cita_especialidad values('','$id','$especialidad')";

                  mysqli_query($conexion,$guardar_cita);
      
 
                	    	
                	    }else{
                	    		  echo ("<script LANGUAGE='JavaScript'>
    window.alert('La hora escogida ya esta ocupada!! ');
    window.location.href='index.php ';
    </script>");

                	    }


                } else {

                	  echo ("<script LANGUAGE='JavaScript'>
    window.alert('Ya no hay cupos para el dia escogido... ');
    window.location.href='index.php ';
    </script>");

             		

              }

              //FACTURACIÓN
              $sentencia_pago="INSERT INTO pagos values('','$id','$id_tj',1.8,13.2)";

              mysqli_query($conexion,$sentencia_pago);

	 echo ("<script LANGUAGE='JavaScript'>
    window.alert('Consulta programada exitosamente ');
    target = '_blank';
    window.location.href='reportes/imprimir_cita.php?id_alu= ".$id." ';


    </script>");
	

    echo $id_paciente_re."----".$fecha."_____".$hora."-----".$id."____".$id_tj;


}else{
	  echo ("<script LANGUAGE='JavaScript'>
    window.alert('La tarjeta o clave son incorrectas!');
    window.history.back();
    </script>");
}




?>


