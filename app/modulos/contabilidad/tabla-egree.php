<?php 

require_once "clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();
$totalFInal =0;
$sql="SELECT a.fecha_pago,
d.nombre_pr,
b.cantidad,
convert(b.precio_unitario,decimal(18.2)),
convert(b.cantidad*b.precio_unitario,decimal(18,2)),
convert(((b.cantidad*b.precio_unitario)*0.12),decimal(18,2)) as IVA,
convert(((b.cantidad*b.precio_unitario)+((b.cantidad*b.precio_unitario)*0.12)),decimal(18,2)) as
 Total from orden_compra a join detalle_orden_compra b on a.id_orden_compra = b.id_orden_compra_dt
join producto_has_proveedor c on c.idproducto_has_proveedor = b.id_prod_has_prov
join productos d on d.idproducto = c.idproducto_has
where a.estado in ('pagado')";
$result=mysqli_query($conexion,$sql);
?>


<div>
	<table class="table table-hover table-condensed table-bordered" id="iddatatable">
		<thead style="background-color: #5DADE2 ;color: white; font-weight: bold;">
			<tr>
				<td>Fecha</td>
				<td>Descripcion</td>
				<td>Cantidad</td>
				<td>Precio Unit.</td>
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
					<td><?php echo $mostrar[2] ?></td>
					<td>$ <?php echo $mostrar[3] ?></td>
					<td>$ <?php echo $mostrar[4] ?></td>
                    <td>$ <?php echo $mostrar[5] ?></td>
                    <td>$ <?php echo $mostrar[6] ?></td>
					<?php  $totalFInal+=$mostrar[6] ?>
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
			<td colspan="6">Total Ingresos</td>
			<td>$ <?php echo $totalFInal ?></td>
			</tr>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#iddatatable').DataTable();
	} );
</script>