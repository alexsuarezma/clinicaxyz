<?
include 'baemini.php';
$cedula = $_POST["cedula"];
$nombre = $_POST["fnom"];
$apellidop = $_POST["fapell11"];
$apellidom = $_POST["fapell2"];
$fech_nac = $_POST["fnac"];
$ocupacion = $_POST["ocup"];
$sexo = $_POST["gender"];
$ciudad = $_POST["citi"];
$telefono = $_POST["ftel"];
$celular = $_POST["fcel"];
$email = $_POST["fmail"];
$direc = $_POST["fdir"];
$afil = $_POST["afil"];
$disca = $_POST["discap"];
$conad = $_POST["conad"];
$discapa = $_POST["discapa"];
$grado = $_POST["grado"];

$insertar = "INSERT INTO pacientes (idpacientes,ape_paterno,ape_mat,nombres,ocupación,sexo,f_nacimiento,provincia,ciudad,zona,dirección,tlno_particular,tlno_personal,correo) VALUES ('$cedula','$apellidop','$apellidom','$nombre','$ocupacion','$sexo','$fech_nac','','$ciudad','','$direc','$telefono','$celular','$email')";
$resultado= mysqli_query($conex,$insertar)
if (!$resultado){
    echo 'error al registrarse';
}
else{
    echo 'usuario registrado exitosamente';
}

mysqli_close($conexion);
/**$s = $_POST[""]**/
    ?>