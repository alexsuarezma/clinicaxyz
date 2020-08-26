<?php
    require_once('../../../../../database.php');
    $salida="";
    
    if (isset($_POST['consulta'])) {
        $provincia = $_POST['consulta'];
        $ciudades = $conn->query("SELECT * FROM ciudades WHERE provincia='$provincia' ORDER BY nombre ASC")->fetchAll(PDO::FETCH_OBJ);
        $salida.=" <label for='ciudad'>Ciudad</label>
        <select id='ciudad' name='ciudad' class='form-control' required>
          <option selected disabled value=''>Seleccione...</option>";          
            foreach ($ciudades as $ciudadesPaciente):
              $salida.="<option value='$ciudadesPaciente->idciudades'>".utf8_encode($ciudadesPaciente->nombre)."</option>";      
            endforeach;
          $salida.="</select>";

    }

echo $salida;
$conn=null;
