<?php

include 'conexion.php';
session_start();
$Nombre_Estudiante = $_SESSION['Nombre_Estudiante'];

if(!isset($_SESSION['Nombre_Estudiante'])){
    header("Location: ../Login/Login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Usuario</title>
    <link rel="stylesheet" href="../Biblioteca-digital/CSS/Perfil.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b725322e1a.js" crossorigin="anonymous"></script>
</head>

<header class="header">
        <nav class="nav container">
            <div class="nav__data">
                <a href="index.php" class="nav__logo">
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
                        <a href="index.php" class="nav__link">Inicio</a>
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


                    <li>
                        <a href="Subir-libro.php" class="nav__link">Subir Libros</a>
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
                                        <a href="../Biblioteca-digital/Perfil.php">
                                            <i class="fa-solid fa-user"></i>
                                        </a>
                                    </div>

                                    <span class="dropdown__title">Ver perfil</span>
                                </div>

                                <div class="dropdown__group">
                                    <div class="dropdown__icon">
                                        <a href="../Biblioteca-digital/Login/Login.html" class="nav__link">
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
    
<div class="container-profile">
    <div class="profile">
        <?php
            $select = mysqli_query($conexion, "SELECT * FROM usuarios WHERE Nombre_Estudiante = '$Nombre_Estudiante'")
            or die("Error al traer los datos");

            if(mysqli_num_rows($select) > 0){
                $fetch = mysqli_fetch_assoc($select);
            }
            if($fetch['Imagen'] == ''){
                echo '<img src="../Biblioteca-digital/FotoUser.png">';
            }else{
                echo '<img src="../Biblioteca-digital/Fotos_Perfil'.$fetch['Imagen'].'">';
            }
        ?>

        <h3 class="NombreEstudiante"><?php echo $fetch['Nombre_Estudiante']; ?></h3>
        <a href="Editar_Perfil.php" class="btn">Editar Perfil</a>

    </div>
</div>

</body>
</html>