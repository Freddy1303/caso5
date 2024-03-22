// Captura el evento de envío del formulario
$('#contactForm').submit(function(event) {
    event.preventDefault(); // Evita el comportamiento predeterminado del formulario
    
    var formData = new FormData(this); // Recolecta los datos del formulario
    
    var xhr = new XMLHttpRequest(); // Crea una nueva solicitud AJAX
    
    xhr.open('POST', $(this).attr('action'), true); // Configura la solicitud AJAX
    
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
            // Maneja la respuesta del servidor después de un tiempo de espera de 500 ms
            setTimeout(function() {
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
                            location.reload(); 
                        }
                    });
                } else {
                    // Muestra un SweetAlert de error si hay algún problema
                    Swal.fire('Error', response.message, 'error');
                }
            }, 100); // Tiempo de espera antes de mostrar el SweetAlert
        }
    };
    
    xhr.send(formData); // Envía la solicitud AJAX con los datos del formulario
});
