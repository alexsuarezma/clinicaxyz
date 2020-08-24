<?php
require_once('../../../../../database.php');

$salida="";

    if (isset($_POST['consulta'])) {
        $paciente = $_POST['consulta'];
        $resultado = $conn->query("SELECT * FROM pacientes WHERE idpacientes='$paciente'")->fetchAll(PDO::FETCH_OBJ);

        $salida.="<label for='nombres'>Nombres</label>
        <input type='hidden' name='cedula' value='".$resultado[0]->idpacientes."'>
        <input type='text' class='form-control' value='".$resultado[0]->nombres." ".$resultado[0]->ape_paterno." ".$resultado[0]->ape_mat."' readonly required>";

    }

echo $salida;
$conn=null;
