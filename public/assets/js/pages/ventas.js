let btnsAgregarProducto = document.querySelectorAll('.agregar-producto'),
    btnsEliminarProducto = document.querySelectorAll('.eliminar-producto'),
    chkCliente = document.querySelector('#chk-cliente'),
    cliente = document.querySelector('#cliente'),
    clienteNuevo = document.querySelector('#cliente-nuevo'),
    inputMonto = document.querySelector('#monto'),
    inputCambio = document.querySelector('#cambio'),
    btnVenta = document.querySelector('#realizar-venta'),
    inputTotal = document.querySelector('#total');

function soloNumerosEnterosPositivos(valor) {
    let regEx = /^[1-9][0-9]{0,}$/;
    return regEx.test(valor);
}

function soloNumerosPositivos(valor) {
    let regEx = /^[0-9]+(.[0-9]{1,2})?$/;
    return regEx.test(valor);
}

function eliminarSignoDolar(valor) {
    return valor.replace('$', '');
}

function calcularSubtotal(precio, descuento, cantidad) {
    return (precio * (1 - descuento) * cantidad).toFixed(2);
}

function calcularTotal() {
    let subtotales = document.querySelectorAll('.subtotal'), total = 0;

    subtotales.forEach(subtotal => {
        total += parseFloat(eliminarSignoDolar(subtotal.textContent));
    });

    inputTotal.value = total.toFixed(2);

    if (total == 0) {
        inputMonto.disabled = true;
    } else {
        inputMonto.disabled = false;
    }
}

function calcularCambio(total, monto) {
    inputCambio.value = (monto - total).toFixed(2);
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

function sumarProductosExistentes(producto) {
    let productosAgregados = document.querySelectorAll('.id-producto-agregado'),
        datos, nuevaCantidad, datosProducto,
        idProducto = producto['id-producto'].textContent.trim(),
        precio = parseFloat(eliminarSignoDolar(producto['precio'].textContent)),
        descuento = (eliminarPorcentaje(producto['descuento'].textContent) / 100).toFixed(2),
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

function crearInput(tipo, clase, name, valor) {
    const input = document.createElement('input');
    input.type = tipo;
    input.className = clase;

    if (name !== null) input.name = name;
    if (valor !== null) input.value = valor;
    return input;
}

function crearElemento(tipo, clase, contenido) {
    const elemento = document.createElement(tipo);

    if (clase !== null)  elemento.className = clase;
    if (contenido !== null) elemento.textContent = contenido;
    return elemento;
}

const calcularPorcentajeDescuento = (precio, descuento) => {
    return ((descuento * 100 ) / precio).toFixed(2);
};

const calcularDescuentoEnDinero = (precio, porcentajeDescuento) => {
    return ((porcentajeDescuento * precio) / 100).toFixed(2);
};

const eliminarPorcentaje = (porcentaje) => {
    return porcentaje.replace('%', '');
};

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
        } else if (parseFloat(desc2.value) < 0  || parseFloat(desc2.value) > 100) {
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
        producto['subtotal'].textContent = `$${calcularSubtotal(producto['precio'], desc2.value/100, producto['cantidad'])}`;
        calcularTotal();
        desc1.value = '';
        desc2.value = '';
    };
};

function agregarProducto(producto) {
    if (!sumarProductosExistentes(producto)) {
        let cuerpoTabla = document.querySelector('#tb-productos-agregados tbody'),
            tr = document.createElement('tr'),
            precio = parseFloat(eliminarSignoDolar(producto['precio'].textContent)),
            descuento = (eliminarPorcentaje(producto['descuento'].textContent) / 100).toFixed(2),
            td0 = crearElemento('td', 'id-producto-agregado', producto['id-producto'].textContent),
            td1 = crearElemento('td', 'cantidad-agregada', null),
            td2 = crearElemento('td', null, producto['producto'].textContent),
            td3 = crearElemento('td', 'descuento', null),
            td4 = crearElemento('td', 'subtotal', `$${calcularSubtotal(precio, descuento, 1)}`),
            td5 = document.createElement('td'),
            div = crearElemento('div', 'div-cantidad', null),
            inputCantidad = crearInput('number', 'form-control cantidad', null, 1),
            button = crearElemento('button', 'eliminar-producto', null),
            btnDescuento = crearElemento('button', 'btn-descuento', null),
            iconoDescuento = crearElemento('i', 'fa-solid fa-percent ms-2', null),
            porcentaje = document.createTextNode(eliminarPorcentaje(producto['descuento'].textContent)),
            inputHidden = crearInput('hidden', 
                'input-producto', 
                `producto[${producto['id-producto'].textContent}]`,
                `${producto['id-producto'].textContent};1;${precio};${descuento}`),
            i = crearElemento('i', 'fa-solid fa-trash-can', null),
            datosProducto;

        inputCantidad.min = 0;
        div.appendChild(inputCantidad);
        td1.appendChild(div);
        button.type = 'button';
        button.appendChild(i);
        btnDescuento.type = 'button';
        btnDescuento.id = `btn-descuento-${producto['id-producto'].textContent}`;
        btnDescuento.setAttribute('data-bs-toggle', 'modal');
        btnDescuento.setAttribute('data-bs-target', '#modal-descuento');
        btnDescuento.appendChild(porcentaje);
        btnDescuento.appendChild(iconoDescuento);
        td3.appendChild(btnDescuento);
        td5.appendChild(button);
        tr.appendChild(td0);
        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        tr.appendChild(td4);
        tr.appendChild(td5);
        tr.appendChild(inputHidden);

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
            td4.textContent = '$' + calcularSubtotal(precio, datosProducto[3] , inputCantidad.value);
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
                nombre: producto['producto'].textContent, 
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

btnsAgregarProducto.forEach(boton => {
    boton.addEventListener('click', () => {

        let datos = datosFila(boton.parentNode.parentNode, [
            'id-producto', 
            'producto', 
            'precio',
            'descuento'
        ]);

        agregarProducto(datos);
    });
});

chkCliente.addEventListener('click', () => {
    if (chkCliente.checked) {
        clienteNuevo.disabled = false;
        cliente.disabled = true;
    } else {
        clienteNuevo.disabled = true;
        cliente.disabled = false;
    }
});



