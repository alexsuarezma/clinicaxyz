<?php 
require 'php/conexion.php'; 
$id = $_GET['id'];
    $sql= "SELECT * FROM proveedores WHERE idproveedor = $id";	
    $producto = $conexion->query($sql);
    $producto = $producto->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>SUMINISTRO CENTRO MEDICO</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="copyright" content="Todos los derechos reservados DEPARTAMENTO SUMINISTRO">
  <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <meta name="description" content="Suministro del Departamento Farmaceutico">
  <link rel="icon" type=".ico" href="ico/farma.ico">
  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/script.js"></script>
  <script src="js/main.js"></script>
  <link rel="stylesheet" href="css/sumies.css">
</head>
<body>
  <div class="container">
    <div class="content_nav">
      <ul>
        <li class="provider td"><span><i class="fas fa-dolly"></i></span><a href="#" class="provee">Actualizar Proveedor</a>
          <ul>
            <li class="register_provee">
              <form action="php/updateProveedor.php" method="POST">
              <input style="display:none;" type="text" name="idproveedor" value="<?php echo $producto['idproveedor'];?>">
                <span>N° Identifiacion</span>
                <input type="text" name="numero_identificacion_pro" id="ruc" maxlength="13" onKeyPress="return soloNumeros(event)" value="<?php echo $producto['numero_identificacion_pro'];?>">
                <input type = "button" value = "Validar RUC" onclick="validar()">
                <span>Razon Social</span>
                <input type="text" name="razon_social_empresa_pro" id="" maxlength="30" value="<?php echo $producto['razon_social_empresa_pro'];?>">
                <span>Nombre Representante Legal</span>
                <input type="text" name="nombre_representante_legal_pro" id="" maxlength="30" value="<?php echo $producto['nombre_representante_legal_pro'];?>">
                <span>Ciudad</span>
                <select name="ciudad" id="" maxlength="60">
                <option selected="true" ><?php echo utf8_encode($producto['ciudad_pro'])?></option>
                <option disabled value="">Seleccione...</option>
                  <option>Azuay, Cuenca</option>
                  <option>Bolívar, Guaranda</option>
                  <option>Cañar, Azogues</option>
                  <option>Carchi, Tulcán</option>
                  <option>Chimborazo, Riobamba</option>
                  <option>Cotopaxi, Latacunga</option>
                  <option>El Oro, Machala</option>
                  <option>Esmeraldas, Esmeraldas</option>
                  <option>Galápagos, Puerto Baquerizo Moreno</option>
                  <option>Guayas, Guayaquil</option>
                  <option>Imbabura, Ibarra</option>
                  <option>Loja, Loja</option>
                  <option>Los Ríos, Babahoyo</option>
                  <option>Manabí, Portoviejo</option>
                  <option>Morona Santiago, Macas</option>
                  <option>Napo, Tena</option>
                  <option>Orellana, Francisco de Orellana</option>
                  <option>Pastaza, Puyo</option>
                  <option>Pichincha, Quito</option>
                  <option>Santa Elena, Santa Elena</option>
                  <option>Santo Domingo de los Tsáchilas, Santo Domingo</option>
                  <option>Sucumbíos, Nueva Loja</option>
                  <option>Tungurahua, Ambato</option>
                  <option>Zamora Chinchipe, Zamora</option>
                </select>
                <span>Direccion</span>
                <input type="text" name="direccion_pro" id="" maxlength="60" value="<?php echo $producto['direccion_pro'];?>">
                <span>Telefono Fijo 1</span>
                <input type="text" name="telefono_1_pro" id="" maxlength="30" value="<?php echo $producto['telefono_1_pro'];?>">
                <span>Telefono Fijo 2</span>
                <input type="text" name="telefono_2_pro" id="" maxlength="30" value="<?php echo $producto['telefono_2_pro'];?>">
                <span>Correo Electronico</span>
                <input type="email" name="email_1_pro" id="" maxlength="50" value="<?php echo $producto['email_1_pro'];?>">
                <span>Correo Electronico 2</span>
                <input type="email" name="email_2_pro" id="" maxlength="50" value="<?php echo $producto['email_2_pro'];?>">
                <div class="buttons">
                  <button type="submit" class="btn"><i class="far fa-save"></i></button> 
                  <button class="btn"><i class="fas fa-arrow-up"></i></button>
                </div>
              </form>
            </li>
          </ul>
        </li>
      </ul>
    </div>
    <footer>
      <span>Copyright 2020 Departamento Suministros</span>
    </footer>
  </div>
<script>
    // enter text only
    function soloLetras(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = "abcdefghijklmnñopqrstuvwxyz";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }

    // enter number only
    function soloNumeros(e)
    {
      var patron = /^(\d+|\d+.\d{2})$/;
      var key = window.Event ? e.which : e.keyCode;
      return (key >= 48 && key <= 57 && patron)
    }

 function validar(){
  var number = document.getElementById('ruc').value;
  var dto = number.length;
  var valor;
  var acu=0;
  if(number==""){
   alert('No has ingresado ningún dato, porfavor ingresar los datos correspondientes.');
   }
  else{
   for (var i=0; i<dto; i++){
   valor = number.substring(i,i+1);
   if(valor==0||valor==1||valor==2||valor==3||valor==4||valor==5||valor==6||valor==7||valor==8||valor==9){
    acu = acu+1;
   }
   }
   if(acu==dto){
    while(number.substring(10,13)!=001){
     alert('Los tres últimos dígitos no tienen el código del RUC 001.');
     return;
    }
    while(number.substring(0,2)>24){    
     alert('Los dos primeros dígitos no pueden ser mayores a 24.');
     return;
    }
    alert('El RUC está escrito correctamente');
    alert('Se procederá a analizar el respectivo RUC.');
    var porcion1 = number.substring(2,3);
    if(porcion1<6){
     alert('El tercer dígito es menor a 6, por lo \ntanto el usuario es una persona natural.\n');
    }
    else{
     if(porcion1==6){
      alert('El tercer dígito es igual a 6, por lo \ntanto el usuario es una entidad pública.\n');
     }
     else{
      if(porcion1==9){
       alert('El tercer dígito es igual a 9, por lo \ntanto el usuario es una sociedad privada.\n');
      }
     }
    }
   }
   else{
   alert("ERROR: Por favor no ingrese texto");
   }
  }
 }
  </script>
</body>
</html>