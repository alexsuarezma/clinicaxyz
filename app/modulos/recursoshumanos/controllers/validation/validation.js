
function verificarCedula(){
  const cedula = document.getElementById("validationServer01").value;
  const numero;
  const suma;
  const digitoVerficador = cedula.substr(9,1);

  for (var j=0;j <= cedula.length-1; j++) {}
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
                  document.getElementById("validationServer01").className = document.getElementById("validationServer01").className.replace(" is-invalid", "")
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
              document.getElementById("validationServer01").className = document.getElementById("validationServer01").className.replace(" is-invalid", "")
              document.getElementById("validationServer02").focus();
            }else{
              //cedula no valida
              document.getElementById("validationServer01").className = document.getElementById("validationServer01").className+" is-invalid"
              document.getElementById("validationServer01").value="";
              document.getElementById("validationServer01").focus();
            }
      }
    }else {
      alert("Error!. Ha ingresado una cedula menor a 10 digitos");
      document.getElementById("validationServer01").className = document.getElementById("validationServer01").className+" is-invalid"
      document.getElementById("validationServer01").value="";
      document.getElementById("validationServer01").focus();
    }
}

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
