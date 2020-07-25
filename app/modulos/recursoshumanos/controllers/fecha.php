<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <div class='modal fade' name='elegirFechaContrato' id='elegirFechaContrato' data-backdrop='static' data-keyboard='false' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabe' aria-hidden='true'>
        <div class='modal-dialog' style="max-width:800px;">
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='staticBackdropLabel'>Contrato</h5>
                    </button>
                </div>
                <div class='modal-body'>
                    <form action="https://clinicavitaliacontratos.herokuapp.com/viewPdf.php" class="ml-2 mr-2">
                        <label class="font-weight-bold">Selección de fechas</label>
                        <input type="hidden" name="type" value="<?php echo $_GET['type']?>">
                        <input type="hidden" name="id" value="<?php echo $_SESSION['cedula']?>">
                        <hr class="mt-1 mb-4 mr-5">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="desde">Escoge la fecha de inicio del contrato</label>
                                <input type="date" class="form-control" name="desde" id="desde" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="hasta">Escoge la fecha de finalización del contrato</label>
                                <input type="date" class="form-control" name="hasta" id="hasta" required>
                            </div>
                        </div>
                        <div class='modal-footer mt-2'>
                            <button id="cancelar" type='button' class="btn btn-light border-secondary" data-dismiss='modal'>Cancelar</button>
                            <button id='confirmacion' name='confirmacion' type='submit' class='btn btn-primary font-weight-bold' style="width:200px;">Continuar</button>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>
<script src="../components/scripts/jquery.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script>
    $('#elegirFechaContrato').modal('show');
    $('#cancelar').click(function(){
        window.close();
    });  
</script>
</body>
</html>