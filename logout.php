<!DOCTYPE html>
<?php
session_start();
$_SESSION = array();
session_destroy();
?>
<html lang="es">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Cierre de Sesión</title>
<script src="js/is.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="css/styles.css">
<script language="javascript"><!--
window.moveTo(0,0);
window.resizeTo(screen.availWidth,screen.availHeight);
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
<body>
<div class="w3-center"><img class="WH50" src="images/andes_logo.png" alt=""></div>
<div class="col-12 w3-center">
	<h1>Sesión Terminada</h1>
	<p>Ha cerrado correctamente su sesión</p>
	<p>
		<a class="btn btn-success btn-lg" href="index.php"><i class="fa fa-user"></i>Volver al sistema?</a>
	</p>
</div>
</body>
</head>
</html>
