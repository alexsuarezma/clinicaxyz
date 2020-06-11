<?php
     require '../../../../database.php';
     $id=$_GET["id"];
     $pass = "123";
     if(isset($_POST["btn-listo"])){
          //Buscar credenciales del usuario logeado en $_SESSION['id'];    
          // $records = $conn->prepare("SELECT pass FROM users WHERE id = :id");
          // $records->bindParam(':id', $id);
          // $records->execute();
          // $results = $records->fetch(PDO::FETCH_ASSOC);
               // if($_POST["password"] != $pass){
               //      //no es correcta la pass  
               // }else{
               //      header("Location:../controllers/deleteLogic.php?id=$id");  
               // }
     }

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin | Lockscreen</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../assets/styles/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="../assets/styles/adminlte.min.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
   <body class="hold-transition lockscreen">

     <div id="lockScreen" class="lockscreen-wrapper">
          <div class="lockscreen-logo">
               <a href=""><b>Admin</b>Lockscreen</a>
          </div>

          <div class="lockscreen-name">Ammy Suarez</div>
          <h5 id="ocultCedula"style="display: none"><?php echo $id ?></h5>
          <h5 id="ocultPass"style="display: none"><?php echo $pass ?></h5>
               <div class="lockscreen-item">
                    <div class="lockscreen-image">
                         <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="User Image">
                    </div>
                    <!--BORAR LA ACTION DEL FORM EN PRODUCCION-->
                    <form class="lockscreen-credentials" method="POST">
                         <div class="input-group">
                              <input type="password" name="password" id="password" class="form-control" placeholder="password" required>
                              <div class="input-group-append">
                                   <button type="button" name="btn-listo" id="btn-listo" class="btn"><i class="fas fa-arrow-right text-muted"></i></button>
                              </div>
                         </div>
                    </form>
          
               </div>    
               <div class="help-block text-center">
                    Estas apunto de realizar un proceso con información sensible, Porfavor ingresa tu contaseña para confirmar la realizacion de este proceso.
               </div>
               <div class="text-center">
                    <a href="../index.php">O vuelve al inicio</a>
               </div>
               <div class="lockscreen-footer text-center">
                    Copyright &copy; 2020-2021 <b><a href="#" class="text-black">R.R.H.H Security</a></b><br>
                    Todos los derechos reservados
               </div>
     </div>

     <link rel="stylesheet" href="../assets/styles/jquery.min.js"></script>
     <link rel="stylesheet" href="../assets/styles/bootstrap.bundle.min.js"></script>
     <script type="text/javascript" src="https://code.jquery.com/jquery.js"></script>

     <script>
          $(document).ready(function(){
               $('#btn-listo').click(function(){
                    if($('#password').val()==$('#ocultPass').text()){
                         $("#lockScreen").load(`../components/loader.php?id=${$('#ocultCedula').text()}`);
                    }else{
                         alert("contraseñas no coinciden")
                    }
                    
                });
          });

     </script>
   </body>
</html>
