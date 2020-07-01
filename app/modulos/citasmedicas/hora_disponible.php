<?php
require_once 'con_db.php'; //libreria de conexion a la base

$banda_id = filter_input(INPUT_POST, 'banda_id_f'); //obtenemos el parametro que viene de ajax


if($banda_id != ''){ //verificamos nuevamente que sea una opcion valida
  $con = conDb();
  if(!$con){
    die("<br/>Sin conexi&oacute;n.");

  }

  /*Obtenemos los discos de la banda seleccionada*/
  $sql = "
SELECT ho.id_hora,ho.hora
FROM hora ho
WHERE not EXISTS(SELECT ci.id_hora 
FROM citas ci
WHERE ho.id_hora = ci.id_hora and ci.fecha='$banda_id' );
";  
  $query = mysqli_query($con, $sql);
  $filas = mysqli_fetch_all($query, MYSQLI_ASSOC); 
  mysqli_close($con);
}

/**
 * Como notaras vamos a generar código `html`, esto es lo que sera retornado a `ajax` para llenar 
 * el combo dependiente
 */
?>






<option value="">- Seleccione-</option>
<?php foreach($filas as $op): //creamos las opciones a partir de los datos obtenidos ?>
<option value="<?php echo  $op['id_hora'] ?>"><?= $op['hora'] ?></option>
<?php endforeach; ?>