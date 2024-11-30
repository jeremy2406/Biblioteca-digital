<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $descripcion = $_POST['descripcion'];
    $archivo = $_FILES['archivo'];
    $portada = $_FILES['portada'];

    if ($archivo['error'] === UPLOAD_ERR_OK && $portada['error'] === UPLOAD_ERR_OK) {
        // Subir archivo PDF
        $nombreArchivo = basename($archivo['name']);
        $rutaPDF = 'Assets/PDF/' . $nombreArchivo;
        if (move_uploaded_file($archivo['tmp_name'], $rutaPDF)) {
            echo "PDF subido correctamente.<br>";
        } else {
            echo "Error al subir el archivo PDF.<br>";
        }

        // Subir imagen de portada
        $nombrePortada = basename($portada['name']);
        $rutaPortada = 'Assets/Portadas/' . $nombrePortada;
        if (move_uploaded_file($portada['tmp_name'], $rutaPortada)) {
            echo "Portada subida correctamente.<br>";
        } else {
            echo "Error al subir la portada.<br>";
        }

        // Guardar en la base de datos
        $stmt = $conexion->prepare("INSERT INTO libros (titulo, autor, descripcion, archivo_pdf, Portada) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $titulo, $autor, $descripcion, $rutaPDF, $rutaPortada);

        if ($stmt->execute()) {
            echo "Libro guardado en la base de datos.<br>";
            header('Location: index.php');
            exit();
        } else {
            echo "Error al guardar el libro en la base de datos.<br>";
        }

        $stmt->close();
    } else {
        echo "Error al subir los archivos.<br>";
    }
}

$conexion->close();
?>
