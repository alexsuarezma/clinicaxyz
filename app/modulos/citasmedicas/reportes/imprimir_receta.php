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
			$this->Image('../logo1.png', 85, 5, 40);
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


	
	$id_citas=$_GET['id_cita'];


	
	$query = "SELECT *,em.nombres as nom_em, pa.nombres as pa_nom from citas as ci join pacientes as pa on ci.paciente=pa.idpacientes
join citas_medicos as cime on ci.idcitas=cime.cita
join empleados_medico as emme on cime.medico=emme.id_medico
join empleados as em on emme.id_empleados_medico=em.id_empleados
join especialidades as es on emme.id_especialidad_medico=es.idespecialidades
 where  ci.idcitas='$id_citas' ";
	$resultado = $conexion->query($query);
	
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$row = $resultado->fetch_assoc();
	$pdf->SetFillColor(232,232,232);
	


	



	$pdf->SetFont('Arial','B',15);
	$pdf->Ln(15);
	$pdf->Cell(0,0,utf8_decode("DR(A) ".$row['nom_em']." ".$row['apellidos']),0,0,'C');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','U',10);
	$pdf->Cell(0,0,utf8_decode("Medico ".$row['descripcion']),0,0,'C');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(0,0,utf8_decode("Clínica Vitalia"),0,0,'C');	

	$pdf->Ln(12);

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,0,utf8_decode('Cita N°: '.$row['idcitas']),0,0,'C');
	




	$pdf->SetFont('Arial','B',12);
	$pdf->Ln(12);
	$pdf->Cell(0,0,'Guayaquil: '.$row['fecha']."                                                                                                 Hora: ".$row['id_hora'],0,0,'C');
	$pdf->Ln(12);

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(22,0,utf8_decode('Paciente: '),0,0,'R');
	

	$pdf->SetFont('Arial','',12);
	$pdf->Cell(60,0,utf8_decode($row['pa_nom']." ".$row['ape_paterno']." ".$row['ape_mat']),0,0,'L');


	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,0, utf8_decode('Rp. '),0,0,'L');

	$pdf->Ln(12);
	$pdf->SetFont('Arial','U',12);
	$pdf->write(5, utf8_decode($row['medicamentos']));
	$pdf->Ln(10);

	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,0, utf8_decode('Prescripción: '),0,0,'L');

	$pdf->Ln(12);
	$pdf->SetFont('Arial','U',12);
	$pdf->write(5, utf8_decode($row['tratamiento']));
	$pdf->Ln(90);


    $pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,0,'Firma: _____________________________________',0,0,'R');
	$pdf->Ln(8);
	



	$pdf->SetFont('Arial','',10);
		
	/*D = descargar*/
	$pdf->Output('Cita_Vitalia.pdf','i');




?>

		  
