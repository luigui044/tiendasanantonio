const btnsEliminar = document.querySelectorAll('.btn-eliminar');

btnsEliminar.forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.preventDefault();
        Swal.fire({
            title: "¿Desea eliminar este cliente?",
            showDenyButton: true,
            confirmButtonText: "Sí",
        }).then((result) => {
            if (result.isConfirmed) {
                const frmEliminar = document.querySelector(`#${e.target.getAttribute('form')}`);
                frmEliminar.submit();
            } 
        });
    });
});


