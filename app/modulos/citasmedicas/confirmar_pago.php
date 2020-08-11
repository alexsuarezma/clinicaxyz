<?php 
error_reporting(E_ALL ^ E_NOTICE);
require '../../../database.php';
require '../seguridad/controllers/functions/credenciales.php';


verificarAcceso("../../../", "paciente");



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


if (isset($_POST['guardar'])) {
	# code...
                	  echo ("<script LANGUAGE='JavaScript'>
    
    window.location.href='index.php ';
    </script>");

}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Confirmar cita</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="icon" type="image/png" href="logo1.png" />
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/checkout/">

  <!-- copia este!!! -->   <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">

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
	
   <header>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="../../../index.php">
      <span style="font-weight:normal;">Clinica</span>
      <span style="font-weight:bold;">Vitalia</span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
        
        </li>
      </ul>

      <?php 
        session_start();
        
          if(!empty($_SESSION['user_id'])): 
            require '../../../database.php';
                $credenciales = $conn->query("SELECT * FROM usuario_credencial WHERE id_usuario_uc =".$_SESSION['user_id'])->fetchAll(PDO::FETCH_OBJ);
                $_SESSION['modulo_rrhh'] = 0;
                $_SESSION['modulo_suministros'] = 0;
                $_SESSION['modulo_contabilidad'] = 0;
                $_SESSION['modulo_ctas_medicas'] = 0;
                $_SESSION['modulo_pacientes'] = 0;
                $_SESSION['modulo_seguridad'] = 0;
                $_SESSION['paciente'] = 0;
                $_SESSION['nombre_credencial'] = "";
                
                foreach ($credenciales as $idCredencial){ 

                    $records = $conn->prepare("SELECT * FROM usuario_credencial AS uc, credencial_base AS c, usuario AS u WHERE (uc.id_credencialbase_uc = c.id_credencial AND uc.id_usuario_uc = u.id_usuario) AND id_usuario_credencial = :id_usuario_credencial");
                    $records->bindParam(':id_usuario_credencial', $idCredencial->id_usuario_credencial);
                    $records->execute();
                    $results = $records->fetch(PDO::FETCH_ASSOC); 
                    if($results['modulo_rrhh'] == 1){
                      $_SESSION['modulo_rrhh'] = 1;
                    }
                    if($results['modulo_suministros'] == 1){
                      $_SESSION['modulo_suministros'] = 1;
                    }
                    if($results['modulo_contabilidad'] == 1){
                      $_SESSION['modulo_contabilidad'] = 1;
                    }
                    if($results['modulo_ctas_medicas'] == 1){
                      $_SESSION['modulo_ctas_medicas'] = 1;
                    }
                    if($results['modulo_pacientes'] == 1){
                      $_SESSION['modulo_pacientes'] = 1;
                    }
                    if($results['paciente'] == 1){
                      $_SESSION['paciente'] = 1;
                    }
                    if($results['modulo_seguridad'] == 1) {
                      $_SESSION['modulo_seguridad'] = 1;
                    }
                    if($_SESSION['nombre_credencial'] == ""){
                      $_SESSION['nombre_credencial'] = strtoupper($results['nombre_credencial']);
                    }else{
                      $_SESSION['nombre_credencial'] = $_SESSION['nombre_credencial'].", ".strtoupper($results['nombre_credencial']);
                    }
                }
                
                $_SESSION['username'] = ucwords($results['username']);
                

      ?>
          
          <span class="navbar-text mr-4"><?php echo $_SESSION['username']?></span>
          <a class='nav-link dropdown-toggle' style='color: white;' href='#' id='navbarDropdownMenuLink' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
            <i class="fas fa-th-large" ></i>
          </a>  
          <div class='dropdown-menu dropdown-menu-right mr-1 mb-2' style="width:400px;" aria-labelledby='navbarDropdownMenuLink'>
            <span class="dropdown-item font-weight-bold border-bottom border-info mb-2" style="text-align:center;"><?php echo $_SESSION['nombre_credencial']?></span>
            <?php
              if($_SESSION['modulo_rrhh'] == 1){
                echo "<a class='dropdown-item mt-2' href='../recursoshumanos/'><i class='fas fa-people-carry mr-2'></i> Recursos Humanos</a>";
              }
              if($_SESSION['modulo_suministros'] == 1){
                echo "<a class='dropdown-item' href='../suministro/index.php'><i class='fas fa-dolly-flatbed mr-2'></i> Suministros</a>";
              }
              if($_SESSION['modulo_contabilidad'] == 1){
                echo "<a class='dropdown-item' href='../contabilidad/index.php'><i class='fas fa-balance-scale mr-2'></i> Contabilidad</a>";
              }
              if($_SESSION['modulo_ctas_medicas'] == 1){
                echo "<a class='dropdown-item' href='../citasmedicas/index.php'><i class='fas fa-notes-medical mr-3'></i> Citas Medicas</a>";
                echo "<a class='dropdown-item' href='../citasmedicas/historial_clinico.php'><i class='fas fa-notes-medical mr-3'></i>Historial clinico</a>";
              }
              if($_SESSION['modulo_pacientes'] == 1){
                echo "<a class='dropdown-item' href='../pacientes/index copy 2.html'><i class='fas fa-procedures mr-2'></i> Modulo Pacientes</a>";
              }
              if($_SESSION['modulo_seguridad'] == 1){
                echo "<a class='dropdown-item' href='../seguridad/'><i class='fas fa-user-shield mr-2'></i> Modulo Seguridad</a>";
              }
              if($_SESSION['paciente'] == 1){
                echo "<a class='dropdown-item' href='../pacientes/index copy 2.html'><i class='fas fa-procedures mr-2'></i> Paciente</a>";

                echo "<a class='dropdown-item' href='index.php'><i class='fas fa-notes-medical mr-3'></i> Citas Medicas</a>";

                echo "<a class='dropdown-item' href='historial_clinico.php'><i class='fas fa-notes-medical mr-3'></i>Historial clínico</a>";
              }
              
            ?>            
            <!-- <a class='dropdown-item' href='#'><i class='fas fa-file-medical-alt mr-3'></i> Historial Clinico</a> -->
            <hr class="ml-4 mr-4 mt-2">
            <a class='dropdown-item mt-2' style="float:right;" href='../seguridad/routes/perfil.php'><span class="float-right">Ajustes de Usuario</span></a>
            <a class='dropdown-item' style="float:right;" href='#'><span class="float-right">Another</span></a>
            <a class='dropdown-item' style="float:right;" href='../seguridad/controllers/logout.php'><span class="float-right">Cerrar Sesión</span></a>
          </div>
       
      <?php else: ?>
        <span class="navbar-text">
          <a class='' href='app/modulos/seguridad/routes/login.php'>Iniciar sesión</a>
        </span>   
      <?php endif; ?>
      
      <!-- <li class='justify-content-end'>
        
      </li> -->
    </div>
  </nav>
</header>
<br><br><br><br><br>


	<center><h2>Confirmar método de pago</h2></center>
	<br>


	<div class="alert alert-success" role="alert" style="width: 800px; position: relative; left: 265px; top: 20px;">

	<form  class="needs-validation" action="guardar_cita.php"  method="POST" id="loginform">
<div class="form-group">
        
    <div class="col-md-4 mb-3">

    	<?php 


    	 

    	 ?>

		<input type="hidden" name="id_pa" value="<?php echo $id_paciente; ?>" id="id_pa" class="form-control" placeholder="ingrese tarjeta">
		<input type="hidden" name="id_doc" value="<?php echo $especialista; ?>" id="id_doc" class="form-control" placeholder="ingrese tarjeta">
		<input type="hidden" name="hora" value="<?php echo $hora; ?>" id="hora" class="form-control" placeholder="ingrese tarjeta">
		<input type="hidden" name="fecha" value="<?php echo $fecha; ?>" id="fecha" class="form-control" placeholder="ingrese tarjeta">
		<input type="hidden" name="especialidad" value="<?php echo $especialidad; ?>" id="especialidad" class="form-control" placeholder="ingrese tarjeta">

		<label>Número de tarjeta:</label> 
		<input type="text"   name="numero_tarjeta" id="numero_tarjeta" maxlength="16" class="form-control" placeholder="ingrese tarjeta" required="" onkeyup="this.value=NumText(this.value)" >
		<br>
		<label>Tipo de tarjeta:</label>
		<select class="custom-select d-block w-100" id="tipo" required="" >
			<option> -Seleccione-</option>
			<option>Crédito</option>
			<option>Débito</option>
		</select>
		<br>
		<label>Código de seguridad:</label>
		<input type="password" name="contrasenia" placeholder="Ingrese..." class="form-control" required="" >	


		
	</div>

	<div class="col-md-4 mb-3" style="position: absolute; left: 50%; top: 30px; ">
		<label><b>Descripción:</b> <?php echo "CITA ".$description_esp; ?></label><br>
		
		<label><b>Total:</b> <?php echo "$ ".$total; ?></label><br>
	<div class="alert alert-light" role="alert" style="  font: bold 80% Arial; color: green;">
 El valor ya incluye iva.
</div>

	</div>
	

<div style="position: relative; left: 20px;">
<input type="submit" value="Confirmar" class="btn btn-success" name="guardar" id="guardar"  >
<input type="button" class="btn btn-danger" onclick="window.location.href='index.php' "  name="volver atrás" value="Volver atrás">
</div>

</div>

	</form>
</div>
</body>
</html>

<!--
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
   
<script type="text/javascript">
$(document).ready(function() {
	    var id_numero = $('#numero_tarjeta');
        var contra = $('#contrasenia');
      
  $('#numero_tarjeta').change(function() { 

      var numero = $(this).val().length; //obtener el id seleccionado     


      

   
 
                // user is logged in successfully in the back-end
                // let's redirect

                if (numero < 15) {


                alert('El numero de tarjeta debe tener minimo 15 caracteres '+numero);


               
               	
                  $('#guardar').attr("disabled", true);
            					  }	else {   
            					  		 $('#guardar').attr("disabled", false);   



            							 }


            	


});

     });

</script>
-->