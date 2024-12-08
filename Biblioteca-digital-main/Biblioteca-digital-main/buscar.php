<?php
require 'conexion.php';

$q = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($q === '') {
   
    $query = "SELECT id, titulo, Portada, categoria FROM libros";
    $stmt = $conexion->prepare($query);
} else {
    
    $query = "SELECT id, titulo, Portada, categoria FROM libros 
              WHERE titulo LIKE ? OR categoria LIKE ?";
    $stmt = $conexion->prepare($query);
    $q = "%$q%";
    $stmt->bind_param("ss", $q, $q);
}

$stmt->execute();
$result = $stmt->get_result();

$libros = [];
while ($row = $result->fetch_assoc()) {
    $libros[] = $row;
}

echo json_encode($libros);

$stmt->close();
$conexion->close();
?>
