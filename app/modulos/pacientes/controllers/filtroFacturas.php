<?php
require_once('../../../../database.php');

    $salida = "";
	$pago = $conn->query("SELECT *, pa.nombres as paciennombres FROM pacientes AS pa, pagos AS ps, citas AS ci, citas_medicos AS cm, empleados_medico AS em, empleados AS emp, especialidades AS esp WHERE (ci.paciente=pa.idpacientes AND ci.idcitas=ps.id_cita AND ci.idcitas=cm.cita AND cm.medico=em.id_medico AND em.id_especialidad_medico=esp.idespecialidades AND em.id_empleados_medico=emp.id_empleados) ORDER BY fecha DESC LIMIT 15")->fetchAll(PDO::FETCH_OBJ);
    
    if (isset($_POST['consulta'])) {
		$q = $_POST['consulta'];
		$pago= $conn->query("SELECT * FROM pacientes AS pa, pagos AS ps, citas AS ci, citas_medicos AS cm, empleados_medico AS em, empleados AS emp, especialidades AS esp WHERE (ci.paciente=pa.idpacientes AND ci.idcitas=ps.id_cita AND ci.idcitas=cm.cita AND cm.medico=em.id_medico AND em.id_especialidad_medico=esp.idespecialidades AND em.id_empleados_medico=emp.id_empleados) AND (estado LIKE '%$q%' OR id_empleados LIKE '%$q%' OR idpacientes LIKE '%$q%' OR fecha LIKE '%$q%' OR ape_paterno LIKE '%$q%' OR apellidos LIKE '%$q%' OR ape_mat LIKE '$q') ORDER BY fecha DESC LIMIT 15")->fetchAll(PDO::FETCH_OBJ);	
    }

    if ($pago) {
        foreach($pago as $Pagos):
        $salida.=" <tr>
            <th style='width:400px;'>Cedula Paciente: <span class='font-weight-normal'>".$Pagos->idpacientes."</span> <br>Paciente: <span class='font-weight-normal'>".$Pagos->ape_paterno." ".$Pagos->ape_mat."</span> <br> Medico: #<span class='font-weight-normal'>".$Pagos->id_empleados." ".$Pagos->nombres." ".$Pagos->apellidos."</span><br> Cita Agendada del Servicio de: <span class='font-weight-normal'>".utf8_encode($Pagos->descripcion)."</span><br>
            Hora:<span class='font-weight-normal'>".$Pagos->id_hora."</span>
            </th>
            <td style='width:100px;'>".$Pagos->fecha."</td>
            <td>".($Pagos->sub_total + ($Pagos->sub_total * 0.12))." US$ order #".$Pagos->id_order."</td>
            <td>Tarjeta de Credito</td>
            <td>".$Pagos->estado."</td>
            <td style='width:100px;'><a class='btn btn-outline-info' style='font-size:12px;' href='../../citasmedicas/historial_clinico.php?id_paciente=".$Pagos->idpacientes."&id_citas=".$Pagos->idcitas."'>Ver cita</a></td>
            </tr>";
        endforeach;
    }else{
        $salida.="NO HAY DATOS ASOCIADOS A LA BUSQUEDA";
    }


    echo $salida;

    $conn=null;


