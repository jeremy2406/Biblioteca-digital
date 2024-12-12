<?php
require 'conexion.php';

$tipo = "";
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $categoria = $_POST['categoria'];
    $autor = $_POST['autor'];
    $fecha = $_POST['fecha'];
    $subido_por = $_POST['subido_por'];
    $descripcion = $_POST['descripcion'];
    $archivo = $_FILES['archivo'];
    $portada = $_FILES['portada'];

    if ($archivo['error'] === UPLOAD_ERR_OK && $portada['error'] === UPLOAD_ERR_OK) {
        // Subir archivo PDF
        $nombreArchivo = basename($archivo['name']);
        $rutaPDF = 'Assets/PDF/' . $nombreArchivo;
        if (!move_uploaded_file($archivo['tmp_name'], $rutaPDF)) {
            $tipo = "error";
            $mensaje = "Error al subir el archivo PDF.";
        }

        // Subir imagen de portada
        $nombrePortada = basename($portada['name']);
        $rutaPortada = 'Assets/Portadas/' . $nombrePortada;
        if (!move_uploaded_file($portada['tmp_name'], $rutaPortada)) {
            $tipo = "error";
            $mensaje = "Error al subir la portada.";
        }

        // Guardar en la base de datos si no hay errores previos
        if (empty($tipo)) {
            $stmt = $conexion->prepare("INSERT INTO libros (titulo, categoria, autor, fecha_subida, descripcion, subido_por, archivo_pdf, portada) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $titulo, $categoria, $autor, $fecha, $descripcion, $subido_por, $rutaPDF, $rutaPortada);

            if ($stmt->execute()) {
                $tipo = "success";
                $mensaje = "Libro guardado correctamente.";
            } else {
                $tipo = "error";
                $mensaje = "Error al guardar el libro en la base de datos.";
            }

            $stmt->close();
        }
    } else {
        $tipo = "error";
        $mensaje = "Error al subir los archivos.";
    }
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar Libro</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .swal2-title {
            font-family: 'Poppins', sans-serif !important;
        }
        .swal2-html-container {
            font-family: 'Poppins', sans-serif !important;
        }
    </style>
</head>
<body>
    <?php if (!empty($tipo) && !empty($mensaje)) { ?>
        <script>
            Swal.fire({
                title: "<?php echo ($tipo === 'success') ? '¡Éxito!' : '¡Error!'; ?>",
                text: "<?php echo $mensaje; ?>",
                icon: "<?php echo $tipo; ?>",
                customClass: {
                    title: 'swal2-title',
                    htmlContainer: 'swal2-html-container'
                }
            }).then(() => {
                window.location.href = "index.php";
            });
        </script>
    <?php } ?>
</body>
</html>