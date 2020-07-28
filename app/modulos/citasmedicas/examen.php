

<?php 

include 'conexion.php';


function comparar(){




}



$consulta= "	
SELECT * FROM cita ";

$sql=mysqli_query($conexion, $consulta);

$num= mysqli_num_rows($sql);

  

for ($i=0; $i < $num; $i++) { 
		
 
      $hora_db=mysqli_fetch_array($sql);

         echo $hora_db['hora_cita'];

      



}




?>