<?php
   function printLayout ($route, $homePage, $credencial, $scopes, $usuarios, $cargos){
      echo "<nav class='navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow'>";
      echo "<a class='navbar-brand col-md-3 col-lg-2 mr-0 px-3' href=$route>";
      echo "<span className='font-weight-bold'>Modulo </span>";
      echo "<span className='font-weight-ligth'>Seguridad</span>";
      echo "</a>";
      echo "<button class='navbar-toggler position-absolute d-md-none collapsed' type='button' data-toggle='collapse' data-target='#sidebarMenu' aria-controls='sidebarMenu' aria-expanded='false' aria-label='Toggle navigation'>";
      echo "    <span class='navbar-toggler-icon'></span>";
      echo "</button>";
      echo "<ul class='navbar-nav px-3'>";
      // echo "<li class='nav-item text-nowrap'>";
      // echo "<a class='nav-link' href='#'>Cerrar sesión</a>";
      // echo "</li>";
      echo "</ul>";
      echo "<a class='nav-link dropdown-toggle' style='color: white;' href='#' id='navbarDropdownMenuLink' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
      // PONER EL USER NAME!!
      echo "Nombre de usuario";
      echo "</a>";
      echo "<div class='dropdown-menu dropdown-menu-right mr-1' aria-labelledby='navbarDropdownMenuLink'>";
      echo "<a class='dropdown-item' href='#'>Ajustes</a>";
      echo "<a class='dropdown-item' href='#'>Another action</a>";
      echo "<a class='dropdown-item' href='#'>Cerrar sesión</a></div>";
      echo "</nav>";

      echo "<nav id='sidebarMenu' class='col-md-3 col-lg-2 d-md-block bg-light sidebar collapse'>";
      echo "<div class='sidebar-sticky pt-3'>";
      echo "<ul class='nav flex-column'>";
      echo "<li class='nav-item'>";
      echo "<a class='nav-link active' href=$homePage>";
      echo "<span data-feather='home'></span>";
      echo "Pagina Principal <span class='sr-only'>(current)</span>";
      echo "</a>";
      echo "</li>";
      echo "<li class='nav-item'>";
      echo "<a class='nav-link' href=$credencial>";
      echo "<span data-feather='briefcase'></span>";
      echo "Gestion Credenciales";
      echo "</a>";
      echo "</li>";
      echo "<li class='nav-item'>";
      echo "<a class='nav-link' href=$scopes>";
      echo "<span data-feather='users'></span>";
      echo "Gestión Scopes";
      echo "</a>";
      echo "</li>";
      echo "<li class='nav-item'>";
      echo "<a class='nav-link' href=$usuarios>";
      echo "<span data-feather='bar-chart-2'></span>";
      echo "Usuarios";
      echo "</a>";
      echo "</li>";
      echo "<li class='nav-item'>";
      echo "<a class='nav-link' href=$cargos>";
      echo "<span data-feather='layers'></span>";
      echo "Cargos/Credenciales";
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
      // echo "<li class='nav-item'>";
      // echo "<a class='nav-link' href='#'>";
      // echo "<span data-feather='file-text'></span>";
      // echo "Historial de personal";
      // echo "</a>";
      // echo "</li>";
      echo "</div>";
      echo "</nav>";
   }


