<?php

function conDb(){
  $con = mysqli_connect('us-cdbr-east-05.cleardb.net', 'b7550b2dcd9c38', 'a16e5057', 'heroku_fe7e002859673b2');

  if(!$con){
    print_r(mysqli_connect_error());
    return false;
  }else{
    $con->set_charset("utf8");
    return $con;
  }
}
?>



