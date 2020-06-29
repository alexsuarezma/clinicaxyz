<h1> Elaborado por Walther Arana </h1>
<h2> Convertir de Metros a Kilometros </h2> 
<?php
//conversiones de metros a kilometros 
// 1 km = 1000 m
$metros = 5;
define('conversion', 1000);
$kilometros = $metros / conversion;
echo " $metros m son $kilometros km";
?>
<h2> Convertir de Bytes a Terabytes </h2> 
<?php 
// 1 byte= 1.0x10^-12
$bytes = 4;
define('convertir', 1.0);
$terabyte = $bytes * convertir;
echo " $bytes bytes son $terabyte x10^-12 Tb";
?>
<h2> Convertir de Libras a Kilogramos </h2> 
<?php 
// 1 kg= 2.2 lb
$libras = 550;
define('convertidor', 2.2);
$kilogramos = $libras / convertidor;
echo " $libras lb son $kilogramos Kg";
?>
