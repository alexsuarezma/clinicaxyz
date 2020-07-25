<?php
   function printLayout ($route, $homePage, $createPage, $personalPage, $reclutamiento, $historialPersonal, $asistencia,
   $logout,$ajuste,$rrhh,$suministro,$contabilidad,$ctas_medicas,$paciente,$seguridad,$active){
    
    $routes[5]= [];
  

    for ($i = 0; $i < 6; $i++) {
      if($active==($i+1)){
        $routes[$i]="active";
      }else{
        $routes[$i]="";
      }
    }

      echo "<nav class='navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow'>";
      echo "<a class='navbar-brand col-md-3 col-lg-2 mr-0 px-3' href=$route>";
      echo "<span className='font-weight-bold'>Recursos</span>";
      echo "<span className='font-weight-ligth'>Humanos</span>";
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
          echo "<a class='dropdown-item mt-2' href=$rrhh><i class='fas fa-people-carry mr-2'></i> Recursos Humanos</a>";
        }
        if($_SESSION['modulo_suministros'] == 1){
          echo "<a class='dropdown-item' href=$suministro><i class='fas fa-dolly-flatbed mr-2'></i> Suministros</a>";
        }
        if($_SESSION['modulo_contabilidad'] == 1){
          echo "<a class='dropdown-item' href=$contabilidad><i class='fas fa-balance-scale mr-2'></i> Contabilidad</a>";
        }
        if($_SESSION['modulo_ctas_medicas'] == 1){
          echo "<a class='dropdown-item' href=$ctas_medicas><i class='fas fa-notes-medical mr-3'></i> Citas Medicas</a>";
        }
        if($_SESSION['modulo_pacientes'] == 1){
          echo "<a class='dropdown-item' href=$paciente><i class='fas fa-procedures mr-2'></i> Modulo Pacientes</a>";
        }
        if($_SESSION['modulo_seguridad'] == 1){
          echo "<a class='dropdown-item' href=$seguridad><i class='fas fa-user-shield mr-2'></i> Modulo Seguridad</a>";
        }
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
      echo "<a class='nav-link $routes[1]' href=$createPage>";
      echo "<span data-feather='briefcase'></span>";
      echo "Registro de Empleado";
      echo "</a>";
      echo "</li>";
      echo "<li class='nav-item'>";
      echo "<a class='nav-link $routes[2]' href=$personalPage>";
      echo "<span data-feather='users'></span>";
      echo "Personal";
      echo "</a>";
      echo "</li>";
      echo "<li class='nav-item'>";
      echo "<a class='nav-link $routes[3]' href=$asistencia>";
      echo "<span data-feather='layers'></span>";
      echo "Lista de Asistencia";
      echo "</a>";
      echo "</li>";
      echo "<li class='nav-item'>";
      echo "<a class='nav-link' href='#'>";
      echo "<span data-feather='bar-chart-2'></span>";
      echo "Reportes";
      echo "</a>";
      echo "</li>";
      echo "<li class='nav-item'>";
      echo "<a class='nav-link $routes[4]' href=$reclutamiento>";
      echo "<span data-feather='layers'></span>";
      echo "Reclutamiento";
      echo "</a>";
      echo "</li>";
      echo "</ul>";

      echo "<h6 class='sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted'>";
      echo "<span>Sub menus</span>";
      echo "<a class='d-flex align-items-center text-muted' href='#' aria-label='Add a new report'>";
      echo "<span data-feather='plus-circle'></span>";
      echo "</a>";
      echo "</h6>";
      echo "<ul class='nav flex-column mb-2'>";
      echo "<li class='nav-item'>";
      echo "<a class='nav-link $routes[5]' href=$historialPersonal>";
      echo "<span data-feather='file-text'></span>";
      echo "Historial de personal";
      echo "</a>";
      echo "</li>";
      // echo "<li class='nav-item'>";
      // echo "<a class='nav-link' href='#'>";
      // echo "<span data-feather='file-text'></span>";
      // echo "Last quarter";
      // echo "</a>";
      // echo "</li>";
      // echo "<li class='nav-item'>";
      // echo "<a class='nav-link' href='#'>";
      // echo "<span data-feather='file-text'></span>";
      // echo "Historial de";
      // echo "</a>";
      // echo "</li>";
      // echo "<li class='nav-item'>";
      // echo "<a class='nav-link' href='#'>";
      // echo "<span data-feather='file-text'></span>";
      // echo "Year-end sale";
      // echo "</a>";
      // echo "</li>";
      // echo "</ul>";
      echo "</div>";
      echo "</nav>";
   }



