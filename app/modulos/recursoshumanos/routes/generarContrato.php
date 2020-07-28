<?php
require '../../../../database.php';
session_start();
$id = $_SESSION['cedula'];    
            $records = $conn->prepare("SELECT * FROM empleados WHERE id_empleados = :cedula");
            $records->bindParam(':cedula', $id);
            $records->execute();
            $results = $records->fetch(PDO::FETCH_ASSOC);
            if(isset($_POST['guardar'])){
                //fileContrato
                $ruta = "../assets/static/contratos/";
                $archivo = $ruta.$_FILES["fileContrato"]["name"];
                if(!file_exists($ruta)){
                    mkdir($ruta);
                }

                if(!file_exists($archivo)){
                    $resultado = @move_uploaded_file($_FILES["fileContrato"]["tmp_name"],$archivo);
                    if($resultado){//seguardo
                    }else{//nose guardo
                    }
                }else{echo "ya existe";}

                $sql = "UPDATE empleados SET file_contrato=:file_contrato,tipo_contrato=:tipo_contrato,load_contrato=:load_contrato WHERE id_empleados=:id_empleados";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id_empleados', $id);
                $stmt->bindParam(':file_contrato', $archivo);
                $stmt->bindParam(':tipo_contrato', $_POST['tipoContrato']);
                $stmt->bindValue(':load_contrato', 1, PDO::PARAM_INT);
                $stmt->execute();
                header("Location:profile.php?id=$id");
            }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    #openDocument{
        -moz-transition: all 0.5s linear;
        -webkit-transition: all 0.5s linear;
        transition: all 0.5s linear;
    }

    #openDocument.down{
        margin-right:20px;
        margin-bottom:20px;
        -ms-transform: rotate(180deg);
        -moz-transform: rotate(180deg);
        -webkit-transform: rotate(180deg);
        transform: rotate(180deg);
    }
    </style>
</head>
<body>
    <h1>CONTRATO</h1>
    <h4 style="text-align:center;" class="text-info">Contrato De Trabajo <?php echo $results['tipo_contrato'];?></h4>
        <?php
            if($results['load_contrato'] == false):
        ?>
            <i class="fas fa-exclamation-triangle text-warning" style="text-align:center; font-size:15px;"></i>
            <div class="">
                <p style="font-size:15px;" class="text-break font-weight-bold badge-pill badge-warning">
                    El empleado ya fue registrado, termina el proceso descargando el formato del contrato 
                    subiendolo firmado por el empleador y el empleado contratado.
                </p>
            </div>
            <form class="ml-2 mr-2">
                <hr class="mt-1 mb-4">
                <div class="form-row">               
                    <div class="form-group col-md-12">
                        <a class="text-info" href="https://clinicavitaliacontratos.herokuapp.com/viewPdf.php?type=1&desde=&hasta=&id=<?php echo $_SESSION['cedula']?>" target="_blank">
                        <i class="fas fa-external-link-square-alt mr-2"></i> 
                        Rellenar formato con datos del empleado (Contrato De Trabajo Indefinido)</a>
                    </div>
                </div>
                <div class="form-row">               
                    <div class="form-group col-md-12">
                        <a class="text-info" href="https://clinicavitaliacontratos.herokuapp.com/viewPdf.php?type=2&desde=&hasta=&id=<?php echo $_SESSION['cedula']?>" target="_blank">
                        <i class="fas fa-external-link-square-alt mr-2"></i> 
                        Rellenar formato con datos del empleado (Contrato De Trabajo Indefinido Bonificado)</a>
                    </div>
                </div>
                <div class="form-row">               
                    <div class="form-group col-md-12">
                        <a class="text-info" href="https://clinicavitaliacontratos.herokuapp.com/viewPdf.php?type=3&desde=&hasta=&id=<?php echo $_SESSION['cedula']?>" target="_blank">
                        <i class="fas fa-external-link-square-alt mr-2"></i> 
                        Rellenar formato con datos del empleado (Contrato De Trabajo Indefinido Personas Con Discapacidad)</a>
                    </div>
                </div>
                <div class="form-row">               
                    <div class="form-group col-md-12">
                        <a class="text-info" href="../controllers/fecha.php?type=4" target="_blank">
                        <i class="fas fa-external-link-square-alt mr-2"></i> 
                        Rellenar formato con datos del empleado (Contrato De Trabajo Temporal)</a>
                    </div>
                </div>
                <div class="form-row">               
                    <div class="form-group col-md-12">
                        <a class="text-info" href="../controllers/fecha.php?type=5" target="_blank">
                        <i class="fas fa-external-link-square-alt mr-2"></i> 
                        Rellenar formato con datos del empleado (Contrato De Trabajo Temporal Personas Con Discapacitada)</a>
                    </div>
                </div>
                <div class="form-row">               
                    <div class="form-group col-md-12">
                        <a class="text-info" href="../controllers/fecha.php?type=6" target="_blank">
                        <i class="fas fa-external-link-square-alt mr-2"></i> 
                        Rellenar formato con datos del empleado (Contrato De Trabajo En Prácticas)</a>
                    </div>
                </div>
            </form>
            <form method="POST" action="generarContrato.php" class="ml-2 mr-2" enctype="multipart/form-data">
                <hr class="mt-1 mb-4">
                <label class="font-weight-bold mt-4">Elige el tipo de contrato que subiras </label>
                <hr class="mt-1 mb-4">
                <div class="form-row">               
                    <div class="form-group col-md-6">
                        <label for="tipoContrato">Tipo de contrato</label>
                        <select id="tipoContrato" name="tipoContrato" class="form-control" required>
                            <option selected value="<?php echo $results['tipo_contrato'];?>"><?php echo $results['tipo_contrato'];?></option>
                            <option disabled value="">Seleccione...</option>
                            <option value="Indefinido">Contrato De Trabajo Indefinido</option>
                            <option value="Indefinido Bonificado">Contrato De Trabajo Indefinido Bonificado</option>
                            <option value="Indefinido Discapacidad">Contrato De Trabajo Indefinido Personas Con Discapacidad</option>
                            <option value="Temporal">Contrato De Trabajo Temporal</option>
                            <option value="Temporal Discapacidad">Contrato De Trabajo Temporal Personas Con Discapacitada</option>
                            <option value="Practicas">Contrato De Trabajo En Prácticas</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6 mt-2">
                        <div class="custom-file" style="margin-top:13px;">
                            <input name="fileContrato" id="fileContrato" type="file" class="form-control mt-2" onchange="return validarExtdoc(this);" accept="application/pdf" aria-describedby="inputGroupFileAddon01" required>
                        </div>
                    </div>
                </div>
                <div class='modal-footer mt-2'>
                    <button id='guardar' name='guardar' type='submit' class='btn btn-primary font-weight-bold' style="width:200px;">Subir Contrato</button>
                </div> 
            </form>
            
        <?php
            else:
        ?>
            <hr class="mt-1 mb-4">        
            <form class="ml-2 mr-2">
                <div class="form-row">               
                    <div class="form-group col-md-11 d-flex justify-content-end">
                        <p class="text-secondary font-weight-bold"> Visualizar el documento aqui</p>
                    </div>
                    <div class="form-group col-md-1 d-flex justify-content-end">
                        <a class="text-secondary" id="openDocument" href="#viewdocument">
                        <i class="fas fa-chevron-down mt-1 mr-3" style="font-size:18px;"></i> 
                        </a>
                    </div>
                </div>
            </form>
            <hr class="">        
            <div id="contratoView" style="display:none;"> 
                <object data="<?php echo $results['file_contrato'];?>" type="application/pdf" width="800" height="780"> 
                    alt:<a href="<?php echo $results['file_contrato'];?>">contrato</a> 
                </object> 
            </div> 
            <hr class="mt-3 mb-4">   
            <form id="documentOtraPestaña" class="ml-2 mr-2">
                <div class="form-row">               
                    <div class="form-group col-md-12 d-flex justify-content-end">
                        <a class="text-info" href="../components/viewDocuments.php?contrato=<?php echo $results['file_contrato'];?>" target="_blank">
                            <i class="fas fa-external-link-square-alt mr-2"></i> 
                            Abrir el documento en otra pestaña
                        </a>
                    </div>
                </div>
            </form>     
        <?php
            endif;
        ?>
<script type="text/javascript">
    $(document).ready(function(){  
        $("#openDocument").click(function () {
                $(this).toggleClass("down");
                $("#contratoView").toggle("showOrHide");
                $("#documentOtraPestaña").toggle("slow");
            });
    });
</script>
</body>
</html>