<?php
include '../conexion.php';

//REGISTRARSE//

if (isset($_POST['Registrar'])) {
    $Matricula = $_POST['Matricula'];
    $Nombre_Estudiante = $_POST['Nombre_Estudiante'];
    $Correo_Electronico = $_POST['Email'];
    $Contrasena = $_POST['Contrasena'];
    $Contrasena = md5($Contrasena);

    // Ruta de la imagen por defecto
    $imagenPorDefecto = '../Biblioteca-digital/FotoUser.png';

    $checkEmail = "SELECT * FROM usuarios WHERE Matricula='$Matricula'";
    $result = $conexion->query($checkEmail);

    if ($result->num_rows > 0) {
        $tipo = "error";
        $mensaje = "¡Error! La matrícula ya existe.";
    } else {
        $insertQuery = "INSERT INTO usuarios (Matricula, Nombre_Estudiante, Email, Contrasena, Imagen)
                        VALUES ('$Matricula', '$Nombre_Estudiante', '$Correo_Electronico', '$Contrasena', '$imagenPorDefecto')";

        if ($conexion->query($insertQuery) === TRUE) {
            $tipo = "success";
            $mensaje = "¡Registro exitoso!";
        } else {
            $tipo = "error";
            $mensaje = "¡Error! No se pudo registrar el usuario.";
        }
    }
}

//ACCEDER//

if (isset($_POST['Acceder'])) {
    $Matricula = $conexion->real_escape_string($_POST['Matricula']);
    $Contrasena = $conexion->real_escape_string(md5($_POST['Contrasena']));

    $sql = "SELECT * FROM usuarios WHERE Matricula='$Matricula' AND Contrasena='$Contrasena'";
    $result = $conexion->query($sql);

    if ($result->num_rows > 0) {
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['Matricula'] = $row['Matricula'];
        $_SESSION['Nombre_Estudiante'] = $row['Nombre_Estudiante'];

        if (strpos($Matricula, '987') === 0) {
            header("Location: ../index.php"); //SI ERES PROFESOR
        } else {
            header("Location: ../Estudiante/index-estudiante.php"); //SI ERES ESTUDIANTE
        }
        exit();
    } else {
        $tipo = "error";
        $mensaje = "Matrícula o contraseña incorrecta.";
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
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
    <?php if (isset($tipo) && isset($mensaje)) { ?>
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
                window.location.href = "<?php echo ($tipo === 'success') ? 'Login.html' : 'Login.html'; ?>";
            });
        </script>
    <?php } ?>
</body>
</html>
