<?php 
$id_citas=$_POST['id'];





?>

<form action="reportes/imprimir_receta.php" target="_Blank" method="post">
<div class="col-mb-3">	
<input type="hidden" name="id_citas" value="<?php echo $id_citas ?>">
<label>Medicamento:</label>
<textarea class="form-control" id="medicamento" name="medicamento" placeholder="Describa.."></textarea>
</div><br>
<div class="col-mb-3">	
<label>Indicacion:</label>
<textarea class="form-control" id="indicacion" name="indicacion" placeholder="Describa.."></textarea>
</div><br><br>

<input type="submit" class="btn btn-primary" value="Imprimir receta" name="enviar" id="enviar">


</form>

