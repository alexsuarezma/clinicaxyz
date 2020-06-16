<?php
  $contrato=$_GET["contrato"];
  header('content-type: application/pdf');
  readfile($contrato);
?>