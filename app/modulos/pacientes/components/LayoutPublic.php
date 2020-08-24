<?php
   function printLayout ($route, $homePage, $solicitar, $diagnostico, $facturas,$logout,$ajuste,$paciente,$active){
    
    $routes[4]= [];
  

    for ($i = 0; $i < 5; $i++) {
      if($active==($i+1)){
        $routes[$i]="active";
      }else{
        $routes[$i]="";
      }
    }

      echo "<nav class='navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow'>";
      echo "<a class='navbar-brand col-md-3 col-lg-2 mr-0 px-3' href=$route>";
      // echo "<span className='font-weight-bold'>Modulo</span>";
      // echo "<span className='font-weight-ligth'>Pacientes</span>";
      echo "<span class='badge badge-light container-fluid'><img src='../../../../clinicavitalia.ico' width='15%' class='rounded mx-auto d-block mr-3'></span>";
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
        if($_SESSION['paciente'] == 1){
          echo "<a class='dropdown-item' href='app/modulos/pacientes/index copy 2.html'><i class='fas fa-procedures mr-2'></i> Paciente</a>";
        }
      
      // <a class='dropdown-item' href='#'><i class='fas fa-file-medical-alt mr-3'></i> Historial Clinico</a>
      echo "<hr class='ml-4 mr-4 mt-2'>";
      echo "<a class='dropdown-item mt-2' style='float:right;' href=$ajuste><span class='float-right'>Ajustes de Usuario</span></a>";
      echo "<a class='dropdown-item' style='float:right;' href='#'><span class='float-right'>Another</span></a>";
      echo "<a class='dropdown-item' style='float:right;' href=$logout><span class='float-right'>Cerrar Sesión</span></a>";
      echo "</div>";
      echo "</nav>";

      echo "<nav id='sidebarMenu' class='col-md-3 col-lg-2 d-md-block bg-light sidebar collapse'>";
      echo "<div class='sidebar-sticky pt-3'>";
      echo "<ul class='nav flex-column'>";
      echo "<li class='nav-item'>";
      echo "<a class='nav-link $routes[0]' href=$homePage>";
      echo "<span data-feather='home'></span>";
      echo "Pagina Principal <span class='sr-only'>(current)</span>";
      echo "</a>";
      echo "</li>";
      echo "<li class='nav-item'>";
      echo "<a class='nav-link $routes[1]' href=$solicitar>";
      echo "<span data-feather='briefcase'></span>";
      echo "Solicitar Cita";
      echo "</a>";
      echo "</li>";
      echo "<li class='nav-item'>";
      echo "<a class='nav-link $routes[2]' href=$diagnostico>";
      echo "<span data-feather='users'></span>";
      echo "Diagnóstico";
      echo "</a>";
      echo "</li>";
      echo "<li class='nav-item'>";
      echo "<a class='nav-link $routes[3]' href=$facturas>";
      echo "<span data-feather='layers'></span>";
      echo "Facturas";
      echo "</a>";
      echo "</li>";
      echo "</ul>";
      echo "</div>";
      echo "</nav>";
   }



