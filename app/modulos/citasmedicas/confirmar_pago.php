<?php 
include 'conexion.php';
$id_paciente=$_GET['id_paciente'];
$cedula=$_GET['cedula'];
$especialidad=$_GET['especialidad'];
$especialista=$_GET['especialista'];
$fecha=$_GET['fecha'];
$hora=$_GET['hora'];


$sub_total=13.2;
$iva=1.8;
$total=$sub_total+$iva;

$msj="";

$num_tj="";



$sentencia_esp="SELECT * from especialidades where idespecialidades='$especialidad' ";
$resultado_esp=mysqli_query($conexion,$sentencia_esp);
$mostrar_esp=mysqli_fetch_array($resultado_esp);
$description_esp=$mostrar_esp['descripcion'];

?>

<!DOCTYPE html>
<html>
<head>
	<title>confirmar</title>
 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <title>Consultar Cita</title>
    <link rel="icon" type="image/png" href="logo1.png" />
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/checkout/">

    <!-- Bootstrap core CSS -->
<link href="../assets/dist/css/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<LINK REL=StyleSheet HREF="formulario.css" TYPE="text/css" MEDIA=screen>

</head>
<body>

<script type="text/javascript">
	function NumText(string){//solo letras y numeros
    var out = '';
    //Se añaden las letras validas
    var filtro = 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ1234567890';//Caracteres validos
	
    for (var i=0; i<string.length; i++)
       if (filtro.indexOf(string.charAt(i)) != -1) 
	     out += string.charAt(i);
    return out;
}
</script>	
	<br><br><br>

	<center><h2>Confirmar método de pago</h2></center>
	<br>


	<div class="alert alert-success" role="alert" style="width: 800px; position: relative; left: 265px; top: 20px;">

	<form  class="needs-validation" action="guardar_cita.php" method="POST">
<div class="form-group">
        
    <div class="col-md-4 mb-3">

    	<?php 


    	 

    	 ?>

		<input type="hidden" name="id_pa" value="<?php echo $id_paciente; ?>" id="id_pa" class="form-control" placeholder="ingrese tarjeta">
		<input type="hidden" name="id_doc" value="<?php echo $especialista; ?>" id="id_doc" class="form-control" placeholder="ingrese tarjeta">
		<input type="hidden" name="hora" value="<?php echo $hora; ?>" id="hora" class="form-control" placeholder="ingrese tarjeta">
		<input type="hidden" name="fecha" value="<?php echo $fecha; ?>" id="fecha" class="form-control" placeholder="ingrese tarjeta">
		<input type="hidden" name="especialidad" value="<?php echo $especialidad; ?>" id="especialidad" class="form-control" placeholder="ingrese tarjeta">

		<label>Numero de tarjeta:</label> 
		<input type="text"   name="numero_tarjeta" id="numero_tarjeta" maxlength="16" class="form-control" placeholder="ingrese tarjeta" onkeyup="this.value=NumText(this.value)" >
		<br>
		<label>Tipo de tarjeta:</label>
		<select class="custom-select d-block w-100" id="tipo" >
			<option> -Seleccione-</option>
			<option>Credito</option>
			<option>Debito</option>
		</select>
		<br>
		<label>Codigo de seguridad</label>
		<input type="password" name="contrasenia" placeholder="Ingrese..." class="form-control" >	


		
	</div>

	<div class="col-md-4 mb-3" style="position: absolute; left: 50%; top: 30px; ">
		<label><b>Descripción:</b> <?php echo "CITA ".$description_esp; ?></label><br>
		
		<label><b>Total:</b> <?php echo "$ ".$total; ?></label><br>
	<div class="alert alert-light" role="alert" style="  font: bold 80% Arial; color: green;">
 El valor ya incluye iva.
</div>

	</div>
	

<div style="position: relative; left: 20px;">
<input type="submit" value="confirmar" class="btn btn-success" name="guardar" id="guardar" >
 <input type="button" class="btn btn-danger" onclick="history.back()" name="volver atrás" value="volver atrás">
</div>

</div>

	</form>
</div>
</body>
</html>