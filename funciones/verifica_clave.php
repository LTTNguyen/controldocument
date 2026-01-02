<?php
    include_once "../funciones/config.php";
?>
<?php
$recibe = file_get_contents('php://input');
$data = json_decode($recibe, true);
$value = array_values($data);
    $rut_trab = $value[0];
    $psw = $value[1];
    $permiso = array();
$hide = "hidden";

$stmt = $conn->prepare("SELECT rut_trab, pass, user_id, quality, email, active FROM user WHERE rut_trab = ?");
$stmt->bind_param("s", $rut_trab);
$stmt->execute();

$resultado = $stmt->get_result();
$datos = $resultado->fetch_assoc();

$encontrado = $resultado->num_rows;

if($encontrado == 1){
    $psw1 = $datos['pass'];
    $user_id = $datos['user_id'];
    $quality = $datos['quality'];
    $email = $datos['email'];
    $active = $datos['active'];

    if(password_verify($psw, $psw1)){
        session_start();
        $stmt = $conn->prepare("SELECT * FROM user_movement WHERE rut_trab = ?");
        $stmt->bind_param("s", $rut_trab);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if($resultado->num_rows >0){
        while ($row = $resultado->fetch_assoc()){
            $perms[] = array('module'=>$row['module'],'permit'=>$row['permit']);
        }
        }else{
            $perms[] = "";
        }
        
        // session variables
        $_SESSION["loggedin"] = true;
        $_SESSION["user_id"] = $user_id;
        $_SESSION["quality"] = $quality;
        $_SESSION["rut_trab"] = $rut_trab;
        $_SESSION['perms'] = $perms;
        $_SESSION['email'] = $email;
        unset($row);
        // Redirect user to welcome page
        $respuesta = 'goStart';
    }else{
        $respuesta = 'errorStart';
    }
}else{
    $respuesta = 'notFound';
}
echo json_encode(array('msg' => $respuesta));
$stmt->close();
?>
