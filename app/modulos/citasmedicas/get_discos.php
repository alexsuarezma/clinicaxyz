<?php
require_once 'con_db.php'; //libreria de conexion a la base

$banda_id = filter_input(INPUT_POST, 'banda_id'); //obtenemos el parametro que viene de ajax


if($banda_id != ''){ //verificamos nuevamente que sea una opcion valida
  $con = conDb();
  if(!$con){
    die("<br/>Sin conexi&oacute;n.");

  }

  /*Obtenemos los discos de la banda seleccionada*/
  $sql = "SELECT  esp.id_medico, esp.id_empleados_medico,emp.nombres, emp.apellidos from empleados_medico as esp join especialidades as espd on espd.idespecialidades=esp.id_especialidad_medico join empleados as emp 
  on emp.id_empleados=esp.id_empleados_medico where espd.idespecialidades='$banda_id'";  
  $query = mysqli_query($con, $sql);
  $filas = mysqli_fetch_all($query, MYSQLI_ASSOC); 
  mysqli_close($con);
}

/**
 * Como notaras vamos a generar código `html`, esto es lo que sera retornado a `ajax` para llenar 
 * el combo dependiente
 */
?>

<option value="">- <?php echo $banda_id ?>-</option>
<?php foreach($filas as $op): //creamos las opciones a partir de los datos obtenidos ?>
<option value="<?php echo  $op['id_empleados_medico'] ?>"><?= $op['apellidos']." ".$op['nombres']?></option>
<?php endforeach; ?>