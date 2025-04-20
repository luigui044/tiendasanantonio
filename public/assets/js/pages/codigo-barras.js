// DOM Elements (corregimos aquí)
const inputMonto = document.querySelector('#monto');


const inputCambio = document.querySelector('#cambio');
const inputTotal = document.querySelector('#total');
const btnVenta = document.querySelector('#realizar-venta');
const cliente = document.querySelector('#cliente');
const clienteNuevo = document.querySelector('#cliente-nuevo');
const btnsAgregarProducto = document.querySelectorAll('.agregar-producto');
const inputLector = document.querySelector('#lector-barra');
const inputBuscarProducto = document.querySelector('#buscar-producto');
const btnBuscarProducto = document.querySelector('#btn-buscar-producto');
document.addEventListener('DOMContentLoaded', () => {
    const inputMonto = document.querySelector('#monto');
    if (inputMonto) {
        inputMonto.addEventListener('input', (e) => {
            let valor = e.target.value.replace(/[^\d]/g, '');
            let digitos = valor.split('').reverse();
            digitos = digitos.slice(0, 10);
            if (digitos.length > 2) digitos.splice(2, 0, '.');
            e.target.value = digitos.reverse().join('');
        });

        inputMonto.addEventListener('keyup', (e) => {
            btnVenta.disabled = true;
            if (!soloNumerosPositivos(e.target.value)) {
                inputCambio.value = 0;
            } else if (parseFloat(e.target.value) < parseFloat(inputTotal.value)) {
                inputCambio.value = 0;
            } else {
                calcularCambio(inputTotal.value, e.target.value);
                btnVenta.disabled = false;
            }
        });
    }
});


window.onload = () => {


}
inputMonto.addEventListener('keyup', (e) => {
    btnVenta.disabled = true;
    if (!soloNumerosPositivos(e.target.value)) {
        inputCambio.value = 0;
    } else if (parseFloat(e.target.value) < parseFloat(inputTotal.value)) {
        inputCambio.value = 0;
    } else {
        calcularCambio(inputTotal.value, e.target.value);
        btnVenta.disabled = false;
    }
});


function calcularCambio(total, monto) {
    inputCambio.value = (monto - total).toFixed(2);
}


function soloNumerosPositivos(valor) {
    let regEx = /^[0-9]+(.[0-9]{1,2})?$/;
    return regEx.test(valor);
}


// Función para calcular subtotal de una fila
function calcularSubtotalFila(fila) {
    console.log(fila);
    const precio = parseFloat(eliminarSignoDolar(fila.querySelector('.precio').textContent));
    const descuento = parseFloat(eliminarPorcentaje(fila.querySelector('.descuento').textContent)) / 100;
    const cantidad = parseInt(fila.querySelector('.cantidad').value);

    const subtotal = precio * (1 - descuento) * cantidad;
    fila.querySelector('.subtotal').textContent = `$${subtotal}`;
}

const calcularPorcentajeDescuento = (precio, descuento) => {
    return ((descuento * 100) / precio).toFixed(2);
};

function agregarProducto(producto) {
    if (!sumarProductosExistentes(producto)) {

        let cuerpoTabla = document.querySelector('#tb-productos-agregados tbody'),
            tr = document.createElement('tr'),
            precio = parseFloat(producto.precio),
            descuento = (producto.descuento / 100).toFixed(2),


            td0 = crearElemento('td', 'id-producto-agregado', producto.cod_bar),

            td1 = crearElemento('td', 'cantidad-agregada', null),
            td2 = crearElemento('td', null, producto.producto),
            td6 = crearElemento('td', null, producto.precio),
            td3 = crearElemento('td', 'descuento', null),
            td4 = crearElemento('td', 'subtotal', `$${calcularSubtotal(precio, descuento, 1)}`),
            td5 = document.createElement('td'),

            div = crearElemento('div', 'div-cantidad', null),
            inputCantidad = crearInput('number', 'form-control cantidad', null, 1),
            button = crearElemento('button', 'eliminar-producto', null),
            btnDescuento = crearElemento('button', 'btn-descuento', null),
            iconoDescuento = crearElemento('i', 'fa-solid fa-percent ms-2', null),
            porcentaje = document.createTextNode(producto.descuento),
            inputHidden = crearInput('hidden',
                'input-producto',
                `producto[${producto.cod_bar}]`,
                `${producto.cod_bar};1;${precio};${descuento}`),
            i = crearElemento('i', 'fa-solid fa-trash-can', null),
            datosProducto;

        inputCantidad.min = 0;
        div.appendChild(inputCantidad);
        td1.appendChild(div);
        button.type = 'button';
        button.appendChild(i);
        btnDescuento.type = 'button';
        btnDescuento.id = `btn-descuento-${producto.id_prod}`;
        btnDescuento.setAttribute('data-bs-toggle', 'modal');
        btnDescuento.setAttribute('data-bs-target', '#modal-descuento');
        btnDescuento.appendChild(porcentaje);
        btnDescuento.appendChild(iconoDescuento);
        td3.appendChild(btnDescuento);
        td5.appendChild(button); // Agrega el botón de eliminar a la última celda

        tr.appendChild(td1); // Celda con el input de cantidad
        tr.appendChild(td2); // Celda con el nombre del producto
        tr.appendChild(td0); // Celda con el código de barras del producto
        tr.appendChild(td6); // Celda con el precio del producto
        tr.appendChild(td3); // Celda con el botón de descuento

        tr.appendChild(td4); // Celda con el subtotal
        tr.appendChild(td5); // Celda con el botón de eliminar
        tr.appendChild(inputHidden); // Input oculto con datos del producto

        // Agregando fila de producto a la tabla
        cuerpoTabla.appendChild(tr);

        // Agregando eventos 
        const actualizarDatos = () => {
            if (!soloNumerosEnterosPositivos(inputCantidad.value)) {
                inputCantidad.value = '';
            }

            // Actualizando la cantidad de producto
            datosProducto = inputHidden.value.split(';');
            // Cantidad de producto
            datosProducto[1] = inputCantidad.value;
            td4.textContent = '$' + calcularSubtotal(precio, datosProducto[3], inputCantidad.value);
            inputHidden.value = datosProducto.join(';');
        };

        // Agregando función de eliminar producto al botón
        button.addEventListener('click', () => {
            eliminarProducto(button);
            calcularTotal();
        });

        // Agregando validación al input de cantidad de producto
        inputCantidad.addEventListener('change', () => {
            actualizarDatos();
            calcularTotal();
        });
        inputCantidad.addEventListener('keyup', () => {
            actualizarDatos();
            calcularTotal();
        });

        // Agregando validación de precio en modal de descuento
        btnDescuento.addEventListener('click', () => {
            inputsDescuento({
                nombre: producto.producto,
                precio: precio,
                descuento: btnDescuento.firstChild,
                input: inputHidden,
                cantidad: inputCantidad.value,
                subtotal: td4
            });
        });
    }

    calcularTotal();
}

function soloNumerosEnterosPositivos(valor) {
    let regEx = /^[1-9][0-9]{0,}$/;
    return regEx.test(valor);
}

function crearElemento(tipo, clase, contenido) {
    const elemento = document.createElement(tipo);

    if (clase !== null) elemento.className = clase;
    if (contenido !== null) elemento.textContent = contenido;
    return elemento;
}
function crearInput(tipo, clase, name, valor) {
    const input = document.createElement('input');
    input.type = tipo;
    input.className = clase;

    if (name !== null) input.name = name;
    if (valor !== null) input.value = valor;
    return input;
}

btnBuscarProducto.addEventListener('click', () => {
    const codigo = inputBuscarProducto.value.trim();
    inputBuscarProducto.value = '';
    if (codigo) buscarProductoPorCodigo(codigo);
});

function buscarProductoPorCodigo(codigo) {
    fetch(`/producto/${codigo}`)
        .then(res => {
            return res.text();
        })
        .then(data => {

            const producto = JSON.parse(data);  // Ahora haces parse del JSON
            if (!producto || !producto.id_prod) {
                alert('Producto no encontrado');
                return;
            }

            // Convertimos precio y descuento a número si vienen como string
            producto.precio = parseFloat(producto.precio);
            producto.descuento = parseFloat(producto.descuento);

            agregarProducto(producto);
        }).catch(err => {
            console.error('Error al obtener el producto:', err);
        });
}


const inputsDescuento = (producto) => {
    const desc1 = document.querySelector('#desc1');
    const desc2 = document.querySelector('#desc2');
    const tituloModal = document.querySelector('#titulo-descuento');
    const precioModal = document.querySelector('#precio-descuento')
    const btnDescuento = document.querySelector('#aplicar-descuento');

    // Se desactiva por defecto el boton de aplicar descuento, se activa hasta que haya ingresado datos correctos
    tituloModal.textContent = `Aplicar descuento a: ${producto['nombre']}`;
    precioModal.textContent = `Precio: $${producto['precio'].toFixed(2)}`;
    desc2.value = producto['descuento'].nodeValue;
    desc1.value = calcularDescuentoEnDinero(producto['precio'], desc2.value);

    const validarDesc1 = () => {
        let errores = 0;

        if (desc1.value.trim() === '' || isNaN(desc1.value)) {
            desc1.classList.add('is-invalid');
            desc1.nextElementSibling.nextElementSibling.textContent = 'El descuento debe ser una cantidad numérica.';
            errores += 1;
        } else if (parseFloat(desc1.value) < 0) {
            desc1.classList.add('is-invalid');
            desc1.nextElementSibling.nextElementSibling.textContent = 'El descuento no puede ser negativo.';
            errores += 1;
        } else if (parseFloat(desc1.value) > producto['precio']) {
            desc1.classList.add('is-invalid');
            desc1.nextElementSibling.nextElementSibling.textContent = 'La cantidad de descuento a aplicar no puede ser mayor al precio del producto.';
            errores += 1;
        } else {
            desc1.classList.remove('is-invalid');
            desc2.value = calcularPorcentajeDescuento(producto['precio'], desc1.value);
        }
        return errores;
    }

    const validarDesc2 = () => {
        let errores = 0;

        if (desc2.value.trim() === '' || isNaN(desc2.value)) {
            desc2.classList.add('is-invalid');
            desc2.nextElementSibling.nextElementSibling.textContent = 'El descuento debe ser una cantidad numérica.';
            errores += 1;
        } else if (parseFloat(desc2.value) < 0 || parseFloat(desc2.value) > 100) {
            desc2.classList.add('is-invalid');
            desc2.nextElementSibling.nextElementSibling.textContent = 'El porcentaje de descuento debe estar entre 0% y 100%';
            errores += 1;
        } else {
            desc2.classList.remove('is-invalid');
            desc1.value = calcularDescuentoEnDinero(producto['precio'], desc2.value);
        }
        return errores;
    }

    const activarBotonDescuento = (validacion) => {
        let errores = 0;
        errores += validacion;

        if (errores > 0) {
            btnDescuento.disabled = true;
        } else {
            btnDescuento.disabled = false;
        }
    }

    // Se validan los inputs con los datos que traen de la fila del producto
    validarDesc1();
    validarDesc2();

    desc1.addEventListener('keyup', () => {
        activarBotonDescuento(validarDesc1());
    });

    desc2.addEventListener('keyup', () => {
        activarBotonDescuento(validarDesc2());
    });

    btnDescuento.onclick = () => {
        // Asignando el valor del porcentaje de descuento al boton de la fila del producto
        let datosProducto = producto['input'].value.split(';');
        datosProducto[3] = (parseFloat(desc2.value) / 100).toFixed(2);
        producto['input'].value = datosProducto.join(';');
        producto['descuento'].nodeValue = desc2.value;
        producto['subtotal'].textContent = `$${calcularSubtotal(producto['precio'], desc2.value / 100, producto['cantidad'])}`;
        calcularTotal();
        desc1.value = '';
        desc2.value = '';
    };
};


document.addEventListener('DOMContentLoaded', () => {
    let buffer = '';
    let lastTime = Date.now();

    document.addEventListener('keydown', (e) => {
        const currentTime = Date.now();
        const diff = currentTime - lastTime;

        // Si ha pasado mucho tiempo entre teclas, reinicia el buffer
        if (diff > 100) {
            buffer = '';
        }

        lastTime = currentTime;

        // Enter indica el fin del escaneo
        if (e.key === 'Enter') {
            const codigo = buffer.trim();
            if (codigo) {
                console.log('Código leído:', codigo);
                buscarProductoPorCodigo(codigo);
            }
            buffer = ''; // Reset
        } else {
            buffer += e.key;
        }
    });
});


// Actualización del subtotal por fila y total general
document.addEventListener('input', e => {
    if (e.target.matches('.cantidad')) {
        const fila = e.target.closest('tr');
        calcularSubtotalFila(fila);
        calcularTotal();
    }
});

document.addEventListener('click', e => {
    if (e.target.matches('.btn-eliminar')) {
        e.target.closest('tr').remove();
        calcularTotal();
    }
});

function calcularTotal() {
    let total = 0;
    document.querySelectorAll('.subtotal').forEach(el => {
        total += parseFloat(eliminarSignoDolar(el.textContent));
    });
    inputTotal.value = total.toFixed(2);
    inputMonto.disabled = total === 0;
}

function calcularCambio(total, monto) {
    inputCambio.value = (monto - total).toFixed(2);
}

// ... resto de los eventos como monto, cliente, botones agregar, etc. se mantienen igual
function eliminarSignoDolar(valor) {
    return valor.replace('$', '');
}
const eliminarPorcentaje = porcentaje => porcentaje.replace('%', '');

const calcularSubtotal = (precio, descuento, cantidad) => (precio * (1 - descuento) * cantidad).toFixed(2);
const calcularDescuentoEnDinero = (precio, porcentajeDescuento) => ((porcentajeDescuento * precio) / 100).toFixed(2);


function sumarProductosExistentes(producto) {
    let productosAgregados = document.querySelectorAll('.id-producto-agregado'),
        datos, nuevaCantidad, datosProducto,
        idProducto = producto.cod_bar,
        precio = parseFloat(producto.precio),
        descuento = (producto.descuento / 100).toFixed(2),
        existeProducto = false;



    for (let i = 0; i < productosAgregados.length; i++) {

        if (productosAgregados[i].textContent.trim() == idProducto) {
            existeProducto = true;
            datos = datosFila(productosAgregados[i].parentNode, ['cantidad-agregada', 'subtotal', 'input-producto']);
            nuevaCantidad = parseInt(datos['cantidad-agregada'].firstElementChild.firstElementChild.value) + 1;
            datos['cantidad-agregada'].firstElementChild.firstElementChild.value = nuevaCantidad;
            datos['subtotal'].textContent = '$' + calcularSubtotal(precio, descuento, nuevaCantidad);
            // Actualizando cantidad de producto en el input de tipo hidden
            datosProducto = datos['input-producto'].value.split(';')
            // Cantidad almacenada de producto
            datosProducto[1] = nuevaCantidad;
            datos['input-producto'].value = datosProducto.join(';');
            break;
        }
    }

    return existeProducto;
}

function datosFila(fila, elementos_busqueda) {
    let resultados = [];

    for (const campo of fila.children) {
        for (const elemento of elementos_busqueda) {
            if (campo.className.includes(elemento)) {
                resultados[elemento] = campo;
                continue;
            }
        }
    };

    return resultados;
}


function eliminarProducto(botonAccionado) {
    filaProducto = botonAccionado.parentNode.parentNode;
    filaProducto.remove();
}


