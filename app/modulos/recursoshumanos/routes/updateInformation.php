<?php
    require '../../../../database.php';
    session_start();
    $id = $_SESSION['cedula'];
    
        if(!isset($_POST["btn-actualizar"])){
            $records = $conn->prepare("SELECT * FROM empleados WHERE cedula = :cedula");
            $records->bindParam(':cedula', $id);
            $records->execute();
            $results = $records->fetch(PDO::FETCH_ASSOC);
       }else{   
                // ARREGLAR LA HORA DE MODIFICACION
                $updated = date('d')."/".date('m')."/".date('Y')." ".date("H").":".date("i").":".date("s");
                $sql = "UPDATE empleados SET nombres=:nombres, apellidos=:apellidos, telefono=:telefono, email=:email, direccion=:direccion, nacionalidad=:nacionalidad, ciudad=:ciudad, estadoCivil=:estadoCivil, idhorario=:idhorario, salarioBase=:salarioBase, personal=:personal, updated_at=:updated_at WHERE cedula=:cedula";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':cedula', $_POST['cedula']);
                $stmt->bindParam(':nombres',$_POST['nombres']);
                $stmt->bindParam(':apellidos',$_POST['apellidos']);
                $stmt->bindParam(':telefono',$_POST['telefono']);
                $stmt->bindParam(':email',$_POST['email']);
                $stmt->bindParam(':direccion',$_POST['direccion']);
                $stmt->bindParam(':nacionalidad',$_POST['nacionalidad']);
                $stmt->bindParam(':ciudad',$_POST['ciudad']); 
                $stmt->bindParam(':estadoCivil',$_POST['estadoCivil']);
                $stmt->bindParam(':idhorario',$_POST['horario']);
                $stmt->bindParam(':salarioBase',$_POST['salarioBase']);
                $stmt->bindParam(':personal',$_POST['personal']);
                $stmt->bindParam(':updated_at', $updated);
            try{
                if($stmt->execute()){
                    header("Location:profile.php?id=$id");                          
                }
            } catch (PDOException $e) {
                die('Problema: ' . $e->getMessage());
            }
                
       }

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
    <form action="updateInformation.php" method="POST" class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-confirm-pass">Cedula</label>
            <input class="form-control" type="text" name="cedula" id="account-confirm-pass" value=<?php echo $results["cedula"] ?> readonly>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-fn">First Name</label>
            <input class="form-control" type="text" name="nombres" id="account-fn" value="<?php echo $results["nombres"] ?>">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-ln">Last Name</label>
            <input class="form-control" type="text" name="apellidos" id="account-ln" value="<?php echo $results["apellidos"] ?>">
        </div>
    </div> 
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-pass">Sexo</label>
            <input class="form-control" type="text" name="sexo" id="account-pass" value="<?php echo $results["sexo"] ?>" readonly>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-phone">Phone Number</label>
            <input class="form-control" type="text" name="telefono" id="account-phone" value="<?php echo $results["telefono"] ?>">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-email">E-mail Address</label>
            <input class="form-control" type="email" name="email" id="account-email" value="<?php echo $results["email"] ?>">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-confirm-pass">Dirección</label>
            <input class="form-control" type="text" name="direccion" id="account-confirm-pass" value="<?php echo $results["direccion"] ?>">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-confirm-pass">Nacionalidad</label>
            <input class="form-control" type="text" name="nacionalidad" id="account-confirm-pass" value="<?php echo $results["nacionalidad"] ?>" readonly>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-confirm-pass">Ciudad</label>
            <input class="form-control" type="text" name="ciudad" id="account-confirm-pass" value="<?php echo $results["ciudad"] ?>">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-confirm-pass">Fecha de nacimiento</label>
            <input class="form-control" type="text" name="fechaNacimiento" id="account-confirm-pass" value="<?php echo $results["fechaNacimiento"] ?>" readonly>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-confirm-pass">Estado Civil</label>
            <input class="form-control" type="text" name="estadoCivil" id="account-confirm-pass" value="<?php echo $results["estadoCivil"] ?>">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-confirm-pass">Horario</label>
            <input class="form-control" type="text" name="horario" id="account-confirm-pass" value="<?php echo $results["idhorario"] ?>">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-confirm-pass">N° de contrato</label>
            <input class="form-control" type="text" name="contrato" id="account-confirm-pass" value="<?php echo $results["idcontrato"] ?>" readonly>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-confirm-pass">Salario Base</label>
            <input class="form-control" type="text" name="salarioBase" id="account-confirm-pass" value="<?php echo $results["salarioBase"] ?>">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-confirm-pass">Personal</label>
            <input class="form-control" type="text" name="personal" id="account-confirm-pass" value="<?php echo $results["personal"] ?>">
        </div>
    </div>    
            <div class="col-12">
                <hr class="mt-2 mb-3">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <div class="custom-control custom-checkbox d-block"></div>
                    <button class="btn btn-style-1 btn-primary" type="submit" name="btn-actualizar" id="btn-actualizar">Guardar</button>
                </div>
            </div>
    </form>
</body>
</html>