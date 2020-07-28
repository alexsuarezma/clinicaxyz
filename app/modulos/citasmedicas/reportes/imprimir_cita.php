<?php
	//SESSION_START();  // lo bloquei hasta que pase el loging.php los datos xD :V recuerda ponerle el ! al if de abajo xD
	if(isset($_SESSION["user"]))
	{
  
					
    	header("Location: index.php");

    	require('fpdf/fpdf.php');

class PDF extends FPDF {

var $tablewidths;
var $footerset;

function _beginpage($orientation, $size) {
 $this->page++;

// Resuelve el problema de sobrescribir una página si ya existe.
 if(!isset($this->pages[$this->page])) 
  $this->pages[$this->page] = '';
 $this->state  =2;
 $this->x = $this->lMargin;
 $this->y = $this->tMargin;
 $this->FontFamily = '';

 // Compruebe el tamaño y la orientación.
 if($orientation=='')
  $orientation = $this->DefOrientation;
 else
  $orientation = strtoupper($orientation[0]);
 if($size=='')
  $size = $this->DefPageSize;
 else
  $size = $this->_getpagesize($size);
 if($orientation!=$this->CurOrientation || $size[0]!=$this->CurPageSize[0] || $size[1]!=$this->CurPageSize[1])
 {

  // Nuevo tamaño o la orientación
  if($orientation=='P')
  {
   $this->w = $size[0];
   $this->h = $size[1];
  }
  else
  {
   $this->w = $size[1];
   $this->h = $size[0];
  }
  $this->wPt = $this->w*$this->k;
  $this->hPt = $this->h*$this->k;
  $this->PageBreakTrigger = $this->h-$this->bMargin;
  $this->CurOrientation = $orientation;
  $this->CurPageSize = $size;
 }
 if($orientation!=$this->DefOrientation || $size[0]!=$this->DefPageSize[0] || $size[1]!=$this->DefPageSize[1])
  $this->PageSizes[$this->page] = array($this->wPt, $this->hPt);
}

function Footer() {

 // Compruebe si pie de página de esta página ya existe ( lo mismo para Header ( ) )
 if(!isset($this->footerset[$this->page])) {
  $this->SetY(-15);

  // Numero de Pagina
  $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');

  // Conjunto Footerset
  $this->footerset[$this->page] = true;
 }
}

function morepagestable($datas, $lineheight=13) {
 // Algunas cosas para establecer y ' recuerdan '
 $l = $this->lMargin;
 $startheight = $h = $this->GetY();
 $startpage = $currpage = $maxpage = $this->page;

 // Calcular todo el ancho
 $fullwidth = 0;
 foreach($this->tablewidths AS $width) {
  $fullwidth += $width;
 }

 // Ahora vamos a empezar a escribir la tabla
 foreach($datas AS $row => $data) {
  $this->page = $currpage;

  // Escribir los bordes horizontales
  $this->Line($l,$h,$fullwidth+$l,$h);

  // Escribir el contenido y recordar la altura de la más alta columna
  foreach($data AS $col => $txt) {
   $this->page = $currpage;
   $this->SetXY($l,$h);
   $this->MultiCell($this->tablewidths[$col],$lineheight,$txt);
   $l += $this->tablewidths[$col];

   if(!isset($tmpheight[$row.'-'.$this->page]))
    $tmpheight[$row.'-'.$this->page] = 0;
   if($tmpheight[$row.'-'.$this->page] < $this->GetY()) {
    $tmpheight[$row.'-'.$this->page] = $this->GetY();
   }
   if($this->page > $maxpage)
    $maxpage = $this->page;
  }

  // Obtener la altura estábamos en la última página utilizada
  $h = $tmpheight[$row.'-'.$maxpage];

  //Establecer el "puntero " al margen izquierdo
  $l = $this->lMargin;

  // Establecer el "$currpage en la ultima pagina
  $currpage = $maxpage;
 }

 // Dibujar las fronteras
 // Empezamos a añadir una línea horizontal en la última página
 $this->page = $maxpage;
 $this->Line($l,$h,$fullwidth+$l,$h);
 // Ahora empezamos en la parte superior del documento
 for($i = $startpage; $i <= $maxpage; $i++) {
  $this->page = $i;
  $l = $this->lMargin;
  $t  = ($i == $startpage) ? $startheight : $this->tMargin;
  $lh = ($i == $maxpage)   ? $h : $this->h-$this->bMargin;
  $this->Line($l,$t,$l,$lh);
  foreach($this->tablewidths AS $width) {
   $l += $width;
   $this->Line($l,$t,$l,$lh);
  }
 }
 // Establecerlo en la última página , si no que va a causar algunos problemas
 $this->page = $maxpage;
}
}			# code...
    	

	}


	include 'plantilla.php';
	require '../conexion.php';


	$id_alum=$_GET['id_alu'];
	
	$query = "SELECT * FROM citas_medica where idcitas= $id_alum ";
	$resultado = $conexion->query($query);
	
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$row = $resultado->fetch_assoc();
	$pdf->SetFillColor(232,232,232);
	


	$pdf->SetFont('Arial','',10);

	$pdf->write(5, utf8_decode('   ____________________________________________________________________________________________'));
	$pdf->Ln(8);
	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(195,6,'Hoja de cita',0,0,'C');

	$pdf->SetFont('Arial','',10);
	$pdf->write(5, utf8_decode('   ____________________________________________________________________________________________'));
	$pdf->Ln(15);

	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(195,6,utf8_decode('CITA N°: '.$row['idcitas']),0,0,'C');



	$pdf->SetFont('Arial','B',12);
	$pdf->Ln(12);
	$pdf->Cell(195,6,'Fecha de solicitud',0,0,'C');
	$pdf->Ln(12);

	$pdf->SetFont('Arial','',12);
	$pdf->Cell(195,6,'GUAYAQUIL/ '.$row['fecha'],0,0,'C');
	$pdf->Ln(12);


	
	$pdf->SetFont('Arial','B',12);
	$pdf->cell(195,6,'CONSULTA MEDICA',0,0,'C');
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln(12);

	$pdf->SetFont('Arial','',10);
	$pdf->Cell(85,6, utf8_decode('Para el dia '),0,0,'R');
	
	$pdf->SetFont('Arial','U',10);
	$pdf->Cell(20,6,utf8_decode($row['fecha']),0,0,'L');


	$pdf->SetFont('Arial','',10);
	$pdf->Cell(10,6,utf8_decode(" a las "),0,0,'R');

	$pdf->SetFont('Arial','U',10);

	$pdf->Cell(30,6,$row['hora'],0,0,'');

	$pdf->Ln(12);

	$pdf->SetFont('Arial','',10);

	$pdf->Cell(110,6,utf8_decode("Tiene cita asignada con Dr(a). "),0,0,'R');

	$pdf->SetFont('Arial','U',10);
	$pdf->Cell(15,6,utf8_decode($row['nombreD']." ".$row['apellidos']),0,0,'L'); 
	$pdf->Ln(12);

	$pdf->SetFont('Arial','',10);
	$pdf->cell(100,6,utf8_decode("del servicio de "),0,0,'R');
	$pdf->SetFont('Arial','U',10);
	$pdf->Cell(10,6,utf8_decode($row['descripcion']),0,0,'L');

	$pdf->Ln(30);

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


	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(10,10,"Nota:",0,0,'');
	$pdf->SetFont('Arial','',10);


	$pdf->write(10,utf8_decode(" Por favos, en caso de NO poder asistir a la consulta de "));
	$pdf->SetFont('Arial','B',10);
	$pdf->write(10,utf8_decode($row['descripcion']));
	$pdf->SetFont('Arial','',10);
	$pdf->write(10,utf8_decode(" agradeceriamos q lo comunique al telefono *** *** ** extensión ***** "));

/*
	$pdf->cell(42,6,'Datos de la cita:',1,0,'C',1);
	

	$pdf->Ln(10);
	$pdf->Cell(42,6,'Nombre del especialista: ',0,0,'');
	$pdf->Cell(40,6,utf8_decode($row['nombre_especialista']),0,0,'C' );
	
	$pdf->Ln(8);

	$pdf->Cell(42,6,'Espacialidad: ',0,0,'');
	$pdf->Cell(40,6,utf8_decode($row['nombre_especialidad']),0,0,'C' );

	$pdf->Ln(8);

	$pdf->Cell(42,6,'Fecha de la cita: ',0,0,'');
	$pdf->Cell(40,6,utf8_decode($row['fecha_cita']),0,0,'C' );
	
	$pdf->Ln(8);

	$pdf->Cell(42,6,'Hora de la cita: ',0,0,'');
	$pdf->Cell(40,6,utf8_decode($row['hora']),0,0,'C' );

	$pdf->Ln(8);

	$pdf->Cell(42,6,'Nombre del paciente: ',0,0,'');
	$pdf->Cell(40,6,utf8_decode($row['nombre_paciente']." ".$row['apellido_paciente'] ),0,0,'C' );

	$pdf->Ln(8);

	$pdf->Cell(42,6,'Cedula del paciente: ',0,0,'');
	$pdf->Cell(40,6,utf8_decode($row['cedula_paciente']),0,0,'C' );




	$pdf->Ln(20);
	/*
	$pdf->SetFont('Arial','B',10);
	$pdf->Write(5,utf8_decode('Descripcion del padecimiento:'));
	$pdf->SetFont('Arial','',10);


		$pdf->Ln(10);
	$pdf->write(5, utf8_decode('______________________________________________________________________________________________'));
	$pdf->write(5, utf8_decode('______________________________________________________________________________________________'));
	$pdf->write(5, utf8_decode('______________________________________________________________________________________________'));
	$pdf->write(5, utf8_decode('______________________________________________________________________________________________'));
	$pdf->write(5, utf8_decode('______________________________________________________________________________________________'));
	
	$pdf->Cell(42,8,'ID:',1,0,'C',1);
	$pdf->Cell(55,8,utf8_decode($row['id_alumno']),1,0,'C');
	$pdf->Cell(42,8,'Nombre y apellido: ',1,0,'C',1);
	$pdf->Cell(55,8,$row['apellido_alumno'].' '.$row['nombre_alumno'],1,0,'C',0,' ');
				
	
	
	$pdf->Ln(8);

	$pdf->Cell(42,8,'Cedula:',1,0,'C',1);
	$pdf->Cell(55,8,$row['cedula_alumno'],1,0,'C');

	$pdf->Cell(42,8,'Fecha de nacimiento:',1,0,'J',1);
	$pdf->Cell(55,8,$row['fecha_de_nacimiento'],1,0,'C');

	$pdf->Ln(8);


	$pdf->Cell(42,8,'Genero:',1,0,'C',1);
	$pdf->Cell(55,8,$row['genero'],1,0,'C');

	

	$pdf->Cell(42,8,'Estado civil',1,0,'C',1);
	$pdf->Cell(55,8,$row['nombre_civil'],1,0,'C');

	$pdf->Ln(8);


	$pdf->Cell(42,8,'E-mail:',1,0,'C',1);
	$pdf->Cell(55,8,$row['email_estudiante'],1,0,'C');

	$pdf->Cell(42,8,'Nivel:',1,0,'C',1);	
	$pdf->Cell(55,8,$row['nombre_nivel'],1,0,'C');

	$pdf->Ln(8);

	$pdf->Cell(42,8,'Seccion',1,0,'C',1);	
	$pdf->Cell(55,8,$row['seccion_curso'],1,0,'C');

	$pdf->Cell(42,8,'Periodo',1,0,'C',1);	
	$pdf->Cell(55,8,$row['nombre_periodo'],1,0,'C');	

	$pdf->Ln(8);


	$pdf->Cell(42,8,'Id Repre:',1,0,'C',1);
	$pdf->Cell(55,8,$row['id_representante'],1,0,'C');
	
	$pdf->Cell(42,8,'Nompre del representante:',1,0,'C',1);
	$pdf->Cell(55,8,$row['apellido_representante'].' '.$row['nombre_representante'],1,0,'C');

	$pdf->Ln(8);
	
	$pdf->Cell(42,8,'Cedula repre:',1,0,'C',1);
	$pdf->Cell(55,8,$row['cedula_representante'],1,0,'C');

	$pdf->Cell(42,8,'Estado civil:',1,0,'C',1);
	$pdf->Cell(55,8,$row['nombre_estado_civil'],1,0,'C');
	
	
	$pdf->Ln(8);

	$pdf->Cell(42,8,'Genero repre:',1,0,'C',1);
	$pdf->Cell(55,8,$row['genero_rep'],1,0,'C');

	$pdf->Cell(42,8,'Fecha nacimiento rep:',1,0,'C',1);	
	$pdf->Cell(55,8,$row['fecha_de_nacimiento_representante'],1,0,'C');
	$pdf->Ln(8);

	$pdf->Cell(42,8,'E-mail rep:',1,0,'C',1);	
	$pdf->Cell(55,8,$row['email_representante'],1,0,'C');

	$pdf->Cell(42,8,'# celular:',1,0,'C',1);	
	$pdf->Cell(55,8,$row['celular_representante'],1,0,'C');	


	$pdf->Ln(30);

	$pdf->Ln(10);
	$pdf->Cell(35,8,'Paciente:',0,0,'');
	$pdf->Cell(52,8,$row['apellido_paciente'].' '.$row['nombre_paciente'],0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(35,8,'Cedula:',0,0,'',0);
	$pdf->Cell(52,8,$row['cedula_paciente'],0,0,'C');
	$pdf->Ln(15);
	$pdf->Cell(28,8,'Firma del especialista:',0,0,'');

	$pdf->Cell(85,8,'________________________',0,0,'C');
	


	$pdf->Cell(32,8,'Firma del paciente:',0,0,'');

	$pdf->Cell(5,8,'________________________',0,0,'');
	$pdf->Ln(10);
	*/

	$pdf->SetFont('Arial','',10);
		
	/*D = descargar*/
	$pdf->Output('Cita_Vitalia.pdf','i');





?>

		  
