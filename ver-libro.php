<?php
require 'conexion.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

   
    $stmt = $conexion->prepare("SELECT titulo, autor, descripcion, Portada, archivo_pdf FROM libros WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($titulo, $autor, $descripcion, $portada, $archivo_pdf);

    if ($stmt->fetch()) {
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Ver Libro</title>
            <link rel="stylesheet" href="Estilos.css">
        </head>
        <body>
            <div class="libro-detalles">
                <div class="libro-imagen">
                    <img src="<?= $portada; ?>" alt="Portada del libro" class="libro-portada">
                </div>
                <div class="libro-info">
                    <h2><?= htmlspecialchars($titulo); ?></h2>
                    <p><strong>Autor:</strong> <?= htmlspecialchars($autor); ?></p>
                    <p><strong>Descripción:</strong> <?= nl2br(htmlspecialchars($descripcion)); ?></p>

                    <div class="botones">
                        <a href="leer_libro.php?id=<?= $id; ?>" target="_blank" class="btn leer-btn">Leer Libro</a>
                        <a href="descargar_libro.php?id=<?= $id; ?>" class="btn descargar-btn">Descargar PDF</a>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "<p>Libro no encontrado.</p>";
    }

    $stmt->close();
} else {
    echo "<p>ID no especificado.</p>";
}

$conexion->close();
?>
