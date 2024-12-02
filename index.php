<?php
require 'conexion.php';

$query = "SELECT id, titulo, Portada FROM libros";
$result = $conexion->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Virtual</title>
    <link rel="stylesheet" href="Estilos.css">

</head>
<body>
    
<nav class="navbar">
    <div class="nav-container">
        <h1 class="logo">Biblioteca Virtual</h1>
        <ul class="nav-links">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="subir-libro.php">Subir Libro</a></li>
            <li><a href="#">Acerca de</a></li>
            <li><a href="#">Contacto</a></li>
        </ul>
    </div>
</nav>
   <div class="libros-container">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="libro">
            <a href="ver-libro.php?id=<?= $row['id']; ?>">
                <img src="<?= $row['Portada']; ?>" alt="Portada del libro" class="libro-portada">
                <h3 class="libro-titulo"><?= htmlspecialchars($row['titulo']); ?></h3>
            </a>
        </div>
    <?php endwhile; ?>
</div>


</body>
</html>
