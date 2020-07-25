<?php
function getPlantilla($empleado){
    $plantilla = '
    <body>
    <header class="clearfix">
      <div id="logo">
      <img src="../components/plantilla/clinicavitalia-01.png">
      </div>
      <h1>CONTRATO DE TRABAJO INDEFINIDO</h1>
      <div class="firmas-header">
        <div align="left" class="firmas-contrato-cajaheader1">
          <div id="project">
            <div><span>PROJECT</span> Website development</div>
            <div><span>CLIENT</span> John Doe</div>
            <div><span>ADDRESS</span> 796 Silver Harbour, TX 79273, US</div>
            <div><span>EMAIL</span> <a href="mailto:john@example.com">john@example.com</a></div>
            <div><span>DATE</span> August 17, 2015</div>
            <div><span>DUE DATE</span> September 17, 2015</div>
          </div>
        </div>
      
        <div align="left" class="firmas-contrato-cajaheader2">
          <div id="company" class="clearfix">
            <div>Company Name</div>
            <div>455 Foggy Heights,<br /> AZ 85004, US</div>
            <div>(602) 519-0450</div>
            <div><a href="mailto:company@example.com">company@example.com</a></div>
          </div>
         </div>
      </div>
      
    </header>
    <main>
<div class="contrato-redaccion">
  <span>Conste por el presente documento por duplicado, el contrato de trabajo que celebran; de una parte Clínica Vitalia SL con RUC N° 0968537341001  y domicilio en  _________ a  quien en adelante  se  denominará  EL  EMPLEADOR, el señor <b>'.$empleado[0]->nombres.'</b> <b>'.$empleado[0]->apellidos.'</b>, identificado con DNI  N° <b>'.$empleado[0]->id_empleados.'</b> a  quien en adelante  se  denominará  EL  TRABAJADOR.
    <h3>Declaran </h3> 
    Que reúnen los requisitos exigidos para la celebracion del presente cntrato y, en su consecuencia, acuerdan formalizando con arreglo a las siguientes:
    <h2>Clausulas</h2>
    <h3>Antecedentes:</h3>
    <h4>Primera:</h4>  EL  EMPLEADOR es una persona (natural o jurídica).
    <h3>Objeto del contrato</h3>
    <h4>Segunda:</h4> En virtud del presente contrato, EL EMPLEADOR contrata los servicios personales de EL TRABAJADOR, los mismos que se desarrollarán bajo subordinación a cambio de la remuneración convenida.
    <h4>Tercera:</h4> EL TRABAJADOR prestara sus servicios como <b>'.$empleado[0]->nombre_cargo.'</b>, incluido en el grupo profesional de <b>'.$empleado[0]->nombre_area.'</b>, para la realización de funciones de acuerdo con el sistema de clasificación profesional vigente en la clínica. 
    Las partes dejan expresa constancia de que la prestación de servicios es personal, no pudiendo EL TRABAJADOR ser reemplazado por tercera persona. En caso de que EL TRABAJADOR requiriese de la asistencia de un tercero, deberá comunicarlo a EL EMPLEADOR, quien decidirá si se admite la intervención del tercero.
    <h3>Jornada y horario de trabajo</h3>
    <h4>Cuarta:</h4> Las partes estipulan que la jornada laboral de EL TRABAJADOR será de <b>'.$empleado[0]->jornada.'</b> <b>Lunes</b> a <b>Viernes</b>, de <b>'.$empleado[0]->inicio.'</b> a <b>'.$empleado[0]->finalizacion.'</b>.
    Adicionalmente, las partes estipulan que EL TRABAJADOR tendrá un refrigerio de <b>00:30:00</b>. Dicho refrigerio no se encontrará dentro de la jornada de trabajo.  
    <h4>Quinta:</h4> Las partes convienen en que las remuneraciones por guardia que realice EL TRABAJADOR se otorgarán en función a la remuneración básica y según el horario en se realice dicha guardia, ascendiendo a: 10%, en caso de guardia diurna, 12% en caso de guardia diurna en domingos y feriados o por guardia nocturna y 15% en caso de guardia nocturna en domingos y feriados.
    Cabe acotar que en caso de que EL TRABAJADOR realice turnos de guardia nocturna tendrá derecho a gozar de un descanso post guardia.
    <h3>Remuneración</h3>
    <h4>Sexta:</h4> EL TRABAJADOR percibirá como contraprestación por sus servicios una remuneración mensual ascendente a <b>$ '.$empleado[0]->sueldo_base_cargo.'</b>, durante el tiempo que dure la relación laboral.
    Las ausencias injustificadas por parte de EL TRABAJADOR implicarán la pérdida de la remuneración en forma proporcional a la duración de dicha ausencia.
    <h3>Periodo de prueba</h3>
    <h4>Séptima:</h4> EL TRABAJADOR estará sujeto a un periodo de prueba de 90 días, de conformidad con lo establecido en el Art. 15 del Código del Trabajo.
    <h3>Duración del contrato</h3>
    <h4>Octavo:</h4> El presente contrato es de duración indeterminada, sujetándose para su extinción a lo dispuesto en la legislación laboral. 
    <h4>Obligaciones del trabajador:</h4>
    <h4>Novena:</h4> EL TRABAJADOR se compromete a cumplir sus obligaciones con lealtad y eficiencia, aplicando para tal fin toda su experiencia y capacidad, y velando por los intereses de EL EMPLEADOR, sus asociados y/o clientes. Esta obligación subsistirá aun después de terminada la relación laboral y su incumplimiento genera la correspondiente responsabilidad por daños y perjuicios.
    Asimismo, EL TRABAJADOR se compromete a someterse a los exámenes médicos de salud que EL EMPLEADOR le indique. 
    En señal de conformidad, las partes suscriben este documento en la ciudad de <b>Guayaquil</b>, con fecha <b>'.$empleado[0]->created_at.'</b>.

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
      <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
      </div>
    </main>
    <footer>
      Invoice was created on a computer and is valid without the signature and seal.
    </footer>
  </body>
    ';
 return $plantilla;
}