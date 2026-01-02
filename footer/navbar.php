<?php
    $quality = $_SESSION["quality"];
    $user_id = $_SESSION["user_id"];
    $rut_trab = $_SESSION['rut_trab'];
    $email = $_SESSION['email'];
?>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="funciones/userEdit.js"></script>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="bootstrap-icons/font/bootstrap-icons.css">
    <script src="jQuery/jquery.min.js" crossorigin="anonymous"></script>
    <title>Menú Principal - Control Documental</title>
    <link rel="icon" type="image/x-icon" href="../images/logo_andes.ico">
</head>

<body>
    <header>

        <div class="logo-container">
            <input type="checkbox" name="" id="check">

            <div class="container">
                <h2 class="logo">Control Documental</h2>
             </div>
            <div class="nav-btn">
                <div class="nav-links">
                    <ul>
                        <li class="nav-link" id="nav-addon">
                            <a href="#">Gestión<i class="fas fa-caret-down"></i></a>
                            <div class="dropdown">
                                <ul>
                                    <li class="dropdown-link">
                                    <a href="#">Principal<i class="fas fa-caret-down"></i></a>
                                        <div class="dropdown second">
                                            <ul>
                                                <li class="dropdown-link">
                                                    <a href="" target="">Menú Muestra 1</a>
                                                </li>
                                                <div class="arrow"></div>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="dropdown-link">
                                        <a href="#">Sub Menú<i class="fas fa-caret-down"></i></a>
                                        <div class="dropdown second">
                                            <ul>
                                                <li class="dropdown-link">
                                                    <a href="" target="">Sub Menú Muestra 1</a>
                                                </li>
                                                <div class="arrow"></div>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="dropdown-link">
                                        <a href="" target="">Menú Principal 1<i class="fas fa-caret-down"></i></a>
                                    </li>
                                    <li class="dropdown-link">
                                        <a href="" target="">Menú Principal 2<i class="fas fa-caret-down"></i></a>
                                    </li>
                                    <div class="arrow"></div>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="nav-links">
                    <ul>
                        <li class="nav-link" id="nav-addon">
                            <a href="#">Configuración<i class="fas fa-caret-down"></i></a>
                            <div class="dropdown">
                                <ul>
                                    <li class="dropdown-link">
                                        <a href="#">Módulos de Sistema<i class="fas fa-caret-down"></i></a>
                                    </li>
                                    <li class="dropdown-link">
                                        <a href="#">Administración de Permisos<i class="fas fa-caret-down"></i></a>
                                    </li>
                                    <li class="dropdown-link">
                                        <a href="#">Seguridad<i class="fas fa-caret-down"></i></a>
                                    </li>
                                    <li class="dropdown-link">
                                        <a href="#">Sistema<i class="fas fa-caret-down"></i></a>
                                        <div class="dropdown second">
                                            <ul>
                                                <li class="dropdown-link">
                                                    <a href="" target="">Roles</a>
                                                </li>
                                                <li class="dropdown-link">
                                                    <a href="" target="">Tipos de Documentación</a>
                                                </li>
                                                <li class="dropdown-link">
                                                    <a href="" target="">Control</a>
                                                </li>
                                                <div class="arrow"></div>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <div class="arrow"></div>
                    </ul>
                </div>
            </div>

            <div class="hamburger-menu-container">
                <div class="hamburger-menu">
                    <div></div>
                </div>
            </div>


        <button class="openbtn bi bi-person-gear" id="cambiaclaves" title="Cambiar Claves y datos Personales"></button>
            <div id="mySidepanel" class="sidepanel">
                <div class="titulos">
                <a href="javascript:void(0)" class="closebtn" id="close">&times;</a>
                 <span>Usuario: <p id="iniciales"><?php echo $user_id; ?></p></span>
                    <br>
                 <span>Calidad: <p id="calidad"><?php echo $quality; ?></p></span>
                    <br>
                 <span>RUT: <p id="rut"><?php echo $rut_trab; ?></p></span>
                </div>
                <a href="" target="">Cambiar Datos Personales</a>
                <a href="logout.php" class="close">Cerrar Sesión</a>
            </div>
        
        <button class="openbtn bi bi-envelope-exclamation-fill" id="inferrores" title="Informar errores del Sistema"></button>
            <div id="mySidepanel1" class="sidepanel">
                <a href="javascript:void(0)" class="closebtn" id="closebtn">&times;</a>
                <div class="titulos">
                    <form id="informe" action=""></form>
                        <table class="table table-dark">
                            <tr><label for="usuario">Usuario:</label>
                                <input form="informe" type="text" id="usuario" name="usuario" value="<?php echo $user_id; ?>" disabled autocomplete="off">
                            </tr>
                            <tr>
                                <th><label for="nombre">Nombre</label>
                                <input form="informe" type="text" id="nombre" name="nombre" placeholder="Su nombre.." required autocomplete="off">
                                </th>
                            </tr>
                            <tr>
                                <th><label for="lname">Apellido</label>
                                <input form="informe" type="text" id="lname" name="apellido" placeholder="Su apellido.." required autocomplete="off">
                                </th>
                            </tr>
                            <tr>
                                <th><label for="lname">Correo Electrónico</label>
                                <input form="informe" type="email" id="email" name="email" value="<?php echo $email; ?>" required disabled>
                                </th>
                            </tr>
                            <tr>
                                <th><label for="detalle">Detalle del Error</label>
                                <select form="informe" id="detalle" name="detalle" required>
                                </select>
                                </th>
                            </tr>
                            <tr>
                                <th><label for="descripcion">Descripción Breve (MÁXIMO 200 caracteres) </label>
                                <textarea  class="informetexto" form="informe" id="descripcion" maxlength="200" name="descripcion" placeholder="Detalle su problema..." required></textarea>
                                </th>
                            </tr>
                            <tr>
                                <th><input form="informe" type="submit" id="submit" class="btn btn-warning" value="Enviar Reporte"></th>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>

    <button class="openbtn bi bi-triangle" id="aprobacion" title="Solicitudes Pendientes">No Info</button>
            <div id="mySidepanel2" class="sidepanel">
                <a href="javascript:void(0)" class="closebtn" id="close2">&times;</a>
                
            </div>

    </header>
    <main>
        <section>
            <div class="overlay"></div>
        </section>
    </main>
<div id="snackbar"></div>
</body>
<script src="footer/nav.js"></script>
</html>
