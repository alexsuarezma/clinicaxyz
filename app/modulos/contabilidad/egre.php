<?php
require '../../../database.php';
require "clases/conexion.php";

$obj= new conectar();
$conexion=$obj->conexion();

$sql="SELECT sum(convert((sub_total+iva),decimal(18,2))) as Total from pagos";
      $result=mysqli_query($conexion,$sql);
      $ver=mysqli_fetch_row($result);
      
$orden = $conn->query("SELECT * FROM orden_compra WHERE estado='espera'")->rowCount();
$conn=null;
?>

<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
    <title>Dashboard Template · Bootstrap</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/dashboard/">

    <!-- Bootstrap core CSS -->
<link href="../assets/dist/css/bootstrap.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }
      #buton{
    height:60px; 
    width:100px; 
    margin: 10px -100px; 
    position:relative;
    top:60%; 
    left:50%;
}
      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    
    
   
    <link href="dashboard/dashboard.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
     <?php require_once "scripts.php";  ?>
  </head>
  <body>
    <div>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="#"><img src="img/clinicavitalia.ico" height= "60px" hspace="2px" ></a>
 
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation"  >
    <span class="navbar-toggler-icon"></span>
  </button>
  
  <ul class="navbar-nav px-8">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="#">Sign out</a>
    </li>
  </ul>
</nav>
</div>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="sidebar-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link " href="#">
              <span data-feather="home"></span>
              Inicio <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <span data-feather="file"></span>
              Plan de Cuentas
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="ing-egre.php" >
              <span data-feather="shopping-cart"></span>
              
              Ingresos de la Clinica
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="#">
              <span data-feather="users"></span>
              Egresos de la Clinica
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../suministro/routes/historialRequerimientos.php">
              <span data-feather="bar-chart-2"></span>
              Requerimientos <span class='badge badge-info'><?php if ($orden > 0): echo $orden; endif; ?></span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="reporte.php" target="_blank">
              <span data-feather="layers"></span>
              Reporte General de Cuentas
            </a>
          </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Saved reports</span>
          <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
            <span data-feather="plus-circle"></span>
          </a>
        </h6>
        <ul class="nav flex-column mb-2">
          <li class="nav-item">
            <a class="nav-link" href="reporte-ing.php" target="_blank">
              <span data-feather="file-text"></span>
              Reporte Ingresos
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="reporte-egre.php" target="_blank">
              <span data-feather="file-text"></span>
              Reporte Egresos
            </a>
          </li>
        
      </div>
    </nav>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Contabilidad</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar"></span>
            This week
          </button>
        </div>
      </div>
<div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card text-left">
          <div class="card-header">
             
          </div>
          
          <div class="card-body">
                        <hr>
            <div id="tablaDatatable"></div>
            <div id="buton">
            <a href="reporte-egre.php" target="_blank"><button type="button"  id="btnReporte" class="btn btn-primary"  value="ir" >Generar Reporte</button></a>
          </div>
          </div>
          <div class="card-footer text-muted">

</br>
            Area de Contabilidad 2020
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="agregarnuevosdatosmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Agrega cuentas</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
       
      </div>
    </div>
  </div>


 
      







    </main>
  </div>
</div>

        <script src="dashboard/dashboard.js"></script></body>
</html>
<script type="text/javascript">
  $(document).ready(function(){
    $('#btnAgregarnuevo').click(function(){
      datos=$('#frmnuevo').serialize();

      $.ajax({
        type:"POST",
        data:datos,
        url:"procesos/agregar.php",
        success:function(r){
          if(r==1){
            $('#frmnuevo')[0].reset();
            $('#tablaDatatable').load('tabla-egre.php');
            alertify.success("agregado con exito :D");
          }else{
            alertify.error("Fallo al agregar :(");
          }
        }
      });
    });

    $('#btnActualizar').click(function(){
      datos=$('#frmnuevoU').serialize();

      $.ajax({
        type:"POST",
        data:datos,
        url:"procesos/actualizar.php",
        success:function(r){
          if(r==1){
            $('#tablaDatatable').load('tabla-egre.php');
            alertify.success("Actualizado con exito :D");
          }else{
            alertify.error("Fallo al actualizar :(");
          }
        }
      });
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#tablaDatatable').load('tabla-egree.php');
  });
</script>

<script type="text/javascript">
  function agregaFrmActualizar(idcta){
    $.ajax({
      type:"POST",
      data:"idcta=" + idcta,
      url:"procesos/obtenDatos.php",
      success:function(r){
        datos=jQuery.parseJSON(r);
        $('#idcta').val(datos['id_cta']);
        $('#cod_ctaU').val(datos['cod_cta']);
        $('#nom_ctaU').val(datos['nom_cta']);
        $('#tipo_ctaU').val(datos['tipo_cta']);
        $('#ing_ctaU').val(datos['ing_cta']);
        $('#egre_ctaU').val(datos['egre_cta']);
        
      }
    });
  }

  

  

//Agregue esto--------------------------------------------------------
  function soloLetras(e) {
      key = e.keyCode || e.which;
      tecla = String.fromCharCode(key).toLowerCase();
      letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
      especiales = [8, 37, 39, 46];
  
      tecla_especial = false
      for(var i in especiales) {
          if(key == especiales[i]) {
              tecla_especial = true;
              break;
          }
      }
  
      if(letras.indexOf(tecla) == -1 && !tecla_especial)

          return false;
  }

 //SOLO NUMEROS
function SoloNumeros() {
 if ((event.keyCode < 46) || (event.keyCode > 57)) 
  event.returnValue = false;
}//---------------------------------------------------------------------


</script>
 <script type="text/javascript">
            
          function ddlselect()
          {

            var d=document.getElementById("tip_cta");
            var displaytext=d.options[d.selectedIndex].text;
            document.getElementById("tipo_cta").value=displaytext;
          }

          
            
          function ddlselectU()
          {

            var d=document.getElementById("tip_ctaU");
            var displaytext=d.options[d.selectedIndex].text;
            document.getElementById("tipo_ctaU").value=displaytext;
          }

          </script>
          <?php

      
