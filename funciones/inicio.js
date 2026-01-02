"use strict";
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('passwrd1')
    .addEventListener('click', muestraclave);
});

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('verificar')
    .addEventListener('click', verificar);
});

function muestraclave() {
  var x = document.getElementById("passwrd");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

function buscarut() {
  document.getElementById('rut').value = document.getElementById('usuario').value;
  document.getElementById('passwrd').value = "";
}

function verificar(){
    var rut = document.getElementById('rut').value;
    var psw = document.getElementById('passwrd').value;
if (rut == '') {
    Mensaje(1);
    return;
}
if (psw == ''){
    Mensaje(2);
    return;
}
if (psw == ''||rut==''){
    Mensaje(4);
    return;
}

    const data = {
            rut_trabajador: document.querySelector('#rut').value,
            psw: document.querySelector('#passwrd').value
        }
    var url = "funciones/verifica_clave.php";
    var httpv = new XMLHttpRequest();
    httpv.open("POST", url, true);

    httpv.onreadystatechange = function() { 
        if(httpv.readyState == 4 && httpv.status == 200) {
            let myArr = JSON.parse(httpv.responseText);
            respuesta(myArr);
        }
    };
    var dataverificar = JSON.stringify(data);
    httpv.send(dataverificar);
}

function respuesta(dato){
    let respuesta = dato.msg;
    if (respuesta == "goStart"){
        window.open(("inicio.php"),"_self");
    }
    if(respuesta == "errorStart"){
        Mensaje(3);
        return;
    }
    if(respuesta == "notFound"){
        Mensaje(4);
        return;
    }
}

function Mensaje(id){
    $("#form :input").prop("disabled", true);
    let x = document.getElementById("snackbar");
        x.style.zIndex = "1000";

switch(id) {
    case 1:
        x.style.backgroundColor = '#F03F10';
        x.innerHTML = "DEBE Ingresar RUT Usuario";
        $('#rut').val('');
        $('#passwrd').val('');
        x.classList.add("show");
        setTimeout(function(){ x.className = x.className.replace("show", ""); $("#form :input").prop("disabled", false);}, 2000);
        break;
    case 2:
        x.style.backgroundColor = '#F03F10';
        x.innerHTML = "DEBE Ingresar Clave!";
        $('#rut').val('');
        $('#passwrd').val('');
        x.classList.add("show");
        setTimeout(function(){ x.className = x.className.replace("show", ""); $("#form :input").prop("disabled", false);}, 2000);
        break;
    case 3:
        x.style.backgroundColor = '#EE1461';
        x.innerHTML = "Usuario NO EXISTE o Clave Erronea";
        $('#rut').val('');
        $('#passwrd').val('');
        x.classList.add("show");
        setTimeout(function(){ x.className = x.className.replace("show", ""); $("#form :input").prop("disabled", false);}, 2000);
        break;
    case 4:
        x.style.backgroundColor = '#F56969';
        x.innerHTML = "No se encuentran datos de Inicio de Sesión";
        $('#rut').val('');
        $('#passwrd').val('');
        x.classList.add("show");
        setTimeout(function(){ x.className = x.className.replace("show", ""); $("#form :input").prop("disabled", false);}, 2000);
        break;
    }
}
    
