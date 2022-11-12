<select name="cantidad" id="cantidad" class="mdb-select md-form mb-4" searchable="buscar..." required >
    <option value="">Seleccione cantidad</option>

   @for($i = 1; $i <= $producto->cantidad2; $i++)
    <option value="{{$i}}">{{$i}}</option>

   @endfor


</select>

