<?php
     $id=$_GET["id"];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin | Lockscreen</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="refresh" content="2;URL=../controllers/deleteLogic.php?id=<?php echo $id?>">
  <link rel="stylesheet" href="../assets/styles/component/loader.css">
</head>
   <body>
        <div class="lockscreen-logo">
            <a href="#"><b>Admin</b>Lockscreen</a>
        </div>
        <div class="lockscreen-name">Alex Suarez</div>
            <div class="help-block text-center">
                <div class="lds-grid">
                        <div></div> 
                        <div></div> 
                        <div></div> 
                        <div></div> 
                        <div></div> 
                        <div></div> 
                        <div></div> 
                        <div></div> 
                        <div></div> 
                </div>
            </div>
            <div class="help-block text-center">
                Realizaste la confirmación de este proceso que contiene información sensible. Lo estamos gestionando, espere un momento...
            </div>
            <div class="lockscreen-footer text-center">
                Copyright &copy; 2020-2021 <b><a href="#" class="text-black">R.R.H.H Security</a></b><br>
                Todos los derechos reservados
            </div>
   </body>
</html>
