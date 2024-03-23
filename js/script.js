// Captura el evento de envío del formulario
$('#contactForm').submit(function(event) {
    event.preventDefault(); // Evita el comportamiento predeterminado del formulario

    var formData = new FormData(this); // Recolecta los datos del formulario

    // Desactivar el botón de enviar para evitar clics repetidos
    $('#contactForm input[type="submit"]').prop('disabled', true);

    var xhr = new XMLHttpRequest(); // Crea una nueva solicitud AJAX

    xhr.open('POST', $(this).attr('action'), true); // Configura la solicitud AJAX

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
            // Parsea la respuesta del servidor
            var response = JSON.parse(xhr.responseText);
            if (response.status === 'success') {
                // Muestra un SweetAlert de éxito
                Swal.fire({
                    title: 'Éxito',
                    text: 'Formulario enviado correctamente',
                    icon: 'success'
                }).then((result) => {
                    // Si se hace clic en el botón "OK", recargar la página
                    if (result.isConfirmed) {
                        // Limpiar los campos del formulario
                        $('#contactForm')[0].reset();
                    }
                });
            } else {
                // Muestra un SweetAlert de error si hay algún problema
                Swal.fire('Error', response.message, 'error');
            }
        }
        // Habilitar nuevamente el botón de enviar después de recibir la respuesta del servidor
        $('#contactForm input[type="submit"]').prop('disabled', false);
    };

    xhr.send(formData); // Envía la solicitud AJAX con los datos del formulario
});

// Limpia los campos del formulario al hacer clic en el botón "Limpiar"
$('#limpiarFormulario').click(function() {
    $('#contactForm')[0].reset();
});