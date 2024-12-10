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
    <link rel="stylesheet" href="/Biblioteca-digital/CSS/Estilos.css">
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

</body>
</html>
