<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Libro</title>
    <link rel="stylesheet" href="Estilos.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
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
    </div>
</nav>

<div class="container-flex">
    <div class="portada-preview">
        <h2>Vista previa de la portada</h2>
        <canvas id="pdf-preview" width="200" height="200"></canvas>
        <p id="preview-text">Selecciona un archivo PDF para ver la portada.</p>
    </div>
    
    <form action="Guardar-libro.php" method="POST" enctype="multipart/form-data" class="formulario">
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
            <input type="text" id="subido_por" name="subido_por" placeholder="Escribe tu nombre" required>
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
</body>
</html>
