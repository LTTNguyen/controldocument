<!DOCTYPE html>
<html lang="es-ES">
<head>
    <meta http-equiv="Content-Security-Policy" content="style-src 'self' https://fonts.googleapis.com https://cdn.jsdelivr.net http://127.0.0.1 'unsafe-inline';">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Ingreso</title>
    <link rel="stylesheet" type="text/css" href="css/nav.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <script src="jQuery/jquery.min.js"></script>
</head>
<body>
<header>

<div class="titulos2">
  <h3>Gestión Documental Inicio de Sesión</h3>
</div>
<div class="Div9">
    <div class="login-container" align="center">
    <form action="" autocomplete="off" id="form">
      <label for="rut">RUT:</label>
      <input type="text" class="roundedcorners" id="rut" name="rut">
      <input type="password" class="roundedcorners" id="passwrd" placeholder="Clave" name="passwrd" autocomplete="passwrd">
      <input type="checkbox" class="roundedcorners" id="passwrd1">
      <label for="passwrd">Mostrar Clave</label>
      <button type="button" class="btn btn-outline-primary" id="verificar">Ingresar</button>
    </form>
  </div>
</div>

</header>

<div class="clave hidden" id="clave"></div>
<div id="snackbar"></div>

<div class="DivLogo" align="center">
<img src="images/andes_logo.png" alt="Logo" class="logo">
<script src="funciones/inicio.js"></script>
</div>
</body>
</html>
