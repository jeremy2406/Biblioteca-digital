<?php
require 'conexion.php';

// Manejo de eliminación con notificaciones SweetAlert
$tipo = "";
$mensaje = "";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    if ($id) {
        // Consultar el libro para obtener las rutas de los archivos
        $stmt = $conexion->prepare("SELECT archivo_pdf, portada FROM libros WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($archivoPDF, $portada);
            $stmt->fetch();

            // Eliminar los archivos si existen
            if (file_exists($archivoPDF)) {
                unlink($archivoPDF);
            }
            if (file_exists($portada)) {
                unlink($portada);
            }

            $stmt->close();

            // Eliminar el registro de la base de datos
            $stmt = $conexion->prepare("DELETE FROM libros WHERE id = ?");
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                $tipo = "success";
                $mensaje = "¡Libro eliminado correctamente!";
            } else {
                $tipo = "error";
                $mensaje = "Error al eliminar el libro de la base de datos.";
            }
        } else {
            $tipo = "error";
            $mensaje = "Libro no encontrado.";
        }
    } else {
        $tipo = "error";
        $mensaje = "ID de libro no especificado.";
    }
}

// Mostrar la lista de libros
$result = $conexion->query("SELECT id, titulo FROM libros");

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "
        <div>
            <h3>{$row['titulo']}</h3>
            <a href='?id={$row['id']}' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este libro?\");'>Eliminar</a>
        </div>
        ";
    }
} else {
    echo "<p>No hay libros disponibles.</p>";
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Libro</title>
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
