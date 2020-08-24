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

  
function validarEmail(input) {
  if (/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test(input.value)){
      input.className = "form-control is-valid";
  } else {
      input.className = "form-control is-invalid"
      input.value="";
      input.focus();
  }
}

function validarTelefono(input){
      if(input.value.length < 7){
      input.className = "form-control is-invalid"
      input.value="";
      input.focus();
    } else{
      input.className = "form-control is-valid"
    }
}


function validarCelular(input){
  var primer;
  primer = input.value.substr(0,1);
  
  if(primer != 0){
    input.className = "form-control is-invalid"
    input.value="";
    input.focus();
  }else{
      if(telefono.length < 10){
      input.className = "form-control is-invalid"
      input.value="";
      input.focus();
    } else{
      input.className = "form-control is-valid"
    }
  }              
}

  function verificarCedula(input){
    const cedula = input.value;
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
                    input.className = "form-control is-valid"
                    document.getElementById("name").focus();
                }else{
                    //cedula no valida                        
                    input.className = "form-control is-invalid"
                    input.value="";
                    input.focus();
                }
          }else{
            suma = 10-suma;
              if (suma == digitoVerficador) {
                //cedula valida
                input.className = "form-control is-valid"
                document.getElementById("name").focus();
              }else{
                //cedula no valida
                input.className = "form-control is-invalid"
                input.value="";
                input.focus();
              }
        }
      }else {
        input.className = "form-control is-invalid"
        input.value="";
        input.focus();
      }

}

  onClick = () => {
    document.getElementById("form").reset();
    window.scroll(0, 0);
    document.getElementById('username').focus();
    document.getElementById('repeatPassword').className = "form-control"
    document.getElementById('password').className = "form-control"
    document.getElementById('afiliaciones').style.display = "none";
    document.getElementById('afiliacionPublica').disabled = true;
    document.getElementById('afiliacionPrivada').disabled = true;
    $('#borrado').toast('show')
    
}

onSubmit = (event) => {
  event.preventDefault()

  if(document.getElementById('repeatPassword').value == document.getElementById('password').value){
      registrarPaciente();

  }else{
      document.getElementById('repeatPassword').className = "form-control is-invalid"
      document.getElementById('password').className = "form-control is-invalid"
      window.scroll(0, 0);
      document.getElementById('password').focus();
      $('#alert').toast('show')
  } 
}
function esDiscapacitado(input,carnet,discapacidad,grado){
// var tempValue = input.value;
if(input.value == "si"){     
  document.getElementById(carnet).disabled = false;
  document.getElementById(discapacidad).disabled = false;
  document.getElementById(grado).disabled = false;
  document.getElementById(carnet).focus();
}
if(input.value == "no"){
  document.getElementById(carnet).disabled = true;
  document.getElementById(discapacidad).disabled = true;
  document.getElementById(grado).disabled = true;
}
}

function esAfiliado(input,print){
  if(input.value == "si"){     
    document.getElementById(print).style.display = "block";
  }
  if(input.value == "no"){
    document.getElementById(print).style.display = "none";
    document.getElementById('privada').checked = false;
    document.getElementById('publica').checked = false;
    document.getElementById('afiliacionPublica').value = "";
    document.getElementById('afiliacionPublica').disabled = true;
    document.getElementById('afiliacionPrivada').value = "";
    document.getElementById('afiliacionPrivada').disabled = true;
  }
}

function afiliacion(input,box){
  if(input.checked = true){     
    document.getElementById(box).disabled = false;
  }else{
    document.getElementById(box).disabled = true;
  }
}