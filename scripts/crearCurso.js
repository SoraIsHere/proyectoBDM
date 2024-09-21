let contadorCapitulos = 1;

function agregarCapitulo() {
    contadorCapitulos++;
    const contenedorCapitulos = document.getElementById('contenedor-capitulos');
    const nuevoCapitulo = document.createElement('div');
    nuevoCapitulo.classList.add('capitulo');
    nuevoCapitulo.id = `capitulo-${contadorCapitulos}`;
    nuevoCapitulo.innerHTML = `
        <label for="capitulos[${contadorCapitulos}][titulo]">Título del Capítulo:</label>
        <input type="text" id="capitulos[${contadorCapitulos}][titulo]" name="capitulos[${contadorCapitulos}][titulo]" required>

        <label for="capitulos[${contadorCapitulos}][contenido]">Contenido del Capítulo:</label>
        <textarea id="capitulos[${contadorCapitulos}][contenido]" name="capitulos[${contadorCapitulos}][contenido]" required></textarea>

        <label for="capitulos[${contadorCapitulos}][imagenes]">Imágenes:</label>
        <input type="file" id="capitulos[${contadorCapitulos}][imagenes]" name="capitulos[${contadorCapitulos}][imagenes][]" multiple>

        <label for="capitulos[${contadorCapitulos}][videos]">Videos:</label>
        <input type="file" id="capitulos[${contadorCapitulos}][videos]" name="capitulos[${contadorCapitulos}][videos][]" multiple>

        <button type="button mt-4" class="color-btn" onclick="borrarCapitulo(${contadorCapitulos})">Borrar Capítulo</button>
    `;
    contenedorCapitulos.appendChild(nuevoCapitulo);
}

function borrarCapitulo(numeroCapitulo) {
    if (numeroCapitulo > 1) {
        const capitulo = document.getElementById(`capitulo-${numeroCapitulo}`);
        capitulo.remove();
    }
}

document.getElementById('formulario-curso').addEventListener('submit', function (event) {
    event.preventDefault();


    alert('Curso guardado exitosamente');
});
