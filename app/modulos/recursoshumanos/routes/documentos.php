<?php
require '../../../../database.php';
require '../components/modal.php';
session_start();
$id = $_SESSION['cedula'];    

$records = $conn->prepare("SELECT * FROM empleados AS e, documento_empleado AS d WHERE (e.id_empleados=d.id_empleados_doc) AND id_empleados_doc = :cedula AND activo = 1");
$records->bindParam(':cedula', $id);
$records->execute();
$results = $records->fetch(PDO::FETCH_ASSOC);


if(isset($_POST['guardar'])){
    

    // Subir documento
    $ruta = "../assets/static/contratos/".$results["id_empleados"]."/documentos/";

    $cadena = explode(' ',trim(utf8_decode($results['apellidos'])));

    $archivo = $ruta.strtolower( substr( $results['nombres'],0,1 ) ).strtolower($cadena[0])."documentos";

    if(!file_exists($ruta)){
        mkdir($ruta,0777,true);
    }
    
    if(!file_exists($archivo)){
        @move_uploaded_file($_FILES["fileDocument"]["tmp_name"],$archivo);
    }else{
        $cont=1;
        while(file_exists($archivo.$cont)){
            $cont++;
        }

        @move_uploaded_file($_FILES["fileDocument"]["tmp_name"],$archivo.$cont);
        $archivo=$archivo.$cont;
    }
    // termina subida de documento

    date_default_timezone_set('America/Guayaquil');
    $created = date("Y-m-d H:i:s");
    
    $sql = "UPDATE empleados AS e, documento_empleado AS d SET file_document=:file_document,descripcion=:descripcion,load_documento=:load_documento,updated_at=:updated_at WHERE (e.id_empleados=d.id_empleados_doc) AND id_empleados=:id_empleados AND activo = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_empleados', $id);
    $stmt->bindParam(':file_document', $archivo);
    $stmt->bindParam(':descripcion', $_POST['documentosDescription']);
    $stmt->bindValue(':load_documento', 1, PDO::PARAM_INT);
    $stmt->bindParam(':updated_at', $created);
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
    <h1>DOCUMENTOS DEL EMPLEADO</h1>
    <h4 style="text-align:center;" class="text-info">Documentos</h4>
        <?php
            if($results['load_documento'] == false):
        ?>
            <i class="fas fa-exclamation-triangle text-warning" style="text-align:center; font-size:15px;"></i>
            <div class="">
                <p style="font-size:15px;" class="text-break font-weight-bold badge-pill badge-warning">
                    El empleado ya fue registrado, y has eliminado sus documentos. Por favor, Vuelve a subir sus documentos actualizados.
                </p>
            </div>
            <form method="POST" action="documentos.php" class="ml-2 mr-2" enctype="multipart/form-data">
                <hr class="mt-1 mb-4">
                <label class="font-weight-bold mt-4">Describe una descripción de los documentos que estas subiendo.</label>
                <hr class="mt-1 mb-4">
                <div class="form-row">               
                    <div class="form-group col-md-6">
                    <div class="col-md-12 mb-3">
                        <label for="documentosDescription">Agrega una descripcion</label>
                      <textarea name="documentosDescription" class="form-control" id="lugar" rows="3" required></textarea>
                    </div>        
                  </div>  
                    <div class="form-group col-md-6 mt-2">
                        <div class="custom-file" style="margin-top:13px;">
                            <input name="fileDocument" id="fileDocument" type="file" class="form-control mt-2" onchange="return validarExtdoc(this);" accept="application/pdf" aria-describedby="inputGroupFileAddon01" required>
                        </div>
                        
                    </div>
                </div>
                <div class='modal-footer mt-2'>
                    <button id='guardar' name='guardar' type='submit' class='btn btn-primary font-weight-bold' style="width:200px;">Subir Documentos</button>
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
                <object data="<?php echo utf8_encode($results['file_document']);?>" type="application/pdf" width="800" height="780"> 
                    alt:<a href="<?php echo utf8_encode($results['file_document']);?>">contrato</a> 
                </object> 
            </div> 
            <hr class="mt-3 mb-4">   
            <form id="documentOtraPestaña" class="ml-2 mr-2">
                <div class="form-row">               
                    <div class="form-group col-md-12 d-flex justify-content-end">
                        <a class="text-info" href="../components/viewDocuments.php?contrato=<?php echo utf8_encode($results['file_document']);?>" target="_blank">
                            <i class="fas fa-external-link-square-alt mr-2"></i> 
                            Abrir el documento en otra pestaña
                        </a>
                    </div>
                </div>
                <div class="form-row mt-5">
                    <div class="form-group col-md-12 d-flex justify-content-center">
                        <a class="text-danger" data-toggle="modal" href="#finalizarContrato" >
                            Dar de baja este contrato, y generar un nuevo contrato.
                        </a>
                    </div>
                </div>
            </form>     
        <?php
            endif;
        ?>
         <h6 class="font-weight-bold mt-5"> Historial de Documentos subidos del empleado.</h6>
            <?php
                $documento = $conn->query("SELECT * FROM documento_empleado WHERE id_empleados_doc = ".$_SESSION['cedula']." AND activo = 0")->fetchAll(PDO::FETCH_OBJ);
                    foreach($documento as $Documentos):
            ?>
                <form id="documentOtraPestaña" class="ml-2 mr-2">
                <hr class="mt-1 mb-4">
                    <div class="form-row">               
                        <div class="form-group col-md-6 d-flex justify-content-center">
                            <span class="font-weight-bold">
                                Documentos Agregados </span>, <span class="font-weight-bold"> Finalizado:
                            </span> <?php echo $Documentos->updated_at?>
                        </div>
                        <div class="form-group col-md-6 d-flex justify-content-end">
                            <a class="" href="../components/viewDocuments.php?contrato=<?php echo utf8_encode($Documentos->file_document);?>" target="_blank">
                                <i class="fas fa-external-link-square-alt mr-2"></i> 
                                Abrir el documento en otra pestaña
                            </a>
                        </div>
                    </div>
                </form> 
            <?php
                endforeach;
            ?>
         <?php      
                printModal('Eliminar Documentos de Contrato, para subirlos nuevamente','finalizar','finalizarContrato','¡Hey!. Estas apunto de ELIMINAR información sensible. ¿Realmente desea ELIMINAR los DOCUMENTOS del contrato con este empleado?');
        ?>
<script src="../controllers/validation/validation.js"></script>   
<script type="text/javascript">
    $(document).ready(function(){  
        $("#openDocument").click(function () {
                $(this).toggleClass("down");
                $("#contratoView").toggle("showOrHide");
                $("#documentOtraPestaña").toggle("slow");
            });
        $("#finalizar").click(function () {
            location.href=`../controllers/nuevoDocumento.php`;
        });
    });
</script>
</body>
</html>