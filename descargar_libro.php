<?php
require 'conexion.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Incrementar el contador de descargas
    $queryIncrementar = "UPDATE libros SET descargas = descargas + 1 WHERE id = ?";
    $stmtIncrementar = $conexion->prepare($queryIncrementar);
    $stmtIncrementar->bind_param("i", $id);
    $stmtIncrementar->execute();
    $stmtIncrementar->close();

    // Obtener la ruta del archivo PDF
    $stmt = $conexion->prepare("SELECT archivo_pdf FROM libros WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($archivo_pdf);

    if ($stmt->fetch()) {
        if (file_exists($archivo_pdf)) {
            header("Content-Type: application/pdf");
            header("Content-Disposition: attachment; filename=\"" . basename($archivo_pdf) . "\"");
            header("Content-Length: " . filesize($archivo_pdf));
            readfile($archivo_pdf);  // Descarga el archivo PDF
        } else {
            echo "El archivo PDF no se encuentra.";
        }
    } else {
        echo "Libro no encontrado.";
    }

    $stmt->close();
} else {
    echo "ID de libro no especificado.";
}

$conexion->close();
?>
