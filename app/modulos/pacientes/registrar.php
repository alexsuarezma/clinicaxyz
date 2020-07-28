<?php   
include("conexion.php");
$ced = $_POST["id"];
$nombre = $_POST["nombre"];
$apep = $_POST["apep"];
$apem = $_POST["apem"];
$fech = $_POST["fech"];
$ocup = $_POST["ocup"];
$sexo = $_POST["sexo"];
$ciudad = $_POST["ciudad"];
$pais = $_POST["pais"];
$prov = $_POST["provincia"];
$telefono = $_POST["telf"];
$celular = $_POST["cel"];
$email = $_POST["correo"];
$direc = $_POST["dire"];
//
//$afil = $_POST["afil"];
//$afiltip = $_POST["afiltip"];
$discap= $_POST["discap"];
$conad = $_POST["carnet"];
$discapa = $_POST["discapsel"];
$grado = $_POST["por"];
//

$registro="INSERT INTO pacientes(idpacientes, ape_paterno, ape_mat, nombres, ocupación, sexo, f_nacimiento, provincia, ciudad, zona, direccion, tlno_particular, tlno_personal, correo) VALUES ('$ced','$apep','$apem','$nombre','$ocup','$sexo','$fech','$pais','$prov','$ciudad','$direc','$telefono','$celular','$email')";
$regiscon="INSERT INTO conadis(paciente, carnet, discapacidad, grado) VALUES ('$ced','$conad','$discapa','$grado')";

$resultado = mysqli_query ($conectar,$registro);

if($resultado ){
    $res2 = mysqli_query($conectar,$regiscon);
?>
<h3> !registrado correctamente </h3>
<?php
}else{
    ?>
    <h3> !no te has registrado correctamente </h3>
    <?php
}

header("Location:index.html");

?>