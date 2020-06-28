$(document).ready(function()
{
$("#inlineRadio1").click(function () {
  document.getElementById("radio-hijos").style.display= "block";
  });
$("#inlineRadio2").click(function () {	 
  document.getElementById("radio-hijos").style.display= "none";
  });
});

function soloNumeros(e){
key=e.keyCode||e.which;
teclado=String.fromCharCode(key);
numero="0123456789";
especiales="8-37-38-46";
teclado_especial=false;
  for(var i in especiales){
    if(key==especiales[i]){
      teclado_especial=true;
    }
  }
  if (numero.indexOf(teclado)==-1 && !teclado_especial) {
    return false;
  }
} 

function soloMeses(input){
  var tempValue = input.value;
    if(tempValue >= 0 && tempValue <= 11){
      input.className = "form-control is-valid"
    }else{
      input.className = input.className+" is-invalid"
      input.value = "";
      input.focus();
    }
}


function isMedic(input,especialidad){
  var tempValue = input.value;
    if(tempValue == 2){     
      document.getElementById(especialidad).disabled = false;
      document.getElementById(especialidad).className = "custom-select is-valid";
      document.getElementById(especialidad).focus();
    }else{
      document.getElementById(especialidad).disabled = true;
      document.getElementById(especialidad).className = "custom-select"
    }
}


function filterFloat(evt,input){
  // Barraespaciadora = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
  var key = window.Event ? evt.which : evt.keyCode;    
  var chark = String.fromCharCode(key);
  var tempValue = input.value+chark;
  if(key >= 48 && key <= 57){
      if(filter(tempValue)=== false){
          return false;
      }else{       
          return true;
      }
  }else{
        if(key == 8 || key == 13 || key == 0) {     
            return true;              
        }else if(key == 46){
              if(filter(tempValue)=== false){
                  return false;
              }else{       
                  return true;
              }
        }else{
            return false;
        }
  }
}

function filter(__val__){
  var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
  if(preg.test(__val__) === true){
      return true;
  }else{
     return false;
  }
  
}

function soloLetras(e){
key=e.keyCode || e.which;
  teclado=String.fromCharCode(key).toLowerCase();
  letras=" abcdefghijklmnñopqrstuvwxyz´áéíóú";
  especiales="8-37-38-46-164";
  teclado_especial=false;
  for (var i in especiales) {
    if (key==especiales[i]) {
      teclado_especial=true;
      break;
    }
  }
  if (letras.indexOf(teclado)==-1 && !teclado_especial) {
    return false;
  }
}
function validarCelular(idTelefono){
var telefono = document.getElementById(`${idTelefono}`).value;
var primer;
primer = telefono.substr(0,1);

if(primer != 0){
  alert("El celular debe comenzar en 0");
  document.getElementById(`${idTelefono}`).className = document.getElementById(`${idTelefono}`).className+" is-invalid"
  document.getElementById(`${idTelefono}`).value="";
  document.getElementById(`${idTelefono}`).focus();
}else{
    if(telefono.length < 10){
    alert("Debe ser un numero celular de 10 digitos!");
    document.getElementById(`${idTelefono}`).className = document.getElementById(`${idTelefono}`).className+" is-invalid"
    document.getElementById(`${idTelefono}`).value="";
    document.getElementById(`${idTelefono}`).focus();
  } else{
    document.getElementById(`${idTelefono}`).className = "form-control is-valid"
    // The next input focus
    // document.getElementById(`${idTelefono}`).focus();
  }
}              
}

function validarTelefono(idTelefono){
var telefono = document.getElementById(`${idTelefono}`).value;
    if(telefono.length < 7){
    alert("Debe ser un numero telefonico debe ser de 7 digitos!");
    document.getElementById(`${idTelefono}`).className = document.getElementById(`${idTelefono}`).className+" is-invalid"
    document.getElementById(`${idTelefono}`).value="";
    document.getElementById(`${idTelefono}`).focus();
  } else{
    document.getElementById(`${idTelefono}`).className = "form-control is-valid"
    // The next input focus
    // document.getElementById(`${idTelefono}`).focus();
  }
}


function verificarCedula(){
const cedula = document.getElementById("validationServer01").value;
    var numero = 0;
    var suma = 0;
    var digitoVerficador = cedula.substr(9,1);

    for (var j=0;j <= cedula.length-1; j++) {

    }
      if (j==10) {
          suma=0;
          for (var i=0; i<cedula.length-1; i++) {
              numero = cedula.substr(i,1);
                if(i%2==0){
                  //digito impar
                  numero = numero * 2;
                }else{
                  //digito par
                  numero = numero * 1;
                }           
                
              if (numero > 9) {numero = numero - 9;}
              suma+=numero;
              delete numero;
          }    
          suma = suma%10;
        if (suma==0) {
              if (suma == digitoVerficador) {
                    //cedula valida
                    document.getElementById("validationServer01").className = "form-control is-valid"
                    document.getElementById("validationServer02").focus();
                }else{
                    //cedula no valida                        
                    document.getElementById("validationServer01").className = document.getElementById("validationServer01").className+" is-invalid"
                    document.getElementById("validationServer01").value="";
                    document.getElementById("validationServer01").focus();
                }
          }else{
            suma = 10-suma;
              if (suma == digitoVerficador) {
                //cedula valida
                document.getElementById("validationServer01").className = "form-control is-valid"
                document.getElementById("validationServer02").focus();
              }else{
                //cedula no valida
                document.getElementById("validationServer01").className = document.getElementById("validationServer01").className+" is-invalid"
                document.getElementById("validationServer01").value="";
                document.getElementById("validationServer01").focus();
              }
        }
      }else {
        document.getElementById("validationServer01").className = document.getElementById("validationServer01").className+" is-invalid"
        document.getElementById("validationServer01").value="";
        document.getElementById("validationServer01").focus();
      }

}

function validarExtdoc()
{
    var archivoInput = document.getElementById('fileDocument');
    var archivoRuta = archivoInput.value;
    var extPermitidas = /(.pdf|.PDF)$/i;
    if(!extPermitidas.exec(archivoRuta)){
        alert('Asegurese de haber seleccionado un documento con extension ".pdf o .PDF" ');
        archivoInput.value = '';
        return false;
    }
    // else
    // {
    //     //PRevio del PDF
    //     if (archivoInput.files && archivoInput.files[0]) 
    //     {
    //         var visor = new FileReader();
    //         visor.onload = function(e) 
    //         {
    //             document.getElementById('visorDocument').innerHTML = 
    //             '<embed src="'+e.target.result+'" width="200" height="200" />';
    //         };
    //         visor.readAsDataURL(archivoInput.files[0]);
    //     }
    // }
}


$(document).ready(function(){
  var i = 1;
  var academico = 1;
  var laboral = 1;

  $('#add').click(function () {
      i++;
      $('#dynamic_field').append(`<div class="form-row" id="row${i}">`+
                                      '<div class="col-md-3 mb-3">'+
                                          '<label for="validationServer04">Nombres</label>'+
                                          `<input type="text" name="nombreHijo${i}" class="form-control" onkeypress="return soloLetras(event)" id="validationServer14" autocomplete="off" required>`+
                                      '</div>'+
                                      '<div class="col-md-3 mb-3">'+
                                          '<label for="validationServer04">Apellidos</label>'+
                                          `<input type="text" name="apellidoHijo${i}" class="form-control" onkeypress="return soloLetras(event)" id="validationServer15" autocomplete="off" required>`+
                                      '</div>'+
                                      '<div class="col-md-2 mb-3">'+
                                          '<label for="validationServer04">Años</label>'+
                                          `<input type="text" name="anosHijo${i}" class="form-control" onkeypress="return soloNumeros(event)" maxlength="2" id="validationServer16" autocomplete="off" required>`+
                                      '</div>'+
                                      '<div class="col-md-2 mb-3">'+
                                          '<label for="validationServer04">Meses</label>'+
                                          `<input type="text" name="mesesHijo${i}" onchange="soloMeses(this);" class="form-control" onkeypress="return soloNumeros(event)" maxlength="2" id="validationServer17" autocomplete="off" required>`+
                                          '<div class="invalid-feedback">'+
                                              'Debes colocar un rango de 12 meses.'+
                                          '</div>'+
                                          '<div class="valid-feedback">'+
                                              'Correcto.'+
                                          '</div> '+
                                      '</div>'+
                                  '</div>');
      document.getElementById("numeroHijos").value = i;
  });


  $('#add-aspirante').click(function () {
      academico++;
      $('#dynamic_field_academico').append(`<div class="form-row" id="row-academico${academico}">`+
                                              '<div class="form-row">'+
                                                '<div class="col-md-12 mb-3">'+
                                                  '<label for="validationServer08">Titulo / Profesión</label>'+
                                                  `<input type="text" name="titulo${academico}" class="form-control" onkeypress="return soloLetras(event)" id="validationServer32" autocomplete="off" required>`+
                                                '</div>'+
                                                '<div class="col-md-12 mb-3">'+
                                                    '<label for="validationServer11">Institución</label>'+
                                                    `<input type="text" name="institucion${academico}" class="form-control" onkeypress="return soloLetras(event)" id="validationServer33" autocomplete="off" required>`+
                                                  '</div>'+
                                              '</div>'+
                                              '<div class="form-row">'+
                                                '<div class="col-md-10 ml-2 mb-3">'+
                                                  '<label for="validationServer16">Año de ingreso</label>'+
                                                  `<input type="date" name="anoIngreso${academico}" class="form-control" id="validationServer35" required>`+
                                                '</div>'+
                                                '<div class="col-md-10 ml-2 mb-3">'+
                                                  '<label for="validationServer16">Año de Egreso</label>'+
                                                  `<input type="date" name="anoEgreso${academico}" class="form-control" id="validationServer36" required>`+
                                              '</div>'+
                                            '</div>');
      document.getElementById("antecedentesAcadem").value = academico;
  });

  $('#add-experiencia').click(function () {
    laboral++;
    $('#dynamic_field_experiencia').append(`<div class="form-row" id="row-experiencia${laboral}">`+
                                            '<div class="col-md-4 mb-3">'+
                                          '<label for="validationServer08">Empresa</label>'+
                                          `<input type="text" name="empresa${laboral}" class="form-control" onkeypress="return soloLetras(event)" id="validationServer32" autocomplete="off" required>`+
                                        '</div>'+
                                        '<div class="col-md-5 mb-3">'+
                                          '<label for="validationServer16">Dirección</label>'+
                                          `<input type="text" name="direccion${laboral}" class="form-control" id="validationServer35" required>`+
                                        '</div>'+
                                        '<div class="col-md-3 mb-3">'+
                                          '<label for="validationServer16">Cargo</label>'+
                                          `<input type="text" name="cargo${laboral}" class="form-control" id="validationServer36" onkeypress="return soloLetras(event)" required>`+
                                        '</div>'+
                                        '<div class="col-md-2 mb-3">'+
                                        '<label for="validationServer16">Años</label>'+
                                        `<input type="text" name="ano${laboral}" class="form-control" onkeypress="return soloNumeros(event)" maxlength="2" id="validationServer36" required>`+
                                      '</div>'+
                                      '<div class="col-md-2 mb-3">'+
                                        '<label for="validationServer16">Meses</label>'+
                                        `<input type="text" name="meses${laboral}" onchange="soloMeses(this);" class="form-control" onkeypress="return soloNumeros(event)" maxlength="2" id="validationServer36" required>`+
                                        '<div class="invalid-feedback">'+
                                            'Debes colocar un rango de 12 meses.'+
                                        '</div>'+
                                        '<div class="valid-feedback">'+
                                            'Correcto.'+
                                        '</div> '+
                                      '</div>'+
                                        '<div class="col-md-5 mb-3 mr-3">'+
                                          '<label for="validationServer11">Naturaleza de la empresa</label>'+
                                          `<input type="text" name="naturalezaEmpresa${laboral}" class="form-control" onkeypress="return soloLetras(event)" id="validationServer33" autocomplete="off" required>`+
                                        '</div>');
    document.getElementById("experienciaLaboral").value = laboral;
});

  $('#remove-experiencia').click(function () {
    if(laboral == 1){

    }else{
        $('#row-experiencia'+ laboral).remove();
        laboral--;
        document.getElementById("experienciaLaboral").value = laboral;
    }
  }); 

  $('#remove-academico').click(function () {
    if(academico == 1){

    }else{
        $('#row-academico'+ academico).remove();
        academico--;
        document.getElementById("antecedentesAcadem").value = academico;
    }
  }); 

  $('#remove').click(function () {
      if(i == 1){

      }else{
          $('#row'+ i).remove();
          i--;
          document.getElementById("numeroHijos").value = i;
      }
  });      
})