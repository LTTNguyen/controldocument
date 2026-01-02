"use strict";

Carga()
const email = $("#email").val();

if(email == ""){
    $('#submit').css("background-color", "grey");
    $('#submit').prop('disabled',true);
    $('#email').val('NO MAIL DEFINED');
}

function Carga()
{
    let calidad = $('#calidad').html();
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('cambiaclaves')
    .addEventListener('click', openNav);
});
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('close')
    .addEventListener('click', closeNav);
});
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('inferrores')
    .addEventListener('click', openNav1);
});
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('closebtn')
    .addEventListener('click', closeNav1);
});
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('inferrores')
    .addEventListener('click', openNav1);
});
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('aprobacion')
    .addEventListener('click', openNav2);
});
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('close2')
    .addEventListener('click', closeNav2);
});
function openNav() {
  document.getElementById("mySidepanel").style.width = "250px";
  document.getElementById("mySidepanel").style.height = "auto";
}

/* Set the width of the sidebar to 0 (hide it) */
function closeNav() {
  document.getElementById("mySidepanel").style.width = "0";
}

function openNav1() {
  document.getElementById("mySidepanel1").style.width = "400px";
  $("#mySidepanel1").css({height: "auto"});
}
function openNav2() {
  document.getElementById("mySidepanel2").style.width = "400px";
  $("#mySidepanel1").css({height: "auto"});
}
/* Set the width of the sidebar to 0 (hide it) */
function closeNav1() {
  document.getElementById("mySidepanel1").style.width = "0";
}
function closeNav2() {
  document.getElementById("mySidepanel2").style.width = "0";
}
$( "form" ).on( "submit", function(e) { /*Cuando se presiona "submit" ejecuta el codigo de abajo*/
if (confirm("Desea enviar este informe?")){
    let dataString = $(this).serialize();

    $.ajax({ 

      type: "POST", 

      url: "modulos/guardar_informe.php",

      data: dataString,

      success: function () { /*Mensaje de confirmacion*/
        let x = document.getElementById("snackbar");
            x.classList.add("show");
            x.style.backgroundColor = '#3DE921';
            x.innerHTML = "Informe Enviado Correctamente";
            setTimeout(function(){ x.className = x.className.replace("show", "");}, 3000);
            document.getElementById("informe").reset();
            closeNav1();
      },
      error: function(){
        alert('Hubo un error al enviar su Informe... Comunicarse con Administrador');
      }

    });
};
    e.preventDefault();
    return false; /*Previene que los datos aparescan en la url*/
  });

