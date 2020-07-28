  <?php
 
      // Dirección o IP del servidor MySQL
      $host = "us-cdbr-east-05.cleardb.net";
 
      // Puerto del servidor MySQL
      $puerto = "3306";
 
      // Nombre de usuario del servidor MySQL
      $usuario = "b7550b2dcd9c38";
 
      // Contraseña del usuario
      $contrasena = "a16e5057";
 
      // Nombre de la base de datos
      $baseDeDatos ="heroku_fe7e002859673b2";
 
      // Nombre de la tabla a trabajar
      $tabla = "paciente";
 
   
         global $host, $puerto, $usuario, $contrasena, $baseDeDatos, $tabla;
 
         $conexion = mysqli_connect($host, $usuario, $contrasena, $baseDeDatos) or die ("error en la conexion ".mysqli_connect_error());
         
         mysqli_set_charset($conexion, "utf8");

     
           
 		
      ?>