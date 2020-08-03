<?php
require_once 'con_db.php'; //libreria de conexion a la base

 date_default_timezone_set('AMERICA/GUAYAQUIL');

  $fecha_actual=date("Y-m-d");  
$banda_id = filter_input(INPUT_POST, 'banda_id_f'); //obtenemos el parametro que viene de ajax
$doctor_idd= filter_input(INPUT_POST, 'discos_hora');
$especialidad_id= filter_input(INPUT_POST, 'especialidad');

if($banda_id != ''){ //verificamos nuevamente que sea una opcion valida
  $con = conDb();
  if(!$con){
    die("<br/>Sin conexi&oacute;n.");

  }

  /*Obtenemos los discos de la banda seleccionada*/
 /* $sql = "
SELECT ho.id_hora,ho.hora
FROM hora ho
WHERE not EXISTS(SELECT ci.id_hora 
FROM citas ci
WHERE ho.id_hora = ci.id_hora and ci.fecha='$banda_id' );
";  
*/

$sql="SELECT  * from empleados as emp join cargo_horario as caho on  emp.id_cargo_horario_emp=caho.id_cargo_horario
join horario_empleado as hoem on hoem.id_horario_empleado=caho.id_horario_ch where emp.medico=1 and emp.id_empleados='$doctor_idd';";
  $query = mysqli_query($con, $sql);
 
  $filas = mysqli_fetch_array($query, MYSQLI_ASSOC); 
  $inicio=$filas['inicio'];
   $fin=$filas['finalizacion'];
   $fechaInicio =  $inicio;
$fechaFin = $fin;

 



 
# Fecha como segundos
$tiempoInicio = strtotime($fechaInicio);
$tiempoFin = strtotime($fechaFin);
#60 minutos por hora * 60 segundos por minuto
$hora = 3600;
$id_hora=1;
$conteo=1;

?>


<option value="">-Seleccione-</option>
 <?php
while($tiempoInicio <= $tiempoFin){
  # Podemos recuperar la fecha actual y formatearla
  # Más información: http://php.net/manual/es/function.date.php
  $fechaActual = date("H:i:s", $tiempoInicio);

  $sentencia_comparar="SELECT * from citas_medica as ci where  ci.id_hora='$fechaActual' and ci.fecha='$fecha_actual' and ci.id_empleados='$doctor_idd'  " ;
  $resul_conteo=mysqli_query($con,$sentencia_comparar);
  $conteo_c=mysqli_num_rows($resul_conteo);

  if ($conteo_c >0) {
  
  	$mostrar="ocupado";
 

  ?>



  <?php
   } else {

   ?>

<option value="<?php echo  $fechaActual ?>"><?= $fechaActual ?></option>

<?php
}
  # Sumar el incremento para que en algún momento termine el ciclo
  $tiempoInicio += $hora;
  $id_hora += $conteo;
   
}
mysqli_close($con);
}

/**
 * Como notaras vamos a generar código `html`, esto es lo que sera retornado a `ajax` para llenar 
 * el combo dependiente
 */
?>






