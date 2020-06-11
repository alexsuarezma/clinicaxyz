<?php
    require '../../../../database.php';
    require '../components/layout.php';
        $records = $conn->prepare("SELECT * FROM empleados WHERE deleted=0");
        $records->execute();
        $results = $records->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/dashboard/">
    <link rel="stylesheet" href="../assets/styles/component/cards.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- Bootstrap core CSS -->
    <link href="../assets/dist/css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../assets/styles/component/dashboard.css" rel="stylesheet">
    <style>
        #myInput {
                background-image: url('/css/searchicon.png');
                background-position: 10px 12px;
                background-repeat: no-repeat;
                width: 100%;
                font-size: 16px;
                padding: 12px 20px 12px 40px;
                border: 1px solid #ddd;
                margin-bottom: 12px;
            }
    </style>
</head>
<body>
<?php
  printLayout('../index.php', '../../../../index.html', 'contrato.php', 'personal.php');
?>
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
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
      <!-- <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form> -->
      <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name">

    </div>
    <div class="container page-container">
        <div class="row gutters">
        <?php 
            foreach($results as $empleado):
        ?>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-12">
                <figure class="user-card green">
                    <figcaption>
                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="Milestone Admin" class="profile">
                        <h5><?php echo "$empleado->nombres $empleado->apellidos"?></h5>
                        <h6><?php echo $empleado->cedula?></h6>
                        <p><?php echo "Personal $empleado->personal. Capacitado en la especialidad de ...." ?></p>
                        <ul class="contacts">
                            <li>
                                    <?php echo $empleado->email?>
                            </li>
                            <li>
                                <!-- Para concatenar variables usamos & y luego todo se repite-->
                                <a href="profile.php?id=<?php echo $empleado->cedula?>">
                                    Dirigete al perfil!!->
                                </a>
                            </li>
                        </ul>
                        <div class="clearfix">
                            <span class="badge badge-pill badge-success">DISPONIBLE</span>
                            <span class="badge badge-pill badge-orange">En jornada</span>
                        </div>
                    </figcaption>
                </figure>
            </div>
        <?php 
            endforeach;
        ?>

            
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-12">
                <figure class="user-card blue">
                    <figcaption>
                        <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="Milestone Admin" class="profile">
                        <h5>Amelia</h5>
                        <h6>@hollywood</h6>
                        <p>On the 28th of October 2016 we completed a 3-part transaction with the contractor.</p>
                        <ul class="contacts">
                            <li>
                                <a href="#">
                                    user@bootdey.com
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    www.bootdey.com
                                </a>
                            </li>
                        </ul>
                        <div class="clearfix">
                            <span class="badge badge-pill badge-info">#HTML5</span>
                            <span class="badge badge-pill badge-success">#CSS3</span>
                            <span class="badge badge-pill badge-orange">#Angular JS</span>
                        </div>
                    </figcaption>
                </figure>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-12">
                <figure class="user-card pink">
                    <figcaption>
                        <img src="https://bootdey.com/img/Content/avatar/avatar3.png" alt="Milestone Admin" class="profile">
                        <h5>Emma</h5>
                        <h6>@star</h6>
                        <p>On the 28th of October 2016 we completed a 3-part transaction with the contractor.</p>
                        <ul class="contacts">
                            <li>
                                <a href="#">
                                    user@bootdey.com
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    www.bootdey.com
                                </a>
                            </li>
                        </ul>
                        <div class="clearfix">
                            <span class="badge badge-pill badge-info">#HTML5</span>
                            <span class="badge badge-pill badge-success">#CSS3</span>
                            <span class="badge badge-pill badge-orange">#Angular JS</span>
                        </div>
                    </figcaption>
                </figure>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-12">
                <figure class="user-card brown">
                    <figcaption>
                        <img src="https://bootdey.com/img/Content/avatar/avatar4.png" alt="Milestone Admin" class="profile">
                        <h5>Olivia</h5>
                        <h6>@business</h6>
                        <p>On the 28th of October 2016 we completed a 3-part transaction with the contractor.</p>
                        <ul class="contacts">
                            <li>
                                <a href="#">
                                    user@bootdey.com
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    www.bootdey.com
                                </a>
                            </li>
                        </ul>
                        <div class="clearfix">
                            <span class="badge badge-pill badge-info">#HTML5</span>
                            <span class="badge badge-pill badge-success">#CSS3</span>
                            <span class="badge badge-pill badge-orange">#Angular JS</span>
                        </div>
                    </figcaption>
                </figure>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-12">
                <figure class="user-card fb">
                    <figcaption>
                        <img src="https://bootdey.com/img/Content/avatar/avatar5.png" alt="Milestone Admin" class="profile">
                        <h5>Harry</h5>
                        <h6>@writer</h6>
                        <p>On the 28th of October 2016 we completed a 3-part transaction with the contractor.</p>
                        <ul class="contacts">
                            <li>
                                <a href="#">
                                    user@bootdey.com
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    www.bootdey.com
                                </a>
                            </li>
                        </ul>
                        <div class="clearfix">
                            <span class="badge badge-pill badge-info">#HTML5</span>
                            <span class="badge badge-pill badge-success">#CSS3</span>
                            <span class="badge badge-pill badge-orange">#Angular JS</span>
                        </div>
                    </figcaption>
                </figure>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-12">
                <figure class="user-card green">
                    <figcaption>
                        <img src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="Milestone Admin" class="profile">
                        <h5>George</h5>
                        <h6>@tester</h6>
                        <p>On the 28th of October 2016 we completed a 3-part transaction with the contractor.</p>
                        <ul class="contacts">
                            <li>
                                <a href="#">
                                    user@bootdey.com
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    www.bootdey.com
                                </a>
                            </li>
                        </ul>
                        <div class="clearfix">
                            <span class="badge badge-pill badge-info">#HTML5</span>
                            <span class="badge badge-pill badge-success">#CSS3</span>
                            <span class="badge badge-pill badge-orange">#Angular JS</span>
                        </div>
                    </figcaption>
                </figure>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-12">
                <figure class="user-card red">
                    <figcaption>
                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Milestone Admin" class="profile">
                        <h5>Emily</h5>
                        <h6>@designer</h6>
                        <p>On the 28th of October 2016 we completed a 3-part transaction with the contractor.</p>
                        <ul class="contacts">
                            <li>
                                <a href="#">
                                    user@bootdey.com
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    www.bootdey.com
                                </a>
                            </li>
                        </ul>
                        <div class="clearfix">
                            <span class="badge badge-pill badge-info">#HTML5</span>
                            <span class="badge badge-pill badge-success">#CSS3</span>
                            <span class="badge badge-pill badge-orange">#Angular JS</span>
                        </div>
                    </figcaption>
                </figure>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-12">
                <figure class="user-card orange">
                    <figcaption>
                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="Milestone Admin" class="profile">
                        <h5>Julie</h5>
                        <h6>@fashion</h6>
                        <p>On the 28th of October 2016 we completed a 3-part transaction with the contractor.</p>
                        <ul class="contacts">
                            <li>
                                <a href="#">
                                    user@bootdey.com
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    www.bootdey.com
                                </a>
                            </li>
                        </ul>
                        <div class="clearfix">
                            <span class="badge badge-pill badge-info">#HTML5</span>
                            <span class="badge badge-pill badge-success">#CSS3</span>
                            <span class="badge badge-pill badge-orange">#Angular JS</span>
                        </div>
                    </figcaption>
                </figure>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-12">
                <figure class="user-card teal">
                    <figcaption>
                        <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="Milestone Admin" class="profile">
                        <h5>Taylor</h5>
                        <h6>@marketing</h6>
                        <p>On the 28th of October 2016 we completed a 3-part transaction with the contractor.</p>
                        <ul class="contacts">
                            <li>
                                <a href="#">
                                    user@bootdey.com
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    www.bootdey.com
                                </a>
                            </li>
                        </ul>
                        <div class="clearfix">
                            <span class="badge badge-pill badge-info">#HTML5</span>
                            <span class="badge badge-pill badge-success">#CSS3</span>
                            <span class="badge badge-pill badge-orange">#Angular JS</span>
                        </div>
                    </figcaption>
                </figure>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-12">
                <figure class="user-card gp">
                    <figcaption>
                        <img src="https://bootdey.com/img/Content/avatar/avatar3.png" alt="Milestone Admin" class="profile">
                        <h5>Roberts</h5>
                        <h6>@actress</h6>
                        <p>On the 28th of October 2016 we completed a 3-part transaction with the contractor.</p>
                        <ul class="contacts">
                            <li>
                                <a href="#">
                                    user@bootdey.com
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    www.bootdey.com
                                </a>
                            </li>
                        </ul>
                        <div class="clearfix">
                            <span class="badge badge-pill badge-info">#HTML5</span>
                            <span class="badge badge-pill badge-success">#CSS3</span>
                            <span class="badge badge-pill badge-orange">#Angular JS</span>
                        </div>
                    </figcaption>
                </figure>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-12">
                <figure class="user-card blue">
                    <figcaption>
                        <img src="https://bootdey.com/img/Content/avatar/avatar4.png" alt="Milestone Admin" class="profile">
                        <h5>O'Sullivan</h5>
                        <h6>@smart</h6>
                        <p>On the 28th of October 2016 we completed a 3-part transaction with the contractor.</p>
                        <ul class="contacts">
                            <li>
                                <a href="#">
                                    user@bootdey.com
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    www.bootdey.com
                                </a>
                            </li>
                        </ul>
                        <div class="clearfix">
                            <span class="badge badge-pill badge-info">#HTML5</span>
                            <span class="badge badge-pill badge-success">#CSS3</span>
                            <span class="badge badge-pill badge-orange">#Angular JS</span>
                        </div>
                    </figcaption>
                </figure>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-12">
                <figure class="user-card orange">
                    <figcaption>
                        <img src="https://bootdey.com/img/Content/avatar/avatar5.png" alt="Milestone Admin" class="profile">
                        <h5>O'Brien</h5>
                        <h6>@football</h6>
                        <p>On the 28th of October 2016 we completed a 3-part transaction with the contractor.</p>
                        <ul class="contacts">
                            <li>
                                <a href="#">
                                    user@bootdey.com
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    www.bootdey.com
                                </a>
                            </li>
                        </ul>
                        <div class="clearfix">
                            <span class="badge badge-pill badge-info">#HTML5</span>
                            <span class="badge badge-pill badge-success">#CSS3</span>
                            <span class="badge badge-pill badge-orange">#Angular JS</span>
                        </div>
                    </figcaption>
                </figure>
            </div>
         </div>
        </div>
     </main>
   </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="../assets/dist/js/bootstrap.bundle.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <script src="../components/scripts/dashboard.js"></script>      
</body>
</html>