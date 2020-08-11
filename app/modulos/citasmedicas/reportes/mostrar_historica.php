<?php
	SESSION_START();  // lo bloquei hasta que pase el loging.php los datos xD :V recuerda ponerle el ! al if de abajo xD
	if(!isset($_SESSION["username"]))
	{
  
					
    	header("Location: ../../../../index.php");

    	require('fpdf/fpdf.php');

 	

	}


	include 'plantilla.php';
	require '../conexion.php';


	$id_paciente=$_GET['id_paciente'];
	$id_citas=$_GET['id_citas'];
	
	$query = "SELECT *,ciu.nombre as ci_nom,pro.nombre as pro_nom from citas as ci join pacientes as pa on ci.paciente=pa.idpacientes

join provincias as pro on pa.provincia=pro.idprovincias
join ciudades as ciu on  pa.ciudad=ciu.idciudades where pa.idpacientes='$id_paciente' and ci.idcitas='$id_citas' ";
	$resultado = $conexion->query($query);
	
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$row = $resultado->fetch_assoc();
	$pdf->SetFillColor(232,232,232);
	


	


	$pdf->SetFont('Arial','',10);

	$pdf->write(5, utf8_decode('   ____________________________________________________________________________________________'));
	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(0,0,utf8_decode('Historial clínico'),0,0,'C');

	$pdf->SetFont('Arial','',10);
	$pdf->write(5, utf8_decode('   ____________________________________________________________________________________________'));
	$pdf->Ln(15);

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,0,'Fecha: '.$row['fecha']."   Hora: ".$row['id_hora'],0,0,'C');
	$pdf->Ln(12);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,0,utf8_decode('No. de historia:'),0,0,'C');
	$pdf->Ln(12);

	$pdf->SetFont('Arial','',12);
	$pdf->Cell(0,0,utf8_decode($row['idpacientes']),0,0,'C');

	$pdf->Ln(12);



	
	$pdf->SetFont('Arial','B',12);
	$pdf->cell(0,0,'DATOS DEL PACIENTE',0,0,'C');
	$pdf->SetFont('Arial','B',12);
	$pdf->Ln(10);
	$pdf->Cell(90,6, utf8_decode('Nombres: '),0,0,'R');

	
	$pdf->SetFont('Arial','U',12);
	$pdf->Cell(20,6,utf8_decode($row['nombres']),0,0,'L');
	$pdf->Ln(10);

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(90,6,utf8_decode("Apellidos: "),0,0,'R');

	$pdf->SetFont('Arial','U',12);

	$pdf->Cell(30,6,$row['ape_paterno']." ".$row['ape_mat'],0,0,'');

	$pdf->Ln(10);

	$pdf->SetFont('Arial','B',12);

	$pdf->Cell(92,6,utf8_decode("Ocupacion: "),0,0,'R');

	$pdf->SetFont('Arial','U',12);
	$pdf->Cell(20,6,utf8_decode($row['ocupacion']),0,0,'L'); 
	$pdf->Ln(10);

	$pdf->SetFont('Arial','B',12);
	$pdf->cell(100,6,utf8_decode("Sexo: "),0,0,'R');
	$pdf->SetFont('Arial','U',12);
	$pdf->Cell(10,6,utf8_decode($row['sexo']),0,0,'L');

	$pdf->SetFont('Arial','B',12);
	$pdf->Ln(10);
	$pdf->Cell(120,6, utf8_decode('Fecha de nacimiento:'),0,0,'R');

	
	$pdf->SetFont('Arial','U',12);
	$pdf->Cell(20,6,utf8_decode($row['f_nacimiento']),0,0,'L');
	$pdf->Ln(10);

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(90,6,utf8_decode("Direccion: "),0,0,'R');

	$pdf->SetFont('Arial','U',12);

	$pdf->Cell(30,6,$row['direccion'],0,0,'');

	$pdf->Ln(10);

	$pdf->SetFont('Arial','B',12);

	$pdf->Cell(92,6,utf8_decode("Zona: "),0,0,'R');

	$pdf->SetFont('Arial','U',12);
	$pdf->Cell(20,6,utf8_decode($row['zona']),0,0,'L'); 
	$pdf->Ln(10);

	$pdf->SetFont('Arial','B',12);
	$pdf->cell(95,6,utf8_decode("Telefono: "),0,0,'R');
	$pdf->SetFont('Arial','U',12);
	$pdf->Cell(10,6,utf8_decode($row['tlno_particular']),0,0,'L');


	
	$pdf->SetFont('Arial','B',12);
	$pdf->Ln(10);
	$pdf->Cell(90,6, utf8_decode('Celular: '),0,0,'R');

	
	$pdf->SetFont('Arial','U',12);
	$pdf->Cell(20,6,utf8_decode($row['tlno_personal']),0,0,'L');
	$pdf->Ln(10);

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(90,6,utf8_decode("Correo electronico: "),0,0,'R');

	$pdf->SetFont('Arial','U',12);

	$pdf->Cell(30,6,$row['correo'],0,0,'');

	$pdf->Ln(10);

	$pdf->SetFont('Arial','B',12);

	$pdf->Cell(95,6,utf8_decode("Afiliado: "),0,0,'R');

	$pdf->SetFont('Arial','U',12);
	$pdf->Cell(20,6,utf8_decode($row['afiliado']),0,0,'L'); 
	$pdf->Ln(10);

	$pdf->SetFont('Arial','B',12);
	$pdf->cell(90,6,utf8_decode("Ciudad: "),0,0,'R');
	$pdf->SetFont('Arial','U',12);
	$pdf->Cell(10,6,utf8_decode($row['ci_nom']),0,0,'L');

	$pdf->SetFont('Arial','B',12);
	$pdf->Ln(10);
	$pdf->Cell(90,6, utf8_decode('Provincia: '),0,0,'R');

	
	$pdf->SetFont('Arial','U',12);
	$pdf->Cell(20,6,utf8_decode($row['nombre']),0,0,'L');
	$pdf->Ln(100);


	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell(0,0,utf8_decode("ANAMNESIS"),0,0,'C');

	$pdf->Ln(10);

	$pdf->SetFont('Arial','B',12);



	$pdf->Cell(0,0,utf8_decode('Diagnóstico'),0,0,'C');
	if ($row['observaciones'] !=='') {
		$pdf->SetFont('Arial','',12);
		$pdf->write(5,utf8_decode($row['observaciones']));
	} else {
	$pdf->SetFont('Arial','B',10);	
	$pdf->write(5, utf8_decode('   ___________________________________________________________________________________________'));
	$pdf->Ln(5);	
	$pdf->write(5, utf8_decode('   ___________________________________________________________________________________________'));
	$pdf->Ln(5);
	$pdf->write(5, utf8_decode('   ___________________________________________________________________________________________'));
	$pdf->Ln(8);
	}

	$pdf->Ln(8);

	$pdf->SetFont('Arial','B',12);

	$pdf->cell(0,0,utf8_decode("Tratamiento"),0,0,'C');

if ($row['tratamiento'] !=='') {
	$pdf->SetFont('Arial','',12);
		$pdf->write(5,utf8_decode($row['tratamiento']));
	} else {
	$pdf->SetFont('Arial','B',10);	
	$pdf->write(5, utf8_decode('   ___________________________________________________________________________________________'));
	$pdf->Ln(5);	
	$pdf->write(5, utf8_decode('   ___________________________________________________________________________________________'));
	$pdf->Ln(5);
	$pdf->write(5, utf8_decode('   ___________________________________________________________________________________________'));
	$pdf->Ln(8);
	}

	$pdf->Ln(10);

	$pdf->SetFont('Arial','B',12);
	$pdf->cell(0,0,utf8_decode("Medicamentos"),0,0,'C');

if ($row['medicamentos'] !== ''  ) {
	$pdf->SetFont('Arial','',12);
		$pdf->write(5,utf8_decode($row['medicamentos']));
	} else {
	$pdf->SetFont('Arial','B',10);	
	$pdf->write(5, utf8_decode('   ___________________________________________________________________________________________'));
	$pdf->Ln(5);	
	$pdf->write(5, utf8_decode('   ___________________________________________________________________________________________'));
	$pdf->Ln(5);
	$pdf->write(5, utf8_decode('   ___________________________________________________________________________________________'));
	$pdf->Ln(8);
	}



	$pdf->Ln(20);

	$pdf->SetFont('Arial','',10);

	$pdf->write(5, utf8_decode('   ___________________________________________________________________________________________'));
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(195,6,utf8_decode('Este documento deberá ser presentado como soporte de haber agendado una cita al momento de'),0,0,'C');
	$pdf->Ln(8);
	$pdf->Cell(195,6,utf8_decode("acercarse a su consulta"),0,0,'C');

	$pdf->SetFont('Arial','',10);
	$pdf->write(5, utf8_decode('   ___________________________________________________________________________________________'));
	$pdf->Ln(20);



	$pdf->SetFont('Arial','',10);
		
	/*D = descargar*/
	$pdf->Output('Cita_Vitalia.pdf','i');

?>

		  
