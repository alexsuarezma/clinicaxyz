<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
  
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Movernos a la derecha
    $this->Cell(80);
    // Título
    $this->Cell(45,10,'Registro de Cuentas',0,0,'C');
    // Salto de línea
    $this->Ln(20);

    $this->Cell(25, 10, 'Codigo',1, 0, 'C', 0);
    $this->Cell(75, 10, 'Nombre',1, 0, 'C', 0);
    $this->Cell(30, 10, 'Tipo',1, 0, 'C', 0);
    $this->Cell(30, 10, 'Ingresos',1, 0, 'C', 0);
    $this->Cell(30, 10, 'Egresos',1, 1, 'C', 0);
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
$consulta = "SELECT * FROM cuentas";
$resultado = $mysqli->query($consulta);


$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
while($row = $resultado->fetch_assoc()){
    $pdf->Cell(25, 10, $row['cod_cta'],1, 0, 'C', 0);
    $pdf->Cell(75, 10, $row['nom_cta'],1, 0, 'C', 0);
    $pdf->Cell(30, 10, $row['tipo_cta'],1, 0, 'C', 0);
    $pdf->Cell(30, 10, $row['ing_cta'],1, 0, 'C', 0);
    $pdf->Cell(30, 10, $row['egre_cta'],1, 1, 'C', 0);
}
$pdf ->Output();
?>





