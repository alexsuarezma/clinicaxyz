<?php 
$id_citas=$_POST['id'];





?>

<form action="reportes/imprimir_pdf.php" target="_Blank" method="post">
<div class="col-mb-3">	
<input type="hidden" name="id_citas" value="<?php echo $id_citas ?>">
<label>Observacion:</label>
<textarea class="form-control" id="reposo" name="reposo" placeholder="Describa.."></textarea>
</div><br>
<!--<div class="col-mb-3">	
<label>Medicamentos:</label>
<textarea class="form-control" id="medicinas" placeholder="Describa.."></textarea>
</div><br><br>
-->
<input type="submit" class="btn btn-primary" value="Imprimir certificado" name="enviar" id="enviar">


</form>

