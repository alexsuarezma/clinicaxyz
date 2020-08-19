
<?php 

require_once "clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();
$totalFInal =0.00;
$sql="SELECT b.Fecha, concat(c.nombres,' ',c.ape_paterno,' ',c.ape_mat) AS Cliente 
, sum(convert(a.sub_total,decimal(18,2))) as Subtotal,
	   sum(convert(a.iva,decimal(18,2))) as Iva,
	   sum(convert((a.sub_total+a.iva),decimal(18,2))) 
as Total FROM pagos a join citas b on a.id_cita = b.idcitas
join pacientes c on c.idpacientes = b.paciente
GROUP BY b.Fecha,concat(c.nombres,' ',c.ape_paterno,' ',c.ape_mat) ";
$result=mysqli_query($conexion,$sql);
?>


<div>
	<table class="table table-hover table-condensed table-bordered" id="iddatatable">
		<thead style="background-color: #5DADE2 ;color: white; font-weight: bold;">
			<tr>
				<td>Fecha</td>
				<td>cliente</td>
				<td>Subtotal</td>
				<td>IVA</td>
				<td>Total</td>
				
			
			</tr>
		</thead>
		<tbody >
			<?php 
			while ($mostrar=mysqli_fetch_row($result)) {
				?>
				<tr >
					<td><?php echo $mostrar[0] ?></td>
					<td><?php echo $mostrar[1] ?></td>
					<td>$ <?php echo $mostrar[2] ?></td>
					<td>$ <?php echo $mostrar[3] ?></td>
					<td>$ <?php echo $mostrar[4] ?></td>
					<?php  $totalFInal+=$mostrar[4] ?>
					<!--
					<td style="text-align: center;">
						<span class="btn btn-danger btn-sm" onclick="eliminarDatos('<?php echo $mostrar[0] ?>')">
							<span class="fa fa-trash"></span>
						</span>
					</td>
												-->
				</tr>
				<?php 
			}
			
			?>
			<tr>
			<td colspan="4">Total Ingresos</td>
			<td>$ <?php echo number_format((float)$totalFInal, 2, '.', ''); ?></td>
			</tr>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#iddatatable').DataTable();
	} );
</script>