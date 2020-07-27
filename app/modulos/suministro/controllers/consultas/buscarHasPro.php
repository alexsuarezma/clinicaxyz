<?php
	$servername = "us-cdbr-east-05.cleardb.net";
    $username = "b7550b2dcd9c38";
  	$password = "a16e5057";
  	$dbname = "heroku_fe7e002859673b2";

	$conn = new mysqli($servername, $username, $password, $dbname);
      if($conn->connect_error){
        die("Conexión fallida: ".$conn->connect_error);
      }

    $salida = "";
        

    if (isset($_POST['consulta'])) {
        $q = $conn->real_escape_string($_POST['consulta']);
        $query= "SELECT * FROM producto_has_proveedor AS has, proveedores AS pv, productos AS pd WHERE (has.idproveedor_has=pv.idproveedor AND has.idproducto_has=pd.idproducto) AND idproducto_has_proveedor=$q AND has.deleted = 0";

        $resultado = $conn->query($query);

        if ($resultado->num_rows>0) {
             $resultado=$resultado->fetch_assoc();
            $salida.=" <hr class='mt-1 mb-4 mr-5'>
            <div class='form-row mb-3'>
                <div class='form-group col-md-6'>
                    <label class='text-info font-weight-bold' for='cantidad'>Elige la cantidad que requeriras de este Producto</label>
                    <input type='number' class='form-control' name='cantidad' id='cantidad' onkeypress='return soloNumeros(event)'>
                    <div class='invalid-feedback'>
                        Agrega almenos una unidad del producto.
                    </div>
                </div>
            </div>
            <img src='".$resultado['img_pr']."' id='imgProducto' alt='194x228' class='rounded mx-auto d-block'> 
            <hr class='mt-1 mb-4 mr-5'>
            <div class='form-row'>
                <div class='form-group col-md-6'>
                    <label for='codigoBarra'>Código de barra</label>
                    <input type='text' class='form-control' value='".$resultado['codigo_barra_pr']."' name='codigoBarra' id='codigoBarra' onkeypress='return soloNumeros(event)' readonly>
                </div>
                <div class='form-group col-md-6'>
                    <label for='nombreProducto'>Nombre del producto</label>
                    <input type='text' class='form-control' value='".$resultado['nombre_pr']."' name='nombreProducto' id='nombreProducto' readonly>
                </div>
            </div>
            <div class='form-row'>
                <div class='form-group col-md-4'>
                    <label for='fechaElaboracion'>Fecha de Elaboracion</label>
                    <input type='date' class='form-control' value='".$resultado['fecha_elaboracion_pr']."' name='fechaElaboracion' id='fechaElaboracion' readonly>
                </div>
                <div class='form-group col-md-4'>
                    <label for='fechaCaducidad'>Fecha de Caducidad</label>
                    <input type='date' class='form-control' value='".$resultado['fecha_caducidad_pr']."' name='fechaCaducidad' id='fechaCaducidad' readonly>
                </div>
                <div class='form-group col-md-4'>
                    <label for='precio'>Precio</label>
                    <input type='text' class='form-control' value='".$resultado['precio_unitario_pr']."' name='precio' id='precio' readonly>
                </div>
            </div>
            <label class='font-weight-bold'>Información del producto</label>
            <hr class='mt-1 mb-4 mr-5'>
            <div class='form-row'>
                <div class='col-md-6 mb3'>
                    <label for='descripcion'>Descripcion del producto</label>
                    <input type='text' class='form-control' value='".$resultado['descripcion_pr']."' name='descripcion' id='descripcion' readonly>
                </div>
                <div class='col-md-6 mb3'>
                    <label for='categoria'>Categoria</label>
                    <input type='text' class='form-control' value='".$resultado['idcategoria_pr']."' name='categoria' id='categoria' readonly>
                </div>
            </div> ";

        }

    }else{
        $salida.="";
    }



echo $salida;
$conn->close();

