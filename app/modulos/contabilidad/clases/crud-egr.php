<?php 

	class crud{
		public function agregar($datos){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="INSERT into egresos (fech_eg,det_eg,sub_eg,iva_eg,total_eg)
									values ('$datos[0]',
											'$datos[1]',
											'$datos[2]',
											'$datos[3]',
											'$datos[4]')";
			return mysqli_query($conexion,$sql);
		}

		public function obtenDatos($idcta){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="SELECT id_eg,
							fech_eg,
							det_eg,
							sub_eg,
							iva_eg,
							total_eg
					from egresos
					where id_eg='$ideg'";
			$result=mysqli_query($conexion,$sql);
			$ver=mysqli_fetch_row($result);

			$datos=array(
				'id_eg' => $ver[0],
				'fech_eg' => $ver[1],
				'det_eg' => $ver[2],
				'sub_eg' => $ver[3],
				'iva_eg' => $ver[4],
				'total_eg' => $ver[5]
				);
			return $datos;
		}

		public function actualizar($datos){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="UPDATE egresos set cod_cta='$datos[0]',
										nom_cta='$datos[1]',
										tipo_cta='$datos[2]',
										ing_cta='$datos[3]',
										egre_cta='$datos[4]'
						where id_cta ='$datos[5]'";
			return mysqli_query($conexion,$sql);
		}
		public function eliminar($idcta){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="DELETE from cuentas where id_cta='$idcta'";
			return mysqli_query($conexion,$sql);
		}




	}

 ?>