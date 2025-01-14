<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'biblioteca';


$conexion = new mysqli($host, $user, $password, $dbname);


if ($conexion->connect_error) {
    die('Error en la conexión: ' . $conexion->connect_error);
}
?>
