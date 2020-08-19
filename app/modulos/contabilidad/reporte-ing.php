<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
  
    $this->Image('img/clinicavitalia.jpg') ; 
    // Arial bold 15
    $this->SetFont('Arial','B',16);
    // Movernos a la derecha
    $this->Cell(80);
    // Título
    $this->Cell(45,10,'Reporte de Ingresos',0,0,'C');
    // Salto de línea
    $this->Ln(20);

    $this->Cell(23, 10, 'Fecha',1, 0, 'C', 0);
    $this->Cell(78, 10, 'Cliente',1, 0, 'C', 0);
    $this->Cell(30, 10, 'Subtotal',1, 0, 'C', 0);
    $this->Cell(30, 10, 'IVA',1, 0, 'C', 0);
    $this->Cell(30, 10, 'Total',1, 1, 'C', 0);
}

				
// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,utf8_decode('Página').$this->PageNo().'/{nb}',0,0,'C');
}
}
require 'conex.php';
$consulta = "SELECT b.Fecha, concat(c.nombres,' ',c.ape_paterno,' ',c.ape_mat) AS Cliente 
, sum(convert(a.sub_total,decimal(18,2))) as Subtotal,
	   sum(convert(a.iva,decimal(18,2))) as Iva,
	   sum(convert((a.sub_total+a.iva),decimal(18,2))) 
as Total FROM pagos a join citas b on a.id_cita = b.idcitas
join pacientes c on c.idpacientes = b.paciente
GROUP BY b.Fecha,concat(c.nombres,' ',c.ape_paterno,' ',c.ape_mat) ";
$resultado = $mysqli->query($consulta);


$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',11);
$totalIngreso = 0;
$totalEgreso = 0;
while($row = $resultado->fetch_assoc()){
    $pdf->Cell(23, 10, $row['Fecha'],1, 0, 'C', 0);
    $pdf->Cell(78, 10,utf8_decode( $row['Cliente']),1, 0, 'C', 0);
    $pdf->Cell(30, 10, $row['Subtotal'],1, 0, 'C', 0);
    $pdf->Cell(30, 10, $row['Iva'],1, 0, 'C', 0);
    $pdf->Cell(30, 10, $row['Total'],1, 1, 'C', 0);
    $totalIngreso += $row['Total'];
    $totalEgreso += $row['Total'];
}
$pdf->Cell(131,10,"Totales",1,0,'C',0);
$pdf->Cell(30,10,$totalIngreso,1,0,'C',0);
$pdf->Cell(30,10,$totalEgreso,1,0,'C',0);
$pdf ->Output();
?>