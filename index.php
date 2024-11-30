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
    <script type="text/javascript" src="Js/main.js" defer></script>
</head>
<body>
    
<?php
require 'nav.php';

?>
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
