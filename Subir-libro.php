<?php
require 'conexion.php';

session_start();
$Nombre_Estudiante = $_SESSION['Nombre_Estudiante'];

$select = mysqli_query($conexion, "SELECT * FROM usuarios WHERE Nombre_Estudiante = '$Nombre_Estudiante'")
            or die("Error al traer los datos");

    if(mysqli_num_rows($select) > 0){
        $fetch = mysqli_fetch_assoc($select);
    }else{
        echo "No se encontraron datos";
    }

$queryCategorias = "SELECT DISTINCT categoria FROM libros";
$resultCategorias = $conexion->query($queryCategorias);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Virtual</title>
    <link rel="stylesheet" href="Css/Estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>

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
        
    



<div class="container-flex">
    <div class="portada-preview">
        <h2>Vista previa de la portada</h2>
        <canvas id="pdf-preview" width="200" height="200"></canvas>
        <p id="preview-text">Selecciona un archivo PDF para ver la portada.</p>
    </div>
    
    <form action="Guardar-libro.php" method="POST" enctype="multipart/form-data" class="formulario">
        <div class="form-group">
            
        </div>
        <div class="form-group">
            <label for="titulo">Título del Libro:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Escribe el título del libro" required>
        </div>

        <div class="form-group">
            <label for="categoria">Categoría:</label>
            <select id="categoria" name="categoria" required>
                <option value="Ficción">Ficción</option>
                <option value="No Ficción">No Ficción</option>
                <option value="Ciencia">Ciencia</option>
                <option value="Historia">Historia</option>
                <option value="Biografía">Biografía</option>
                <option value="Autoayuda">Autoayuda</option>
                <option value="Fantasía">Fantasía</option>
                <option value="Misterio">Misterio</option>
                <option value="Tecnología">Tecnología</option>
                <option value="Romance">Romance</option>
                <option value="Romance">Español</option>
                <option value="Romance">Sociales</option>
                <option value="Romance">Naturales</option>
                <option value="Romance">Ingles</option>
            </select>
        </div>

        <div class="form-group">
            <label for="autor">Autor:</label>
            <input type="text" id="autor" name="autor" placeholder="Escribe el autor del libro" required>
        </div>

        <div class="form-group">
            <label for="fecha">Fecha de Subida:</label>
            <input type="date" id="fecha" name="fecha" required>
        </div>

        <div class="form-group">
            <label for="subido_por">Subido Por:</label>
            <input type="text" value="<?php echo $fetch['Nombre_Estudiante']; ?>" id="subido_por" name="subido_por" required readonly>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="4" placeholder="Escribe una breve descripción del libro" required></textarea>
        </div>

        <div class="form-group">
            <label for="archivo">Archivo PDF:</label>
            <input type="file" id="archivo" name="archivo" accept="application/pdf" required>
        </div>
        
        <div class="form-group">
            <label for="portada">Portada:</label> 
            <input type="file" name="portada" id="portada" required>
        </div>

        <button type="submit" class="btn btn-submit">Subir Libro</button>
    </form>
</div>

<script>
    const fileInput = document.getElementById('archivo');
    const canvas = document.getElementById('pdf-preview');
    const context = canvas.getContext('2d');
    const previewText = document.getElementById('preview-text');

    fileInput.addEventListener('change', async (event) => {
        const file = event.target.files[0];

        if (file && file.type === 'application/pdf') {
            const fileReader = new FileReader();
            fileReader.onload = async function () {
                const typedArray = new Uint8Array(this.result);
                const pdf = await pdfjsLib.getDocument(typedArray).promise;
                const page = await pdf.getPage(1); // Primera página del PDF

                const viewport = page.getViewport({ scale: 1 });
                canvas.width = viewport.width;
                canvas.height = viewport.height;

                const renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };

                await page.render(renderContext).promise;

                previewText.style.display = 'none';
            };
            fileReader.readAsArrayBuffer(file);
        } else {
            context.clearRect(0, 0, canvas.width, canvas.height);
            previewText.style.display = 'block';
            previewText.textContent = 'Por favor, selecciona un archivo PDF válido.';
        }
    });
</script>

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
    <script src="Js/main.js">
        
    </script>
</body>
</html>
