<?php
include 'conexion.php';
session_start();
$Nombre_Estudiante = $_SESSION['Nombre_Estudiante'];
$Matricula = $_SESSION['Matricula'];

if(isset($_POST['Actualizar'])){
    $old_Contrasena = $_POST['old_Contrasena'];
    $Editar_Contrasena = !empty($_POST['Editar_Contrasena']) ? mysqli_real_escape_string($conexion, md5($_POST['Editar_Contrasena'])) : '';
    $Nueva_Contrasena = !empty($_POST['Nueva_Contrasena']) ? mysqli_real_escape_string($conexion, md5($_POST['Nueva_Contrasena'])) : '';
    $Confirmar_Contrasena = !empty($_POST['Confirmar_Contrasena']) ? mysqli_real_escape_string($conexion, md5($_POST['Confirmar_Contrasena'])) : '';

    $success = true; // Flag para verificar el éxito general
    $errorMessages = []; // Almacenar mensajes de error

    // Actualizar contraseña solo si los campos no están vacíos
    if (!empty($Editar_Contrasena) || !empty($Nueva_Contrasena) || !empty($Confirmar_Contrasena)) {
        if ($Editar_Contrasena != $old_Contrasena) {
            $success = false;
            $errorMessages[] = "La contraseña antigua no coincide.";
        } elseif ($Nueva_Contrasena != $Confirmar_Contrasena) {
            $success = false;
            $errorMessages[] = "Las contraseñas no coinciden.";
        } else {
            $updateContrasena = mysqli_query($conexion, "UPDATE usuarios SET Contrasena = '$Confirmar_Contrasena' WHERE Matricula = '$Matricula'");
            if (!$updateContrasena) {
                $success = false;
                $errorMessages[] = "Error al actualizar la contraseña.";
            }
        }
    }

    // Actualizar foto de perfil
    if (isset($_FILES['Editar_Foto']) && $_FILES['Editar_Foto']['error'] == UPLOAD_ERR_OK) {
        $Editar_Foto = $_FILES['Editar_Foto']['name'];
        $Editar_Foto_size = $_FILES['Editar_Foto']['size'];
        $Editar_Foto_tmp_name = $_FILES['Editar_Foto']['tmp_name'];
        $Editar_Foto_Folder = '/Biblioteca-digital/Fotos_Perfil' . $Editar_Foto;

        if ($Editar_Foto_size > 5000000) {
            $success = false;
            $errorMessages[] = "La imagen es muy grande.";
        } else {
            $image_update_query = mysqli_query($conexion, "UPDATE usuarios SET Imagen = '$Editar_Foto' WHERE Matricula = '$Matricula'");
            if ($image_update_query) {
                move_uploaded_file($Editar_Foto_tmp_name, $Editar_Foto_Folder);
            } else {
                $success = false;
                $errorMessages[] = "Error al actualizar la imagen.";
            }
        }
    }

    // Mostrar alerta de SweetAlert
    if ($success) {
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'El perfil ha sido actualizado correctamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            };
        </script>";
    } else {
        $errorText = implode(' ', $errorMessages);
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    title: 'Error',
                    text: '$errorText',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            };
        </script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="../CSS/Perfil.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b725322e1a.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<header class="header">
        <nav class="nav container">
            <div class="nav__data">
                <a href="../Estudiante/Index-estudiante.php" class="nav__logo">
                    <p>Biblioteca DonBosco</p>
                </a>

                <div class="nav__toggle" id="nav-toggle">
                    <i class="ri-menu-line nav__toggle-menu"></i>
                    <i class="ri-close-line nav__toggle-close"></i>
                </div>
            </div>

            <!--=============== NAV MENU ===============-->
            <div class="box">
                <input type="text" id="search" placeholder="Search" onkeyup="buscarLibro()">
                <a href="">
                    <i class="ri-search-eye-line"></i>
                </a>
            </div>
            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li>
                        <a href="../Estudiante/Index-estudiante.php" class="nav__link">Inicio</a>
                    </li>

                    <!--=============== DROPDOWN 1 ===============-->
                    <li class="dropdown__item">
                        <div class="nav__link dropdown__button">
                            Materias <i class="ri-arrow-down-s-line dropdown__arrow"></i>
                        </div>

                        <div class="dropdown__container">
                            <div class="dropdown__content">
                                <div class="dropdown__group">
                                    <div class="dropdown__icon">
                                        <i class="ri-book-open-fill"></i>
                                    </div>

                                    <a href="Lengua_Española.php" class="dropdown__title">Lengua Española</a>


                                </div>

                                <div class="dropdown__group">
                                    <div class="dropdown__icon">
                                        <i class="ri-quill-pen-line"></i>
                                    </div>

                                    <a href="Ciencias_Naturales.php" class="dropdown__title">Ciencias Naturales</a>



                                </div>

                                <div class="dropdown__group">
                                    <div class="dropdown__icon">
                                        <i class="ri-book-fill"></i>
                                    </div>

                                    <a href="Ciencias_Sociales.php" class="dropdown__title">Ciencias Sociales</a>


                                </div>

                                <div class="dropdown__group">
                                    <div class="dropdown__icon">
                                        <i class="ri-file-paper-2-line"></i>
                                    </div>

                                    <a href="Ingles.php" class="dropdown__title">Ingles</a>


                                </div>
                            </div>
                        </div>
                    </li>

                    <!--=============== DROPDOWN 3 ===============-->
                    <li class="dropdown__item">
                        <div class="nav__link dropdown__button">
                            Contacto <i class="ri-arrow-down-s-line dropdown__arrow"></i>
                        </div>

                        <div class="dropdown__container">
                            <div class="dropdown__content">
                                <div class="dropdown__group">
                                    <div class="dropdown__icon">
                                        <i class="ri-community-line"></i>
                                    </div>

                                    <span class="dropdown__title">Redes Sociales</span>

                                    <ul class="dropdown__list">
                                        <li>
                                            <a href="https://www.instagram.com/ipidbosco/?hl=es"
                                                class="dropdown__link">Instagram</a>
                                        </li>
                                        <li>
                                            <a href="https://www.facebook.com/IPIDBOSCO/?ref=page_internal"
                                                class="dropdown__link">Facebook</a>
                                        </li>

                                    </ul>
                                </div>

                                <div class="dropdown__group">
                                    <div class="dropdown__icon">
                                        <i class="ri-shield-line"></i>
                                    </div>

                                    <span class="dropdown__title">Plataforma</span>

                                    <ul class="dropdown__list">
                                        <li>
                                            <a href="https://ipidbosco.ses.edu.do/lg/" class="dropdown__link">Ir</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="dropdown__item">
                    <div class="nav__link dropdown__button">
                        <?php
                        if (isset($_SESSION['Nombre_Estudiante'])) {
                            echo htmlspecialchars($_SESSION['Nombre_Estudiante']); // Muestra el nombre del usuario
                        } else {
                            echo "User"; // Muestra "User" si no hay sesión
                        }
                        ?>
                        <i class="ri-arrow-down-s-line dropdown__arrow"></i>
                    </div>

                        <div class="dropdown__container">
                            <div class="dropdown__content">
                                <div class="dropdown__group">
                                    <div class="dropdown__icon">
                                        <a href="../Estudiante/Perfil-Estudiante.php">
                                            <i class="fa-solid fa-user"></i>
                                        </a>
                                    </div>

                                    <span class="dropdown__title">Ver perfil</span>
                                </div>

                                <div class="dropdown__group">
                                    <div class="dropdown__icon">
                                        <a href="../Login/Login.html" class="nav__link">
                                            <i class="fa-solid fa-right-to-bracket"></i>
                                        </a>
                                    </div>

                                    <span class="dropdown__title">Cerrar Sesion</span>
                                </div>
                            </div>
                        </div>
                    </li>

                </ul>
            </div>
        </nav>
    </header>


<body>
    <div class="EditarPerfil">
        <?php
            $select = mysqli_query($conexion, "SELECT * FROM usuarios WHERE Nombre_Estudiante = '$Nombre_Estudiante'")
            or die("Error al traer los datos");

            if(mysqli_num_rows($select) > 0){
                $fetch = mysqli_fetch_assoc($select);
            }
        ?>

        <form action="" method="post" enctype="multipart/form-data">
            <?php
                if($fetch['Imagen'] == ''){
                    echo '<img src="/Biblioteca-digital/Fotos_Perfil/FotoUser.png">';
                }else{
                    echo '<img src="/Biblioteca-digital/'.$fetch['Imagen'].'">';
                }
            ?>
            <div class="flex">
                <div class="inputBox">
                    <span>Nombre Estudiante: </span>
                    <input type="text" name="Editar_Nombre" value="<?php echo $fetch['Nombre_Estudiante']; ?>" class="caja" readonly>
                    <span>Correo Electronico: </span>
                    <input type="text" name="Editar_Email" value="<?php echo $fetch['Email']; ?>" class="caja" readonly>
                    <span>Foto de Perfil: </span>
                    <input type="file" name="Editar_Foto" accept="image/jpg, image/png, image/jpeg" class="caja">
                </div>
                <div class="inputBox">
                    <input type="hidden" name="old_Contrasena" value="<?php echo $fetch['Contrasena']; ?>">
                    <span>Antigua Contraseña: </span>
                    <input type="password" name="Editar_Contrasena" placeholder="Ingrese Antigua" class="caja">
                    <span>Nueva Contraseña: </span>
                    <input type="password" name="Nueva_Contrasena" placeholder="Ingrese Nueva" class="caja">
                    <span>Confirmar Contraseña: </span>
                    <input type="password" name="Confirmar_Contrasena" placeholder="Confirmar Contraseña" class="caja">
                </div>
            </div>
            <input type="submit" value="Actualizar Perfil" name="Actualizar" class="btn">

        </form>
    </div>
</body>
</html>