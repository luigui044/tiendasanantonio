<tr id="row{{$producto->id_prod}}">
    <td  >

    <input readonly type="text" value="{{$producto->id_prod}}"  name="idProd[]" id="idProd"class="form-control"></td>
    <td>
        <input readonly  type="text" value="{{$producto->producto}}" name="producto[]" id="producto" class="form-control">
    </td>
    <td>
        <input readonly  type="text" value="{{round($producto->precio,2)}}" name="precio[]" id="preciocantidad2{{$producto->id_prod}}" class="form-control">
    </td>

    <td>
        <input type="text" value="{{$cantidad}}" name="cantidad2[]" id="cantidad2{{$producto->id_prod}}" class="form-control canti {{ $codBar }}">
    </td>

    <td>
        <input readonly type="text" value="{{round($producto->precio*$cantidad,2)}}" name="subtotal[]" id="subtotalcantidad2{{$producto->id_prod}}" class="sTotal form-control">
    </td>
    <td>
        <button type="button" id="{{$producto->id_prod}}" class="btn btn-sm btn-danger btn-remove">X</button>
    </td>
</tr>  


@include('partials.footer')





