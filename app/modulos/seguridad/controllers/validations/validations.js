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


  onClick = () => {
    document.getElementById("form").reset();
    window.scroll(0, 0);
    document.getElementById('username').focus();
    document.getElementById('repeatPassword').className = "form-control"
    document.getElementById('password').className = "form-control"
    $('#borrado').toast('show')
    
}

onSubmit = (event) => {
  event.preventDefault()

  if(document.getElementById('repeatPassword').value == document.getElementById('password').value){
      document.getElementById('form').submit();
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

function esAfiliado(input,tipoAfiliacion){
// var tempValue = input.value;
if(input.value == "si"){     
  document.getElementById(tipoAfiliacion).disabled = false;
  document.getElementById(tipoAfiliacion).focus();
}
if(input.value == "no"){
  document.getElementById(tipoAfiliacion).disabled = true;
}
}