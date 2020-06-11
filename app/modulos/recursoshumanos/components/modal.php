<?php

function printModal($header, $idButton, $idModal ,$message){
     echo "<div class='modal fade' name=$idModal id=$idModal data-backdrop='static' data-keyboard='false' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabe' aria-hidden='true'>";
     echo "<div class='modal-dialog'>";
     echo"<div class='modal-content'>";
     echo"<div class='modal-header'>";
     echo"<h5 class='modal-title' id='staticBackdropLabel'>$header</h5>";
     echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
     echo"<span aria-hidden='true'>&times;</span>";
     echo"</button>";
     echo"</div>";
     echo"<div class='modal-body'>$message</div>";
     echo"<div class='modal-footer'>";
     echo"<button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>";
     echo"<button id='$idButton' type='button' class='btn btn-primary' data-dismiss='modal'>De acuerdo</button>";
     echo"</div>";
     echo"</div>";
     echo"</div>";
     echo"</div>";
};