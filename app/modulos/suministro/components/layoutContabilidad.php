<?php

function printLayout (){
  require '../../../../database.php';
  $orden = $conn->query("SELECT * FROM orden_compra WHERE estado='espera'")->rowCount();
      
      echo "<nav class='navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow'>";
      echo "<a class='navbar-brand col-md-3 col-lg-2 mr-0 px-3' href='../../contabilidad/'>";
      echo "<img src='../../../../clinicavitalia.ico' width='25px;' class='mr-3'>";
      echo "<span className='font-weight-bold'>Modulo </span>";
      echo "<span className='font-weight-ligth'>Contabilidad</span>";
      echo "</a>";
      echo "<button class='navbar-toggler position-absolute d-md-none collapsed' type='button' data-toggle='collapse' data-target='#sidebarMenu' aria-controls='sidebarMenu' aria-expanded='false' aria-label='Toggle navigation'>";
      echo "    <span class='navbar-toggler-icon'></span>";
      echo "</button>";
      echo "<ul class='navbar-nav px-3'>";

      echo "</ul>";
      echo "<a class='nav-link dropdown-toggle' style='color: white;' href='#' id='navbarDropdownMenuLink' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
      echo "<i class='fas fa-th-large' ></i>";
      echo "</a>" ;
      echo "<div class='dropdown-menu dropdown-menu-right mr-1 mb-2' style='width:400px;' aria-labelledby='navbarDropdownMenuLink'>";
      echo "<span class='dropdown-item font-weight-bold mb-2' style='text-align:center;'>".$_SESSION['username']."</span>";
      echo "<hr class='ml-4 mr-4 mt-2'>";
      echo "<span class='dropdown-item font-weight-bold border-bottom border-info mb-2' style='text-align:center;'>".$_SESSION['nombre_credencial']."</span>";
        if($_SESSION['modulo_rrhh'] == 1){
          echo "<a class='dropdown-item mt-2' href='../../recursoshumanos/'><i class='fas fa-people-carry mr-2'></i> Recursos Humanos</a>";
        }
        if($_SESSION['modulo_suministros'] == 1){
          echo "<a class='dropdown-item' href=../../suministro/><i class='fas fa-dolly-flatbed mr-2'></i> Suministros</a>";
        }
        if($_SESSION['modulo_contabilidad'] == 1){
          echo "<a class='dropdown-item' href='../../contabilidad/'><i class='fas fa-balance-scale mr-2'></i> Contabilidad</a>";
        }
        if($_SESSION['modulo_ctas_medicas'] == 1){
          echo "<a class='dropdown-item' href='../../citasmedicas/'><i class='fas fa-notes-medical mr-3'></i> Citas Medicas</a>";
        }
        if($_SESSION['modulo_pacientes'] == 1){
          echo "<a class='dropdown-item' href='../../pacientes/'><i class='fas fa-procedures mr-2'></i> Modulo Pacientes</a>";
        }
        if($_SESSION['modulo_seguridad'] == 1){
          echo "<a class='dropdown-item' href'../../seguridad/'><i class='fas fa-user-shield mr-2'></i> Modulo Seguridad</a>";
        }
        if($_SESSION['paciente'] == 1){
          echo "<a class='dropdown-item' href='app/modulos/pacientes/index copy 2.html'><i class='fas fa-procedures mr-2'></i> Paciente</a>";
        }
      
      echo "<hr class='ml-4 mr-4 mt-2'>";
      echo "<a class='dropdown-item mt-2' style='float:right;' href='../../seguridad/routes/perfil.php'><span class='float-right'>Ajustes de Usuario</span></a>";
      echo "<a class='dropdown-item' style='float:right;' href='#'><span class='float-right'>Another</span></a>";
      echo "<a class='dropdown-item' style='float:right;' href='../../seguridad/controllers/logout.php'><span class='float-right'>Cerrar Sesión</span></a>";
      echo "</div>";
      echo "</nav>";

      echo "<nav id='sidebarMenu' class='col-md-3 col-lg-2 d-md-block bg-light sidebar collapse'>";
      echo "<div class='sidebar-sticky pt-3'>";
      echo "<ul class='nav flex-column'>";
      echo "<li class='nav-item'>";
      echo "<a class='nav-link' href='../../contabilidad/'>";
      echo "<span data-feather='home'></span>";
      echo "Inicio <span class='sr-only'>(current)</span>";
      echo "</a>";
      echo "</li>";
      echo "<li class='nav-item'>";
      echo "<a class='nav-link' href='../../contabilidad/index.php'>";
      echo "<span data-feather='home'></span>";
      echo "Ingreso de Cuentas <span class='sr-only'>(current)</span>";
      echo "</a>";
      echo "</li>";
      echo "<li class='nav-item'>";
      echo "<a class='nav-link' href='../../contabilidad/ing-egre.php'>";
      echo "<span data-feather='users'></span>";
      echo "Ingreso y Egresos de la Clinica";
      echo "</a>";
      echo "</li>";
      echo "<li class='nav-item'>";
      echo "<a class='nav-link' href='#'>";
      echo "<span data-feather='layers'></span>";
      echo "Customers";
      echo "</a>";
      echo "</li>";
      echo "<li class='nav-item'>";
      echo "<a class='nav-link active' href='historialRequerimientos.php'>";
      echo "<span data-feather='bar-chart-2'></span>";
      echo "Requerimientos "; 
      if ($orden > 0):
        echo "<span class='badge badge-info'> $orden</span>";
      endif;
      echo "</a>";
      echo "</li>";
      echo "<li class='nav-item'>";
      echo "<a class='nav-link' href='#'>";
      echo "<span data-feather='layers'></span>";
      echo "Integrations";
      echo "</a>";
      echo "</li>";
      echo "</ul>";
      echo "<ul class='nav flex-column mb-2'>";

      echo "<h6 class='sidebar-heading d-flex justify-content-start align-items-center px-3 mt-4 mb-2 text-muted'>";
      echo "Saved Reports";
      echo "<a class='d-flex align-items-center text-muted ml-5' href='#' aria-label='Add a new report'>";
      echo "  <a data-toggle='collapse' href='#collapseExample' role='button' aria-expanded='false' aria-controls='collapseExample'>
            <span data-feather='plus-circle'></span></a>";
      echo "</a>";
      echo "</h6>";

      echo "<li class='nav-item'>";
      echo "<a class='nav-link' href='#'>";
      echo "<span data-feather='file-text'></span>";
      echo "Current month";
      echo "</a>";
      echo "</li>";
      echo "<li class='nav-item'>";
      echo "<a class='nav-link' href='#'>";
      echo "<span data-feather='file-text'></span>";
      echo "Last quarter";
      echo "</a>";
      echo "</li>";
      echo "<li class='nav-item'>";
      echo "<a class='nav-link' href='#'>";
      echo "<span data-feather='file-text'></span>";
      echo "Social engagement";
      echo "</a>";
      echo "</li>";
      echo "<li class='nav-item'>";
      echo "<a class='nav-link' href='#'>";
      echo "<span data-feather='file-text'></span>";
      echo "Year-end sale";
      echo "</a>";
      echo "</li>";
      echo "</ul>";
      echo "</div>";
      echo "</nav>";

      $conn = null;
   }



