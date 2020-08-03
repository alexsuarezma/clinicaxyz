<?php
	require '../fpdf/fpdf.php';
	
	class PDF extends FPDF
	{
		function Header()
		{
			$this->Image('../logo1.png', 75, 5, 50);
			$this->SetFont('Arial','B',12);
			$this->Cell(30);
			$this->Ln(40);
			
	
		
		
		}
		
		function Footer()
		{
			$this->SetY(-15);
			$this->SetFont('Arial','I', 8);
			$this->AliasNbPages();
			$this->write(5, 'Pagina'.$this->PageNo().'/{nb}',0,0,'C' );
		}		
	}
?>