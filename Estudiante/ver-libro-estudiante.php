<?php
require 'conexion.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conexion->prepare("SELECT titulo, categoria, autor, fecha_subida, descripcion, subido_por, Portada, archivo_pdf FROM libros WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($titulo, $categoria, $autor, $fecha_subida, $descripcion, $subido_por, $portada, $archivo_pdf);

    if ($stmt->fetch()) {
        ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Virtual</title>
    <link rel="stylesheet" href="../Css/Estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

    <script>
      function buscarLibro() {
    const query = document.getElementById('search').value.trim();

    fetch(`buscar.php?q=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => mostrarResultados(data))
        .catch(error => console.error('Error al buscar libros:', error));
}

function mostrarResultados(data) {
    const librosContainer = document.querySelector('.libros-container');
    librosContainer.innerHTML = '';

    if (data.length === 0) {
        librosContainer.innerHTML = '<p class="no-resultados">No se encontraron resultados.</p>';
        return;
    }

    let currentCategory = null;
    const categoryMap = {};

    data.forEach(libro => {
        // Crear el contenedor de la categoría si no existe
        if (libro.categoria !== currentCategory) {
            currentCategory = libro.categoria;
            const categoryDiv = document.createElement('div');
            categoryDiv.classList.add('categoria');

            const categoryTitle = document.createElement('h2');
            categoryTitle.textContent = currentCategory;
            categoryTitle.classList.add('categoria-titulo');

            const librosDiv = document.createElement('div');
            librosDiv.classList.add('libros');

            categoryDiv.appendChild(categoryTitle);
            categoryDiv.appendChild(librosDiv);
            librosContainer.appendChild(categoryDiv);

            categoryMap[currentCategory] = librosDiv;
        }

        
        const libroDiv = document.createElement('div');
        libroDiv.classList.add('libro');
        libroDiv.innerHTML = `
            <a href="ver-libro-estudiante.php?id=${libro.id}">
                <img src="${libro.Portada}" alt="Portada del libro" class="libro-portada">
            </a>
            <h3 class="libro-titulo">${libro.titulo}</h3>
        `;
        categoryMap[currentCategory].appendChild(libroDiv);
    });
}

    </script>
</head>

        <!--=============== HEADER ===============-->
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
                <input type="text" placeholder="Search">
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
                </ul>
            </div>
        </nav>
        </header>
        
       
    


        <div class="libro-detalles">
            <div class="libro-imagen">
                <img src="<?= $portada; ?>" alt="Portada del libro" class="libro-portada">
            </div>
            <div class="libro-info">
                <h2><?= htmlspecialchars($titulo); ?></h2>
                <p><strong>Autor:</strong> <?= htmlspecialchars($autor); ?></p>
                <p><strong>Categoría:</strong> <?= htmlspecialchars($categoria); ?></p>
                <p><strong>Fecha de Subida:</strong> <?= htmlspecialchars($fecha_subida); ?></p>
                <p><strong>Subido por:</strong> <?= htmlspecialchars($subido_por); ?></p>
                <p><strong>Descripción:</strong> <?= nl2br(htmlspecialchars($descripcion)); ?></p>

                <div class="botones">
                    <a href="leer_libro.php?id=<?= $id; ?>" target="_blank" class="btn leer-btn">Leer Libro</a>
                    <a href="descargar_libro.php?id=<?= $id; ?>" class="btn descargar-btn">Descargar PDF</a>
                </div>
            </div>
        </div>
        <footer class="pie-pagina">
        <div class="grupo-1 reveal">
            <div class="boxfoot">
                <h2>UBICANOS</h2>
                <figure>

                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15051.508901260462!2d-70.687866!3d19.41771!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8eb1cf196f54ddfb%3A0x740cafb0dbd0ef9f!2sDon%20Bosco%20Polytechnic%20Institute!5e0!3m2!1sen!2sus!4v1733892200284!5m2!1sen!2sus"
                        width="500" height="250" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>

                </figure>
            </div>
            <div class="boxfoot">
                <h2>SOBRE NOSOTROS</h2>
                <p>El IPIDBOSCO es una institución educativa del nivel medio en la modalidad Técnico Profesional, del
                    sector
                    oficial, dirigida por la Congregación Salesiana con la finalidad de formar íntegramente los jóvenes,
                    conjugando la formación académica, y la técnico profesional con la humana y religiosa.</p>
            </div>
            <div class="boxfoot">
                <h2>CONTACTANOS</h2>
                <div class="red-social">
                    <a href="#" class="fa fa-facebook"></a>
                    <a href="#" class="fa fa-instagram"></a>
                    <a href="#" class="fa fa-twitter"></a>
                    <a href="#" class="fa fa-youtube"></a>
                </div>
            </div>
        </div>
        <div class="grupo-2">
            <small>&copy; 2024 <b>6TO DAAI</b> - Todos los Derechos Reservados. <a href=""><B>Politica y
                        Privacidad</B></a></small>
        </div>
    </footer>
    <!--=============== MAIN JS ===============-->
    <script src="Js/main.js"></script>
</body>
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