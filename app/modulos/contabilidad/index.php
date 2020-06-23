<!DOCTYPE html>
<html>
<head>
	<title></title>



	<?php require_once "scripts.php"; 

	 ?>

</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="card text-left">
					<div class="card-header">
						
					</div>
					<div class="card-body">
						<span class="btn btn-primary" data-toggle="modal" data-target="#agregarnuevosdatosmodal">
							Agregar nueva Cuenta <span class="fa fa-plus-circle"></span>
						</span>
						<hr>
						<div id="tablaDatatable"></div>
					</div>
					<div class="card-footer text-muted">
						Area de Contabilidad 2020
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="agregarnuevosdatosmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Agrega cuentas</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="frmnuevo">
						<label>Codigo</label>
						<input type="text" class="form-control input-sm" id="cod_cta" name="cod_cta">
						<label>Nombre de la cuenta</label>
						<input type="text" class="form-control input-sm" id="nom_cta" name="nom_cta">
						<label>Tipo de Cuenta</label><br>

						 <select  id="tip_cta"  onchange="ddlselect();">
          						<option >Pasivo</option>
          						<option >Activo</option>
               			 </select>
						<input type="text"  class="form-control input-sm" id="tipo_cta" name="tipo_cta">
					 	<label>Ingresos</label>
						<input type="number" class="form-control input-sm" id="ing_cta" name="ing_cta">
						<label>Egresos</label>
						<input type="number" class="form-control input-sm" id="egre_cta" name="egre_cta">
										
					</form>
			
					




				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<button type="button" id="btnAgregarnuevo" class="btn btn-primary">Agregar nuevo</button>
				</div>
			</div>
		</div>
	</div>


	<!-- Modal -->
	<div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Actualizar cuenta</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="frmnuevoU">
						<input type="text" hidden="" id="idcta" name="idcta">
						<label>Codigo</label>
						<input type="text" class="form-control input-sm" id="cod_ctaU" name="cod_ctaU">
						<label>Nombre de la cuenta</label>
						<input type="text" class="form-control input-sm" id="nom_ctaU" name="nom_ctaU">
						<label>Tipo de Cuenta</label><br>
						<select  id="tip_ctaU"  onchange="ddlselectU();">
          						<option >Pasivo</option>
          						<option >Activo</option>
               			 </select>
						<input type="text" class="form-control input-sm" id="tipo_ctaU" name="tipo_ctaU">

						<label>Ingresos</label>
						<input type="number" class="form-control input-sm" id="ing_ctaU" name="ing_ctaU">
						<label>Egresos</label>
						<input type="number" class="form-control input-sm" id="egre_ctaU" name="egre_ctaU">

						</form>


						
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<button type="button" class="btn btn-warning" id="btnActualizar">Actualizar</button>
				</div>
			</div>
		</div>
	</div>


</body>
</html>



<script type="text/javascript">
	$(document).ready(function(){
		$('#btnAgregarnuevo').click(function(){
			datos=$('#frmnuevo').serialize();

			$.ajax({
				type:"POST",
				data:datos,
				url:"procesos/agregar.php",
				success:function(r){
					if(r==1){
						$('#frmnuevo')[0].reset();
						$('#tablaDatatable').load('tabla.php');
						alertify.success("agregado con exito :D");
					}else{
						alertify.error("Fallo al agregar :(");
					}
				}
			});
		});

		$('#btnActualizar').click(function(){
			datos=$('#frmnuevoU').serialize();

			$.ajax({
				type:"POST",
				data:datos,
				url:"procesos/actualizar.php",
				success:function(r){
					if(r==1){
						$('#tablaDatatable').load('tabla.php');
						alertify.success("Actualizado con exito :D");
					}else{
						alertify.error("Fallo al actualizar :(");
					}
				}
			});
		});
	});
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#tablaDatatable').load('tabla.php');
	});
</script>

<script type="text/javascript">
	function agregaFrmActualizar(idcta){
		$.ajax({
			type:"POST",
			data:"idcta=" + idcta,
			url:"procesos/obtenDatos.php",
			success:function(r){
				datos=jQuery.parseJSON(r);
				$('#idcta').val(datos['id_cta']);
				$('#cod_ctaU').val(datos['cod_cta']);
				$('#nom_ctaU').val(datos['nom_cta']);
				$('#tipo_ctaU').val(datos['tipo_cta']);
				$('#ing_ctaU').val(datos['ing_cta']);
				$('#egre_ctaU').val(datos['egre_cta']);
				
			}
		});
	}

	function eliminarDatos(idcta){
		alertify.confirm('Eliminar una cta', '¿Seguro de eliminar esta cta :(?', function(){ 

			$.ajax({
				type:"POST",
				data:"idcta=" + idcta,
				url:"procesos/eliminar.php",
				success:function(r){
					if(r==1){
						$('#tablaDatatable').load('tabla.php');
						alertify.success("Eliminado con exito !");
					}else{
						alertify.error("No se pudo eliminar...");
					}
				}
			});

		}
		, function(){

		});
	}
</script>
 <script type="text/javascript">
						
					function ddlselect()
					{

						var d=document.getElementById("tip_cta");
						var displaytext=d.options[d.selectedIndex].text;
						document.getElementById("tipo_cta").value=displaytext;
					}

					
						
					function ddlselectU()
					{

						var d=document.getElementById("tip_ctaU");
						var displaytext=d.options[d.selectedIndex].text;
						document.getElementById("tipo_ctaU").value=displaytext;
					}

					</script>