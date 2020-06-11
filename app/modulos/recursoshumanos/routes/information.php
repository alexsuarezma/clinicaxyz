<?php
    require '../../../../database.php';
    session_start();
    $id = $_SESSION['cedula'];    
            $records = $conn->prepare("SELECT * FROM empleados WHERE cedula = :cedula");
            $records->bindParam(':cedula', $id);
            $records->execute();
            $results = $records->fetch(PDO::FETCH_ASSOC);
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- fromulario de actualización -->
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-confirm-pass">Cedula</label>
            <input class="form-control" type="text" id="account-confirm-pass" value="<?php echo $results["cedula"] ?>" disabled="">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-fn">First Name</label>
            <input class="form-control" type="text" id="account-fn" value="<?php echo $results["nombres"] ?>" disabled="">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-ln">Last Name</label>
            <input class="form-control" type="text" id="account-ln" value="<?php echo $results["apellidos"] ?>" disabled="">
        </div>
    </div> 
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-pass">Sexo</label>
            <input class="form-control" type="text" id="account-pass" value="<?php echo $results["sexo"] ?>" disabled="">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-phone">Phone Number</label>
            <input class="form-control" type="text" id="account-phone" value="<?php echo $results["telefono"] ?>" disabled="">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-email">E-mail Address</label>
            <input class="form-control" type="email" id="account-email" value="<?php echo $results["email"] ?>" disabled="">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-confirm-pass">Dirección</label>
            <input class="form-control" type="text" id="account-confirm-pass" value="<?php echo $results["direccion"] ?>" disabled="">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-confirm-pass">Nacionalidad</label>
            <input class="form-control" type="text" id="account-confirm-pass" value="<?php echo $results["nacionalidad"] ?>" disabled="">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-confirm-pass">Ciudad</label>
            <input class="form-control" type="text" id="account-confirm-pass" value="<?php echo $results["ciudad"] ?>" disabled="">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-confirm-pass">Fecha de nacimiento</label>
            <input class="form-control" type="text" id="account-confirm-pass" value="<?php echo $results["fechaNacimiento"] ?>" disabled="">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-confirm-pass">Estado Civil</label>
            <input class="form-control" type="text" id="account-confirm-pass" value="<?php echo $results["estadoCivil"] ?>" disabled="">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-confirm-pass">Horario</label>
            <input class="form-control" type="text" id="account-confirm-pass" value="<?php echo $results["idhorario"] ?>" disabled="">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-confirm-pass">N° de contrato</label>
            <input class="form-control" type="text" id="account-confirm-pass" value="<?php echo $results["idcontrato"] ?>" disabled="">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-confirm-pass">Salario Base</label>
            <input class="form-control" type="text" id="account-confirm-pass" value="<?php echo $results["salarioBase"] ?>" disabled="">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-confirm-pass">Personal</label>
            <input class="form-control" type="text" id="account-confirm-pass" value="<?php echo $results["personal"] ?>" disabled="">
        </div>
    </div>    
    <hr class="mt-2 mb-3">
</div>   
</body>
</html>