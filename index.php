<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "funciones/config.php";
$sql = "SELECT user_id FROM user WHERE quality = ?";

if($stmt = mysqli_prepare($conn, $sql)){
	mysqli_stmt_bind_param($stmt, "s", $param_quality);
	$param_quality = "ADMIN";

	if(mysqli_stmt_execute($stmt)){
		mysqli_stmt_store_result($stmt);

		if(mysqli_stmt_num_rows($stmt) >= 1){
			header("location: login.php");
		} else{
			$sql1 = "INSERT INTO user(rut_trab, user_id, user_name, last_name, email, active, quality, pass) VALUES (?,?,?,?,?,?,?,?)";
			$param_rut = "763138399";
			$param_user_id = "ADM01";
			$param_user_name = "Administrador";
			$param_user_last_name = "Administrador";
			$param_email = "vpavez@tymelectricos.cl";
			$param_active = "1";
			$param_quality = "ADMIN";
			$passAdmin = "tym123456";
			$HashpassAdmin = password_hash($passAdmin, PASSWORD_DEFAULT);
			
			if($stmt = mysqli_prepare($conn, $sql1)){
			mysqli_stmt_bind_param($stmt, "ssssssss", $param_rut, $param_user_id, $param_user_name, $param_user_last_name, $param_email, $param_active, $param_quality, $HashpassAdmin);
			mysqli_stmt_execute($stmt);
			print_r($stmt);
			mysqli_stmt_close($stmt);

			}

			$queryProgramas = "SELECT * FROM modules";
			$guardaPermisos = "INSERT INTO user_movement(rut_trab,module,permit) VALUES (?,?,?)";
			$resultProgramas = $conn->query($queryProgramas);
			while($row = $resultProgramas->fetch_assoc()){
                $param_module = $row['module'];
                $param_permit = "1";
                if($stmt = mysqli_prepare($conn, $guardaPermisos)){
                mysqli_stmt_bind_param($stmt, "sss", $param_rut, $param_module, $param_permit);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                }
            }
		}
		echo "<h1>Usuario Administrador (POR DEFECTO) Creado Satisfactoriamente</h1>";
		echo "<br>";
		echo "<a href='login.php'>Ingresar Al Sistema</a>";
	}
}


?>