<?php 
require 'php/conexion.php'; 
  $id = $_GET['id'];
  $query= "SELECT * FROM categoria";	
  $resultado = $conexion->query($query);
  
      $sql= "SELECT * FROM productos AS p, categoria AS c WHERE (p.idcategoria_pr = c.idcategoria)";	
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
        <li class="product td"><span><i class="fas fa-box-open"></i></span><a href="#" class="pr">Actualizar Producto</a>
          <ul>
            <li class="register_pro">
              <form action="php/update.php" method="POST" >    
                <input style="display:none;" type="text" name="idproducto" value="<?php echo $producto['idproducto'];?>">
                <span>Codigo de Barra</span>
                <input type="text" name="serie_pr" id="" maxlength="30" value="<?php echo $producto['codigo_barra_pr'];?>">
                <span>Nombre</span>
                <input type="text" name="nombre_pr" id="" onkeypress="return soloLetras(event)" maxlength="30" value="<?php echo $producto['nombre_pr'];?>">
                <span>Descripcion</span>
                <textarea name="descripcion_pr" id="" cols="30" rows="10"><?php echo $producto['descripcion_pr'];?></textarea>
                <span>Categoria - Insumos</span>
                <select name="categoria_pr" id="" maxlength="20">
                <option selected="true" value="<?php echo $producto['idcategoria_pr'];?>"><?php echo utf8_encode($producto['nombre_cate'])?></option>
                <option disabled value="">Seleccione...</option>
                  <?php
                    while($catenom = $resultado->fetch_assoc()):
                  ?>
                  <option value="<?php echo $catenom["idcategoria"];?>"><?php echo $catenom["nombre_cate"];?></option>
                  <?php 
                    endwhile;
                  ?> 
                </select>
                <span>Stock</span>
                <input type="number" name="stock_pr" id="" onKeyPress="return soloNumeros(event)" maxlength="6" value="<?php echo $producto['stock_pr'];?>">
                <span>Precio</span>
                <input type="number" name="precio_pr" id="" onKeyPress="return soloNumeros(event)" maxlength="6" value="<?php echo $producto['precio_pr'];?>">
                <span>Fecha de Elaboracion</span>
                <input type="date" name="fecha_elaboracion" id="" value="<?php echo $producto['fecha_elaboracion_pr'];?>">
                <span>Fecha de Caducidad</span>
                <input type="date" name="fecha_caducidad" id="" value="<?php echo $producto['fecha_caducidad_pr'];?>">
                <div class="buttons">
                  <button type="button" class="btn"><a href="index.php"><i class="fas fa-window-close" title="cancelar"></i></a</button> 
                  <button class="btn"><i class="fas fa-save"></i></button> 
                </div>
              </form>
            </li>
          </ul>
        </li>
      </ul>
    </div>
    <footer>
      <span  style="font-size: 0.7rem;">Copyright 2020 Departamento Suministros</span>
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