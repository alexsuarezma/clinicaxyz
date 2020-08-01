<?php
     function semanasMes($mes,$anno)
     {		
         $ultimo_dia = date("d",mktime(0,0,0,$mes+1,0,$anno));
         $semanas = array();
         $cantidad_semanas = 0;
         $inicio = 1;
         $fin = 0;
         $dia_semana = '';
         for($i = 1;$i<=$ultimo_dia;$i++)
         {
             $fecha = mktime(0,0,0,$mes,$i,$anno);
             $dia_semana = date('w',($fecha));
             if($dia_semana == 0)
             {
                 $semanas[$cantidad_semanas] = array('inicio' => $inicio,'fin'=>$i);
                 $inicio = $i+1;
                 $cantidad_semanas++;
             }
         }
         $ultima_semana = end($semanas);
         if($ultima_semana['fin'] != $ultimo_dia)
         {
             $semanas[$cantidad_semanas] = array('inicio' => $inicio,'fin' => $ultimo_dia);
         }
         return $semanas;
     }








