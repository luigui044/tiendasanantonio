    @if ($show)
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Agregar productos</h4>
            </div>

        <div class="card-content">
            <div class="card-body">
                
                <div class="table-responsive">
                    <!--Table-->
                    <table id="paginacion" class="table table-sm table-hover">
                        <!--Table head-->
                        <thead>
                            <tr>
                                <th class="d-none">
                                    ID
                                </th>
                                <th class="th-sm d-none">
                                    Producto
                                </th>
                                <th class="th-sm d-none">
                                    Categoría
                                </th>
                                <th class="th-sm d-none">
                                    Precio ($)
                                </th>
                                <th class="th-sm d-none">
                                    Descuento (%)
                                </th>
                                <th class="th-sm d-none">
                                    Código de barras
                                </th>
                                <th class="th-sm text-center">
                                    Producto
                                </th>
                                <th class="th-sm text-center">
                                    Agregar
                                </th>
                            </tr>
                        </thead>
                        <!--Table head-->
                        <!--Table body-->
                        <tbody>
                            @foreach ($productos as $producto)
                                <tr class="fila-producto">
                                    <td class="id-producto">{{ $producto->id_prod }}</td>
                                    <td class="producto" id="d-none">{{ $producto->producto }}</td>
                                    <td id="d-none">{{ $producto->categoria }}</td>
                                    <td class="precio" id="d-none">${{ number_format($producto->precio, 2) }}</td>
                                    <td class="descuento" id="d-none">
                                        {{ number_format($producto->descuento * 100, 2) }}%
                                    </td>
                                    <td id="d-none">{{ $producto->cod_bar }}</td>
                                    <td>
                                        <div class="info-producto">
                                            <p class="titulo">{{ $producto->producto }}</p>
                                            <p class="categoria"><b>Categoría:</b> {{ $producto->categoria }}</p>
                                            <p class="info-precio">Precio: ${{ number_format($producto->precio, 2) }}</p>
                                            <p class="info-desc">Descuento:
                                                {{  number_format($producto->descuento * 100, 2) }}%</p>
                                            <p class="cod"><b>Código:</b> {{ $producto->cod_bar }}</p>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <button type="button" class="agregar-producto">
                                            <i class="fa-solid fa-circle-plus"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <!--Table body-->
                    </table>
                    <!--Table-->
                </div>
            </div>
        </div>
    </div>
@endif
