<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
  
    $this->Image('img/clinicavitalia.jpg') ; 
    // Arial bold 15
    $this->SetFont('Arial','B',14);
    // Movernos a la derecha
    $this->Cell(78);
    // Título
    $this->Cell(40,10,'Reporte de Egresos',0,0,'C');
    // Salto de línea
    $this->Ln(20);

    $this->Cell(22, 10, 'Fecha',1, 0, 'C', 0);
    $this->Cell(55, 10, 'Descripcion',1, 0, 'C', 0);
    $this->Cell(18, 10, 'Cant.',1, 0, 'C', 0);
    $this->Cell(20, 10, 'P.Unit.',1, 0, 'C', 0);
    $this->Cell(23, 10, 'Subtotal',1, 0, 'C', 0);
    $this->Cell(23, 10, 'Iva',1, 0, 'C', 0);
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
$consulta = "SELECT a.fecha_pago,
d.nombre_pr,
b.cantidad ,
convert(b.precio_unitario,decimal(18.2)) as pu,
convert(b.cantidad*b.precio_unitario,decimal(18,2)) as subtotal,
convert(((b.cantidad*b.precio_unitario)*0.12),decimal(18,2)) as IVA,
convert(((b.cantidad*b.precio_unitario)+((b.cantidad*b.precio_unitario)*0.12)),decimal(18,2)) as
 Total from orden_compra a join detalle_orden_compra b on a.id_orden_compra = b.id_orden_compra_dt
join producto_has_proveedor c on c.idproducto_has_proveedor = b.id_prod_has_prov
join productos d on d.idproducto = c.idproducto_has
where a.estado in ('pagado')";
$resultado = $mysqli->query($consulta);


$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',11);

$totalEgreso = 0;
while($row = $resultado->fetch_assoc()){
    $pdf->Cell(22, 10, $row['fecha_pago'],1, 0, 'C', 0);
    $pdf->Cell(55, 10,utf8_decode( $row['nombre_pr']),1, 0, 'C', 0);
    $pdf->Cell(18, 10, $row['cantidad'],1, 0, 'C', 0);
    $pdf->Cell(20, 10, $row['pu'],1, 0, 'C', 0);
    $pdf->Cell(23, 10, $row['subtotal'],1, 0, 'C', 0);
    $pdf->Cell(23, 10, $row['IVA'],1, 0, 'C', 0);
    $pdf->Cell(30, 10, $row['Total'],1, 1, 'C', 0);
    $totalEgreso += $row['Total'];
}
$pdf->Cell(161,10,"Total",1,0,'C',0);
$pdf->Cell(30,10,$totalEgreso,1,0,'C',0);
$pdf ->Output();
?>