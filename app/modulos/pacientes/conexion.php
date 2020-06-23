<?php
$conectar = mysqli_connect ('us-cdbr-east-05.cleardb.net','b7550b2dcd9c38','a16e5057','heroku_fe7e002859673b2');

if(!$conectar){
    echo"no se pudo conectar a la base de datos";
}else{
    
    echo"conexion exitosa";
}






?>