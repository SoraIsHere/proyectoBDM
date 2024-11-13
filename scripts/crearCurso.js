document.getElementById('formulario-curso').addEventListener('submit', function (event) {
    /*     event.preventDefault();
        alert('Curso guardado exitosamente'); */
});

let contadorCapitulos = 0;

function agregarCapitulo() {
    contadorCapitulos++;
    const contenedorCapitulos = document.getElementById('contenedor-capitulos');
    const nuevoCapitulo = document.createElement('div');
    nuevoCapitulo.classList.add('capitulo');
    nuevoCapitulo.id = `capitulo-${contadorCapitulos}`;
    actualizarCapitulos();
    nuevoCapitulo.innerHTML = `
        <label for="capitulos[${contadorCapitulos}][titulo]">Título del Capítulo:</label>
        <input type="text" id="capitulos[${contadorCapitulos}][titulo]" name="capitulos[${contadorCapitulos}][titulo]" required>

        <label for="capitulos[${contadorCapitulos}][contenido]">Contenido del Capítulo:</label>
        <textarea id="capitulos[${contadorCapitulos}][contenido]" name="capitulos[${contadorCapitulos}][contenido]" required></textarea>

        <label for="capitulos[${contadorCapitulos}][video]">Video:</label>
        <input type="file" id="capitulos[${contadorCapitulos}][video]" name="capitulos[${contadorCapitulos}][video]" >
       <label for="capitulos[${contadorCapitulos}][costo]">Costo:</label>
      <input type="number" id="costo" name="capitulos[${contadorCapitulos}][precio]" min="0" required>
       <button type="button" class="color-btn mt-4 deleteBtn" onclick="borrarCapitulo(${contadorCapitulos})">Borrar Capítulo</button>
    `;
    contenedorCapitulos.appendChild(nuevoCapitulo);
}

function borrarCapitulo(numeroCapitulo) {
    contadorCapitulos -= 1;
    if (numeroCapitulo >= 0) {
        const capitulo = document.getElementById(`capitulo-${numeroCapitulo}`);
        capitulo.remove();
    }
}

function actualizarCapitulos() {
    if (contadorCapitulos > 0) {
        console.log("a")
        const botonBorrar = document.querySelectorAll('.deleteBtn');
        if (botonBorrar) {
            Array.from(botonBorrar).forEach((boton, index) => {
                boton.remove();
            });
        }
    }
}
