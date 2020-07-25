<?php
function contrato($empleado,$title,$discapacitado,$desde,$hasta){
    $plantilla='
    <body>
    <header class="clearfix">
      <div id="logo">
      <img src="../components/plantilla/clinicavitalia-01.png">
      </div>
      <h1>'.utf8_encode($title).'</h1>
      <div class="firmas-header">
        <div align="left" class="firmas-contrato-cajaheader1">
          <div id="project">
            <div><span></span><b>Clinica Vitalia</b></div>
          </div>
        </div>
      
        <div align="left" class="firmas-contrato-cajaheader2">
          <div id="company" class="clearfix">
            <div>'.substr($empleado[0]->created_at, 0, 8).'</div>
          </div>
        </div>
      </div>
      
    </header>
    <main>
    <div class="contrato-redaccion">
      <span>Conste por el presente documento por duplicado, el contrato de trabajo que celebran; de una parte Clínica Vitalia SL con RUC N° 0968537341001  y domicilio en  _________ a  quien en adelante  se  denominará  EL  EMPLEADOR, el señor(a) <b>'.utf8_encode($empleado[0]->nombres).'</b> <b>'.utf8_encode($empleado[0]->apellidos).'</b>, identificado con DNI  N° <b>'.$empleado[0]->id_empleados.'</b> a  quien en adelante  se  denominará  EL  TRABAJADOR.';

    if((utf8_encode($title) == "CONTRATO DE TRABAJO INDEFINIDO" || utf8_encode($title) == "CONTRATO DE TRABAJO TEMPORAL")&& $discapacitado == true){
        $plantilla.='
        </br>
        <h3></h3> 
        EL TRABAJADOT/AR, es persona con discapacidad, tiene reconocida la condición de tal como se acredita mediante certificación expedida por el Consejo Nacional de Discapacidades (CONADIS).
        ';
    }

    $plantilla.='
        <h3>Declaran </h3> 
        Que reúnen los requisitos exigidos para la celebracion del presente contrato y, en su consecuencia, acuerdan formalizando con arreglo a las siguientes:
        <h2>Clausulas</h2>
        <h3>Antecedentes:</h3>
        <h4>Primera:</h4>  EL  EMPLEADOR es una persona natural.
        <h3>Objeto del contrato</h3>
        <h4>Segunda:</h4> En virtud del presente contrato, EL EMPLEADOR contrata los servicios personales de EL TRABAJADOR, los mismos que se desarrollarán bajo subordinación a cambio de la remuneración convenida.
        <h4>Tercera:</h4> EL TRABAJADOR prestara sus servicios como <b>'.utf8_encode($empleado[0]->nombre_cargo).'</b>, incluido en el grupo profesional de <b>'.utf8_decode($empleado[0]->nombre_area).'</b>, para la realización de funciones de acuerdo con el sistema de clasificación profesional vigente en la clínica. 
        Las partes dejan expresa constancia de que la prestación de servicios es personal, no pudiendo EL TRABAJADOR ser reemplazado por tercera persona.'; 

    if(utf8_encode($title)!= "CONTRATO DE TRABAJO EN PRÁCTICAS"){
        $plantilla.='En caso de que EL TRABAJADOR requiriese de la asistencia de un tercero, deberá comunicarlo a EL EMPLEADOR, quien decidirá si se admite la intervención del tercero.';
    }

    $plantilla.='<h3>Jornada y horario de trabajo</h3>
        <h4>Cuarta:</h4> Las partes estipulan que la jornada laboral de EL TRABAJADOR será de <b>'.utf8_encode($empleado[0]->jornada).'</b> <b>Lunes</b> a <b>Viernes</b>, de <b>'.$empleado[0]->inicio.'</b> a <b>'.$empleado[0]->finalizacion.'</b>.
        Adicionalmente, las partes estipulan que EL TRABAJADOR tendrá un refrigerio de <b>30 min</b>. Dicho refrigerio no se encontrará dentro de la jornada de trabajo.  
        <h4>Quinta:</h4> Las partes convienen en que las remuneraciones por guardia que realice EL TRABAJADOR se otorgarán en función a la remuneración básica y según el horario en se realice dicha guardia, ascendiendo a: 10%, en caso de guardia diurna, 12% en caso de guardia diurna en domingos y feriados o por guardia nocturna y 15% en caso de guardia nocturna en domingos y feriados.
        Cabe acotar que en caso de que EL TRABAJADOR realice turnos de guardia nocturna tendrá derecho a gozar de un descanso post guardia.
        <h3>Remuneración</h3>
        <h4>Sexta:</h4> EL TRABAJADOR percibirá como contraprestación por sus servicios una remuneración mensual ascendente a <b>$ '.$empleado[0]->sueldo_base_cargo.'</b>, durante el tiempo que dure la relación laboral.
        Las ausencias injustificadas por parte de EL TRABAJADOR implicarán la pérdida de la remuneración en forma proporcional a la duración de dicha ausencia.';
        
    if(utf8_encode($title) == "CONTRATO DE TRABAJO EN PRÁCTICAS"){
      $plantilla.='<h3>Duración del contrato</h3>
        <h4>Séptima:</h4> La duración del presente contrato se extenderá desde <b>'.$desde.'</b>, hasta <b>'.$hasta.'</b>. 
        ';
    }else{
      $plantilla.='<h3>Periodo de prueba</h3>
        <h4>Séptima:</h4> EL TRABAJADOR estará sujeto a un periodo de prueba de 90 días, de conformidad con lo establecido en el Art. 15 del Código del Trabajo.
        <h3>Duración del contrato</h3>';
    }

    if(utf8_encode($title) == "CONTRATO DE TRABAJO TEMPORAL"){
      $plantilla.='<h4>Octavo:</h4> La duración del presente contrato se extenderá desde <b>'.$desde.'</b>, hasta <b>'.$hasta.'</b>.';
    }

    if(utf8_encode($title) == "CONTRATO DE TRABAJO INDEFINIDO" || utf8_encode($title) == "CONTRATO DE TRABAJO INDEFINIDO BONIFICADO"){
      $plantilla.='<h4>Octavo:</h4> El presente contrato es de duración indeterminada, sujetándose para su extinción a lo dispuesto en la legislación laboral.';
    }   


    $plantilla.='<h4>Obligaciones del trabajador:</h4>';

    if(utf8_encode($title) == "CONTRATO DE TRABAJO EN PRÁCTICAS"){
      $plantilla.='<h4>Octava:</h4>';
    }else{
      $plantilla.='<h4>Novena:</h4>';
    }

    $plantilla.='EL TRABAJADOR se compromete a cumplir sus obligaciones con lealtad y eficiencia, aplicando para tal fin toda su experiencia y capacidad, y velando por los intereses de EL EMPLEADOR, sus asociados y/o clientes. Esta obligación subsistirá aun después de terminada la relación laboral y su incumplimiento genera la correspondiente responsabilidad por daños y perjuicios.
        Asimismo, EL TRABAJADOR se compromete a someterse a los exámenes médicos de salud que EL EMPLEADOR le indique. 
        En señal de conformidad, las partes suscriben este documento en la ciudad de <b>Guayaquil</b>, con fecha <b>'.substr($empleado[0]->created_at,0, 8).'</b>.

        <div class="firmas-contrato">
          <div class="firmas-contrato-caja1" align="left">
            <h3><span></span></h3>
            <h4>EL EMPLEADOR</h4>
          </div>
        
          <div class="firmas-contrato-caja2" align="left">
            <h3><span></span></h3>
            <h4>TRABAJADOR</h4>
          </div>
        </div>
      </span>
    </div>
        </main>
  
      </body>';
 return $plantilla;
}

// ---------------------------------------------------

