<?php
$host = '127.0.0.1:3307';
$user = 'root';
$password = '';
$dbname = 'biblioteca';


$conexion = new mysqli($host, $user, $password, $dbname);


if ($conexion->connect_error) {
    die('Error en la conexión: ' . $conexion->connect_error);
}
?>
