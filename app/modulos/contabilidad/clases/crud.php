<?php 

	class crud{
		public function agregar($datos){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="INSERT into cuentas (cod_cta,nom_cta,tipo_cta,ing_cta,egre_cta)
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

			$sql="SELECT id_cta,
							cod_cta,
							nom_cta,
							tipo_cta,
							ing_cta,
							egre_cta
					from cuentas
					where id_cta='$idcta'";
			$result=mysqli_query($conexion,$sql);
			$ver=mysqli_fetch_row($result);

			$datos=array(
				'id_cta' => $ver[0],
				'cod_cta' => $ver[1],
				'nom_cta' => $ver[2],
				'tipo_cta' => $ver[3],
				'ing_cta' => $ver[4],
				'egre_cta' => $ver[5]
				);
			return $datos;
		}

		public function actualizar($datos){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="UPDATE cuentas set cod_cta='$datos[0]',
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