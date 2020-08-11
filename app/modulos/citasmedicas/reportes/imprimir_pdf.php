<?php
	SESSION_START();  // lo bloquei hasta que pase el loging.php los datos xD :V recuerda ponerle el ! al if de abajo xD
	if(!isset($_SESSION["username"]))
	{
  
					
    	header("Location: ../../../../index.php");

    	require('fpdf/fpdf.php');

 	

	}


		require '../fpdf/fpdf.php';
	
	class PDF extends FPDF
	{
		function Header()
		{
			$this->Image('../logo1.png', 125, 5, 40);
			$this->SetFont('Arial','B',12);
			$this->Cell(30);
			$this->Ln(20);
			
	
		
		
		}
		
		function Footer()
		{
			$this->SetY(-15);
			$this->SetFont('Arial','I', 8);
			$this->AliasNbPages();
			$this->write(5, 'Pagina'.$this->PageNo().'/{nb}',0,0,'C' );
		}		
	}

	require '../conexion.php';


	
	$id_citas=$_POST['id_citas'];
	//$medicina=$_POST['medicinas'];
	$reposo=$_POST['reposo'];

	
	$query = "SELECT * from citas_medica  where idcitas='$id_citas' ";
	$resultado = $conexion->query($query);
	
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage('L');
	$row = $resultado->fetch_assoc();
	$pdf->SetFillColor(232,232,232);
	


	


	$pdf->SetFont('Arial','',10);

	$pdf->write(5, utf8_decode('   __________________________________________________________________________________________________________________________________________'));
	$pdf->Ln(8);
	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(0,0,utf8_decode('Historial clínico'),0,0,'C');

	$pdf->SetFont('Arial','',10);
$pdf->write(1, utf8_decode('   __________________________________________________________________________________________________________________________________________'));
	$pdf->Ln(15);

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,0,'Fecha: '.$row['fecha']."   Hora: ".$row['id_hora'],0,0,'C');
	$pdf->Ln(12);
	$pdf->SetFont('Arial','BU',12);
	$pdf->cell(0,0,'DATOS DEL PACIENTE',0,0,'C');
	$pdf->Ln(10);

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(130,0,utf8_decode('Cedula:'),0,0,'R');
	

	$pdf->SetFont('Arial','',12);
	$pdf->Cell(40,0,utf8_decode($row['idpacientes']),0,0,'C');


	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(135,0, utf8_decode('Nombres: '),0,0,'R');

	
	$pdf->SetFont('Arial','U',12);
	$pdf->Cell(20,0,utf8_decode($row['nombres']),0,0,'L');
	$pdf->Ln(10);

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(135,0,utf8_decode("Apellidos: "),0,0,'R');

	$pdf->SetFont('Arial','U',12);

	$pdf->Cell(30,0,$row['ape_paterno']." ".$row['ape_mat'],0,0,'');

	$pdf->Ln(10);

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(135,0,utf8_decode("Direccion: "),0,0,'R');

	$pdf->SetFont('Arial','U',12);

	$pdf->Cell(30,0,$row['direccion'],0,0,'');
	$pdf->Ln(10);

	$pdf->SetFont('Arial','BU',12);
	$pdf->cell(0,0,utf8_decode('DATOS DE LA INSTITUCIÓN'),0,0,'C');
	$pdf->Ln(10);

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(135,0,utf8_decode("Dependencia: "),0,0,'R');

	$pdf->SetFont('Arial','U',12);

	$pdf->Cell(30,0,utf8_decode($row['descripcion']),0,0,'');
	$pdf->Ln(10);

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,0,utf8_decode("Tiempo de reposo"),0,0,'C');

	$pdf->SetFont('Arial','U',12);
	$pdf->Ln(10);

	$pdf->Cell(0,0,utf8_decode($reposo),0,0,'C');
	$pdf->Ln(20);

    $pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,0,'_____________________________________',0,0,'C');
	$pdf->Ln(8);
	$pdf->Cell(0,0,utf8_decode("Médico responsable de la emisión"),0,0,'C');
	$pdf->Ln(8);
	$pdf->Cell(0,0,utf8_decode("DR(A) ".$row['nombreD']." ".$row['apellidos']),0,0,'C');






	$pdf->SetFont('Arial','',10);
		
	/*D = descargar*/
	$pdf->Output('Cita_Vitalia.pdf','i');




?>

		  
