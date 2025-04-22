$('#paginacion').DataTable({
    language: {
        'decimal': '',
        'emptyTable': 'No hay información',
        'info': 'Mostrando _START_ a _END_ de _TOTAL_ registros',
        'infoEmpty': 'Mostrando 0 to 0 of 0 Entradas',
        'infoFiltered': '(Filtrado de _MAX_ total entradas)',
        'infoPostFix': '',
        'thousands': ',',
        'lengthMenu': 'Mostrar _MENU_ registros',
        'loadingRecords': 'Cargando...',
        'processing': 'Procesando...',
        'search': 'Buscar:',
        'zeroRecords': 'Sin resultados encontrados',
        'paginate': {
            'first': 'Primero',
            'last': 'Último',
            'next': 'Siguiente',
            'previous': 'Anterior'
        }
    },
    // Configuración responsive para ajustar el tamaño de fuente y columnas
    responsive: true,
    initComplete: function (settings, json) {
        if (window.matchMedia('(max-width: 1024px)').matches) {
            $(this).css('font-size', '12px');
        }

        // Agregar listener para cambios de tamaño de pantalla
        window.addEventListener('resize', () => {
            if (window.matchMedia('(max-width: 1024px)').matches) {
                $(this).css('font-size', '12px');
            } else {
                $(this).css('font-size', ''); // Restaurar tamaño original
            }
        });
    }
});


$('#paginacion2').DataTable({
    language: {
        'decimal': '',
        'emptyTable': 'No hay información',
        'info': 'Mostrando _START_ a _END_ de _TOTAL_ registros',
        'infoEmpty': 'Mostrando 0 to 0 of 0 Entradas',
        'infoFiltered': '(Filtrado de _MAX_ total entradas)',
        'infoPostFix': '',
        'thousands': ',',
        'lengthMenu': 'Mostrar _MENU_ registros',
        'loadingRecords': 'Cargando...',
        'processing': 'Procesando...',
        'search': 'Buscar:',
        'zeroRecords': 'Sin resultados encontrados',
        'paginate': {
            'first': 'Primero',
            'last': 'Último',
            'next': 'Siguiente',
            'previous': 'Anterior'
        }
    },
    // Configuración responsive para ajustar el tamaño de fuente y columnas
    responsive: true,
    initComplete: function (settings, json) {
        if (window.matchMedia('(max-width: 1024px)').matches) {
            $(this).css('font-size', '12px');
        }

        // Agregar listener para cambios de tamaño de pantalla
        window.addEventListener('resize', () => {
            if (window.matchMedia('(max-width: 1024px)').matches) {
                $(this).css('font-size', '12px');
            } else {
                $(this).css('font-size', ''); // Restaurar tamaño original
            }
        });

        // Agregar filtro de tipo de venta
        var table = $('#paginacion2').DataTable();
        var select = $('<select class="form-select form-select-sm ms-2" style="width: 200px; display: inline-block;"><option value="">Todos los tipos</option><option value="Consumidor final">Consumidor final</option><option value="Crédito fiscal">Crédito fiscal</option></select>')
            .appendTo($('.dataTables_filter'))
            .on('change', function () {
                var val = $(this).val();
                table.column(1)
                    .search(val)
                    .draw();
            });
    }
});
