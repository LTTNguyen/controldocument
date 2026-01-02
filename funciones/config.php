<?php
date_default_timezone_set('Chile/Continental');
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
/* DEFINICION USO EXCLUSIVO SERVIDOR TYM */
/* define('DB_USERNAME', 'adminer');*/
/* define('DB_PASSWORD', 'Tym2023$n');*/
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'quz@*W7Yaxb9[sUU');
define('DB_NAME', 'gestion_documental');
define('DB_CHARSET', 'utf8mb4');

/* Attempt to connect to MySQL database */
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
mysqli_set_charset($conn, DB_CHARSET);
 
// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
