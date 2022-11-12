const buscador = document.querySelector('input[type="search"]');
const btnEscanear = document.querySelector('#btn-escanear');

const limpiarInput = (input) => input.value = '';
const darClic = (elemento) => elemento.click();

buscador.focus();

buscador.addEventListener('keydown', e => {
    if (e.keyCode === 13) {
        const btnAgregar = document.querySelector('.agregar-producto');
        const tiempoBusqueda = setTimeout(() => darClic(btnAgregar), 2000);
        const tiempoLimpiar = setTimeout(() => limpiarInput(buscador), 2000);
    }
});

btnEscanear.addEventListener('click', e => {
    e.preventDefault();
    buscador.focus();
});