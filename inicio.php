<!DOCTYPE html>
<?php
session_start();
$newDate = "";
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){

    header("location: index.php");
    exit;
  }else{
    $user_id = $_SESSION["user_id"];
    $quality = $_SESSION["quality"];
    $rut_trab = $_SESSION["rut_trab"];
    require_once "funciones/config.php";
    require_once "footer/navbar.php";
    if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
    }
    $token = $_SESSION['token'];
    }
?>
<html lang="es">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Inicio</title>
<link rel="stylesheet" href="css/nav.css">
<body>

</body>
</head>
</html>
