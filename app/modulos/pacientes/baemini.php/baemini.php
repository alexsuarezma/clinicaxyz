<?php
$conex = mysqli_connect("localhost","root","","clinicprueb");
if(!$conex){
    echo 'error al conectar la base de datos';
}
else{
    echo 'conectado a la abse de datos';
}
?>