<?php
require 'conexion.php';

$queryCategorias = "SELECT DISTINCT categoria FROM libros";
$resultCategorias = $conexion->query($queryCategorias);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Virtual</title>
    <link rel="stylesheet" href="Estilos.css">
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
            <a href="ver-libro.php?id=${libro.id}">
                <img src="${libro.Portada}" alt="Portada del libro" class="libro-portada">
            </a>
            <h3 class="libro-titulo">${libro.titulo}</h3>
        `;
        categoryMap[currentCategory].appendChild(libroDiv);
    });
}

    </script>
</head>
<title>Biblioteca Virtual</title>
    </head>
    <body>
        <!--=============== HEADER ===============-->
        <header class="header">
            <nav class="nav container">
                <div class="nav__data">
                    <a href="#" class="nav__logo">
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
    
                                        <span class="dropdown__title">Lengua Española</span>
    
                                        <ul class="dropdown__list">
                                            <li>
                                                <a href="Subir-libro.php" class="dropdown__link">Subir Libros</a>
                                            </li>
                                        </ul>
                                        <ul class="dropdown__list">
                                            <li>
                                                <a href="ver-libro.php" class="dropdown__link">Ver Libros</a>
                                            </li>
                                        </ul>
                                    </div>
    
                                    <div class="dropdown__group">
                                        <div class="dropdown__icon">
                                          <i class="ri-quill-pen-line"></i>
                                        </div>
    
                                        <span class="dropdown__title">Ciencias Naturales</span>
    
                                        
                                        <ul class="dropdown__list">
                                            <li>
                                                <a href="Subir-libro.php" class="dropdown__link">Subir Libros</a>
                                            </li>
                                        </ul>
                                        <ul class="dropdown__list">
                                            <li>
                                                <a href="ver-libro.php" class="dropdown__link">Ver Libros</a>
                                            </li>
                                        </ul>
                                    </div>
    
                                    <div class="dropdown__group">
                                        <div class="dropdown__icon">
                                          <i class="ri-book-fill"></i>
                                        </div>
    
                                        <span class="dropdown__title">Ciencias Sociales</span>
    
                                        <ul class="dropdown__list">
                                            <li>
                                                <a href="Subir-libro.php" class="dropdown__link">Subir Libros</a>
                                            </li>
                                        </ul>
                                        <ul class="dropdown__list">
                                            <li>
                                                <a href="ver-libro.php" class="dropdown__link">Ver Libros</a>
                                            </li>
                                        </ul>
                                    </div>
    
                                    <div class="dropdown__group">
                                        <div class="dropdown__icon">
                                            <i class="ri-file-paper-2-line"></i>
                                        </div>
    
                                        <span class="dropdown__title">Ingles</span>
    
                                        <ul class="dropdown__list">
                                            <li>
                                                <a href="Subir-libro.php" class="dropdown__link">Subir Libros</a>
                                            </li>
                                        </ul>
                                        <ul class="dropdown__list">
                                            <li>
                                                <a href="ver-libro.php" class="dropdown__link">Ver Libros</a>
                                            </li>
                                        </ul>
                                        
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
                                                <a href="https://www.instagram.com/ipidbosco/?hl=es" class="dropdown__link">Instagram</a>
                                            </li>
                                            <li>
                                                <a href="https://www.facebook.com/IPIDBOSCO/?ref=page_internal" class="dropdown__link">Facebook</a>
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
        
        <!--=============== MAIN JS ===============-->
        <script src="assets/js/main.js"></script>
    </body>
</html>