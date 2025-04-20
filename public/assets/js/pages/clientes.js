const chk = document.querySelector('#chk-credito-fiscal');
const creditoFiscal = document.querySelector('#credito_fiscal');
const dui = document.querySelector('#dui');
const municipio = document.querySelector('#municipio');
const departamento = document.querySelector('#departamento');
const direccion = document.querySelector('#direccion');
const creditoFiscalDiv = document.querySelector('#credito_fiscal_div');
const nrcDiv = document.querySelector('#nrc_div');
const correo = document.querySelector('#correo');
const telefono = document.querySelector('#telefono');
const actividadEconomica = document.querySelector('#actividad_economica');
const chkCreditoHidden = document.querySelector('#chk_credito_hidden');
const actividadEconomicaDiv = document.querySelector('#actividad_economica_div');

const activarCreditoFiscal = () => {
    if (chk.checked) {
        creditoFiscal.disabled = false;
        creditoFiscal.required = true;
        creditoFiscalDiv.style.display = 'block';
        nrc.disabled = false;
        nrc.required = true;
        nrcDiv.style.display = 'block';
        dui.disabled = true;
        dui.required = false;
        municipio.required = true;
        departamento.required = true;
        direccion.required = true;
        correo.required = true;
        telefono.required = true;
        chkCreditoHidden.value = 1;
        actividadEconomica.disabled = false;
        actividadEconomica.required = true;
        actividadEconomicaDiv.style.display = 'block';


    } else {
        creditoFiscal.disabled = true;
        creditoFiscal.required = false;
        creditoFiscalDiv.style.display = 'none';

        nrc.disabled = true;
        nrc.required = false;
        nrcDiv.style.display = 'none';
        dui.disabled = false;
        municipio.required = false;
        departamento.required = false;
        direccion.required = false;
        correo.required = false;
        telefono.required = false;
        chkCreditoHidden.value = 0;
        actividadEconomica.disabled = true;
        actividadEconomica.required = false;
        actividadEconomicaDiv.style.display = 'none';
    }
}

const obtenerMunicipios = () => {
    const departamento = document.querySelector('#departamento').value;
    fetch(`${window.location.origin}/obtener-municipios?id_departamento=${departamento}`)
        .then(response => response.json())
        .then(data => {
            const municipios = document.querySelector('#municipio');
            municipios.innerHTML = '';
            municipios.innerHTML = '<option value="">Seleccione un municipio</option>';
            data.forEach(municipio => {
                municipios.innerHTML += `<option value="${municipio.codigo_municipio}">${municipio.nombre_municipio}</option>`;
            });
            municipios.disabled = false;
        })
        .catch(error => console.error('Error:', error));
}


activarCreditoFiscal();
chk.addEventListener('click', activarCreditoFiscal);
departamento.addEventListener('change', obtenerMunicipios);

document.getElementById('form-cliente').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const form = this;

    fetch('/addCliente', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        }
    })
        .then(response =>
            response.json())
        .then(data => {
            console.log(data);
            if (data.success) {
                table = document.querySelector('#paginacion')
                if (table) {
                    const newRow = document.createElement('tr');
                    newRow.innerHTML = `
                        <td>${data.cliente.nombre}</td>
                        <td>${data.cliente.tipo_cliente === 1 ? 'Consumidor final' : 'Crédito fiscal'}</td>
                        <td>Activo</td>
                        <td>
                            <div class="d-flex">
                                <a href="/modCliente/${data.cliente.id}"
                                    class="btn btn-success btn-sm">
                                    <i class="fa-regular fa-pen-to-square me-2"></i>
                                    Editar
                                </a>
                                <form action="/clientes/eliminar/${data.cliente.id}" method="POST" class="d-none" id="frm-eliminar-${data.cliente.id}">
                                    @method('DELETE')
                                    @csrf
                                </form>
                                <button type="submit" class="btn btn-sm btn-danger ms-2 btn-eliminar" form="frm-eliminar-${data.cliente.id}">
                                    <i class="fa-solid fa-trash-can me-2"></i>
                                    Eliminar     
                                </button>
                            </div>
                        </td>
                    `;
                    table.querySelector('tbody').appendChild(newRow);
                }
                else {
                    const selectCliente = document.querySelector('#cliente');
                    if (selectCliente) {
                        const option = document.createElement('option');
                        option.value = data.cliente.id;

                        option.textContent = data.cliente.nombre;
                        selectCliente.appendChild(option);
                        // Seleccionar la nueva opción agregada
                        option.selected = true;
                        // Disparar evento change para actualizar cualquier listener
                        selectCliente.dispatchEvent(new Event('change'));

                        // Cerrar el modal después de agregar la opción
                        const modal = document.querySelector('#modal-nuevo-cliente');
                        const modalInstance = bootstrap.Modal.getInstance(modal);
                        if (modalInstance) {
                            modalInstance.hide();
                        }
                    }
                    else {
                        // Cerrar el modal si existe
                        const modal = document.querySelector('#modal-nuevo-cliente');
                        const modalInstance = bootstrap.Modal.getInstance(modal);
                        if (modalInstance) {
                            modalInstance.hide();
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un error al guardar el cliente'
                        });
                    }
                }

                // Mostrar mensaje de éxito al final
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: data.mensaje
                });

                // Limpiar formulario después de éxito
                form.reset();

            } else {
                // Cerrar el modal si existe
                const modal = document.querySelector('#modal-nuevo-cliente');
                const modalInstance = bootstrap.Modal.getInstance(modal);
                if (modalInstance) {
                    modalInstance.hide();
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.mensaje
                });
                // Limpiar formulario después de error
                form.reset();
            }
        })
        .catch(error => {
            console.error('Error:', error);

            // Cerrar el modal si existe
            const modal = document.querySelector('#modal-nuevo-cliente');
            const modalInstance = bootstrap.Modal.getInstance(modal);
            if (modalInstance) {
                modalInstance.hide();
            }

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un error al procesar la solicitud'
            });
            // Limpiar formulario después de error
            form.reset();
        });
});

function resetForm() {
    // Limpiar campos de texto
    document.getElementById('nombre').value = '';
    document.getElementById('telefono').value = '';
    document.getElementById('correo').value = '';
    document.getElementById('dui').value = '';
    document.getElementById('credito_fiscal').value = '';
    document.getElementById('nrc').value = '';
    document.getElementById('direccion').value = '';

    // Restablecer selects
    document.getElementById('departamento').value = '';
    document.getElementById('municipio').value = '';
    document.getElementById('municipio').disabled = true;
}
$(document).ready(function () {

    // Reinicializar select2 cuando se abre el modal
    if ($('#modal-nuevo-cliente').length) {

        $('#actividad_economica').select2({
            placeholder: "Seleccione una actividad económica",
            allowClear: true,
            width: '100%',
            dropdownParent: $('#modal-nuevo-cliente'),
            zIndex: 100002
        });

        $('#modal-nuevo-cliente').on('shown.bs.modal', function () {
            $('#actividad_economica').select2({
                placeholder: "Seleccione una actividad económica",
                allowClear: true,
                width: '100%',
                dropdownParent: $('#modal-nuevo-cliente'),
                zIndex: 100002
            });
        });
    }
    else {
        $('#actividad_economica').select2({
            placeholder: "Seleccione una actividad económica",
            allowClear: true,
            width: '100%',
        });
    }
});