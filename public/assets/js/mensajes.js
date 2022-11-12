function mensajeFlash(tipo, mensaje) {
    Swal.fire({
        icon: tipo,
        title: mensaje,
        showConfirmButton: false,
        timer: 1500
    });
}
