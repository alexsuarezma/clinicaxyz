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