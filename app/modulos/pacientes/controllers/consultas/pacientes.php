<?php
require_once('../../../../../database.php');

$cedula = $_GET['q'];

$paciente = $conn->query("SELECT * FROM pacientes WHERE idpacientes LIKE '%$cedula%' ORDER BY idpacientes ASC")->fetchAll(PDO::FETCH_OBJ);

$data = array();

    foreach($paciente as $Pacientes){
        $data[] = $Pacientes->idpacientes." | Paciente: ".$Pacientes->nombres;
    }

echo json_encode($data);
$conn = null;