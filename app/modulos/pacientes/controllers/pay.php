<?php
require_once("class/Payment.php");

extract($_REQUEST);

$oPayment= new Payment($conektaTokenId, $card,$name,$descripcion,$total,$email);
header('Content-Type: application/json');
$arr = array('response' => "", 'id' => "");
    if($oPayment->pay()){
        $arr['response'] = 1; 
        $arr['id'] = $oPayment->idLast;
        echo json_encode($arr); 

    }else{
        $arr['response'] = $oPayment->error; 
        echo json_encode($arr); 
    }

?>