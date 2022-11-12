<select name="producto" id="result" class="mdb-select md-form mb-4" searchable="buscar..." required>
    <option value="0">Seleccione un producto a agregar</option>
    @foreach ($productos as $item)
        <option value="{{$item->cod_bar}}" data-secondary-text="{{$item->cod_bar}}">{{$item->producto}} ${{round($item->precio,2)}} / {{$item->unidad_medida}}</option>

    @endforeach

</select>

<script>

    $('#result').change(function(e) {
        e.preventDefault();
        filt();
    });

</script>