<?php
session_start();
     require '../../../../database.php';
     $message='';
     $response = '';
     $photo = $conn->query("SELECT * FROM empleados WHERE id_usuario_emp=".$_SESSION['user_id'])->fetchAll(PDO::FETCH_OBJ);
     if(isset($_POST["password"])){
          //Buscar credenciales del usuario logeado en;    
          $records = $conn->prepare("SELECT * FROM usuario WHERE id_usuario=:id_usuario");
          $records->bindParam(':id_usuario', $_SESSION['user_id']);
          $records->execute();
          $results = $records->fetch(PDO::FETCH_ASSOC);
               if(password_verify($_POST['password'],$results['password'])){
                    $message='';
                    $response = 'yes';
                    if($_POST['type']== 1){
                         header("Refresh: 2; URL=../controllers/nuevoContrato.php");
                    }elseif($_POST['type']== 2){
                         header("Refresh: 2; URL=../controllers/deleteLogic.php");
                    }
               }else{
                    $message='Credencial invalida';
                    
               }
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
  <link rel="stylesheet" href="../assets/styles/component/loader.css">
</head>
   <body class="hold-transition lockscreen">

     <div id="lockScreen" class="lockscreen-wrapper">
          <div class="lockscreen-logo">
               <a href=""><b><?php echo $_SESSION['nombre_credencial'];?></b> | Lockscreen</a>
          </div>

          <div class="lockscreen-name"><?php echo $_SESSION['username'];?></div>
               <div class="lockscreen-name text-danger"><?php echo $message;?></div>
               <div clas="mt-1" id="load" style="display:none;">
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
               </div>
               <div id="out-load">
                    <div id="lock" class="lockscreen-item">
                         <div class="lockscreen-image">
                              <img src="<?php echo $photo[0]->profileimage?>" alt="User Image">
                         </div>
                         <!--BORAR LA ACTION DEL FORM EN PRODUCCION-->
                         <form class="lockscreen-credentials" action="lockScreen.php" method="POST">
                              <div class="input-group">
                                   <input type="hidden" name="callback" id="callback" value="<?php echo $response;?>">
                                   <input type="hidden" name="type" value="<?php 
                                        if(isset($_POST['password'])):
                                             echo $_POST['type'];
                                        else:
                                             echo $_GET['type'];
                                        endif;
                                   
                                        ?>">
                                   <input type="password" name="password" id="password" class="form-control" placeholder="password" required autofocus>
                                   <div class="input-group-append">
                                        <button type="submit" name="btn-listo" id="btn-listo" class="btn"><i class="fas fa-arrow-right text-muted"></i></button>
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
               if($('#callback').val()=='yes'){
                    document.getElementById('load').style.display='block';    
                    document.getElementById('out-load').style.display='none';    
      
               }
          });

     </script>
   </body>
</html>

