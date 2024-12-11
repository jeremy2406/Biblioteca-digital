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
    <link rel="stylesheet" href="../Biblioteca-digital/CSS/login.css">
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
<body>
    
<nav class="navbar">
    <div class="nav-container">
        <h1 class="logo">Biblioteca Virtual</h1>
        <ul class="nav-links">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="subir-libro.php">Subir Libro</a></li>
            <li><a href="#">Acerca de</a></li>
            <li><a href="#">Contacto</a></li>
        </ul>
        <div class="search-container">
            <input type="text" id="search" class="search-bar" placeholder="Buscar libro o categoría..." onkeyup="buscarLibro()">
        </div>
    </div>
</nav>

<div class="libros-container">
    <?php while ($categoria = $resultCategorias->fetch_assoc()): ?>
        <div class="categoria">
            <h2 class="categoria-titulo"><?= htmlspecialchars($categoria['categoria']); ?></h2>

            <?php
                $categoriaNombre = $categoria['categoria'];
                $queryLibros = "SELECT id, titulo, Portada FROM libros WHERE categoria = ?";
                $stmt = $conexion->prepare($queryLibros);
                $stmt->bind_param("s", $categoriaNombre);
                $stmt->execute();
                $resultadoLibros = $stmt->get_result();
                
                if ($resultadoLibros->num_rows > 0): ?>
                    <div class="libros">
                        <?php while ($row = $resultadoLibros->fetch_assoc()): ?>
                            <div class="libro">
                                <a href="ver-libro.php?id=<?= $row['id']; ?>">
                                    <img src="<?= $row['Portada']; ?>" alt="Portada del libro" class="libro-portada">
                                </a> 
                                <h3 class="libro-titulo"><?= htmlspecialchars($row['titulo']); ?></h3>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <p class="no-resultados">No hay libros en esta categoría.</p>
                <?php endif; ?>
                <?php $stmt->close(); ?>
        </div>
    <?php endwhile; ?>
</div>

    <footer class="pie-pagina">
        <div class="grupo-1 reveal">
            <div class="boxfoot">
                <h2>UBICANOS</h2>
                <figure>

                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15051.508901260462!2d-70.687866!3d19.41771!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8eb1cf196f54ddfb%3A0x740cafb0dbd0ef9f!2sDon%20Bosco%20Polytechnic%20Institute!5e0!3m2!1sen!2sus!4v1733892200284!5m2!1sen!2sus" width="500" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                </figure>
            </div>
            <div class="boxfoot">
                <h2>SOBRE NOSOTROS</h2>
                <p>El IPIDBOSCO es una institución educativa del nivel medio en la modalidad Técnico Profesional, del sector oficial, dirigida por la Congregación Salesiana con la finalidad de formar íntegramente los jóvenes, conjugando la formación académica, y la técnico profesional con la humana y religiosa.</p>
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
            <small>&copy; 2024 <b>6TO DAAI</b> - Todos los Derechos Reservados.  <a href=""><B>Politica y Privacidad</B></a></small>
        </div>
    </footer>

</body>
</html>
