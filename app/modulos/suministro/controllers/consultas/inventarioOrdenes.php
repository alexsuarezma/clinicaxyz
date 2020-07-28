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
        $query= "SELECT * FROM inventario_productos AS inv, orden_compra_inventario AS oci, orden_compra AS oc WHERE (inv.idinventario_productos=oci.id_inventario_oci AND oci.id_orden_compra_oci=oc.id_orden_compra) AND inv.idproducto_inventario=$q";

        $resultado = $conn->query($query);

        if ($resultado->num_rows>0) {
            // $resultado = $resultado->fetch_assoc();
            $salida.="
            <table class='table colored-header datatable project-list'>
            <thead>
                <tr>
                    <th># Orden de C.</th>
                    <th>Fecha de Pedido</th>
                    <th>Fecha Registro</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            ";
            while ($fila = $resultado->fetch_assoc()) {
                $salida.="
                        <tr>
                            <th>".$fila['id_orden_compra_oci']."</th>
                            <td>".$fila['fecha_pedido']."</td>
                            <td>".$fila['created_at']."</td>
                            <td><a href='ordenesCompra.php?id=".$fila['id_orden_compra_oci']."'>Registro</a></td>
                        </tr>
                    </tbody>
                </table>";
                
            }               
        }
    }else{
        $salida.="";
    }



echo $salida;
$conn->close();

