const verificarCedula = (input) => {
    const cedula = input.value;
    var numero = 0;
    var suma = 0;
    var digitoVerficador = cedula.substr(9,1);

    if (cedula.length==10) {
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
                return true
            }else{
                //cedula no valida                        
                return false
            }
        }else{
            suma = 10-suma;
            if (suma == digitoVerficador) {
                //cedula valida
                return true
            }else{
                //cedula no valida
                return false
            }
        }
    }else {
        return false
    }
}

function validarCedula(input){
    const father = input.parentNode

    if (verificarCedula(input))
    {
        input.classList.add('border-gray-300')
        input.classList.remove('border-red-800')
        father.lastElementChild.classList.add("hidden")
    }else
    {
        input.value = ''
        input.classList.remove('border-gray-300')
        input.classList.add('border-red-800')
        father.lastElementChild.classList.remove("hidden")
    }
}

function onlyNumbers (e) {
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