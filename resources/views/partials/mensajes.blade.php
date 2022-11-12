@if (session()->has('success'))
    @php
        echo "<script type=\"text/javascript\">
                mensajeFlash('success', '" . session('success') . "');
            </script>";
    @endphp
@endif

@if (session()->has('error'))
    @php
        echo "<script type=\"text/javascript\">
                mensajeFlash('error', '" . session('error') . "');
            </script>";
    @endphp
@endif