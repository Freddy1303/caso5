document.getElementById('contactForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Evita el comportamiento predeterminado del formulario
    
    var formData = new FormData(this); // Recolecta los datos del formulario
    
    var xhr = new XMLHttpRequest(); // Crea una nueva solicitud AJAX
    
    xhr.open('POST', this.getAttribute('action'), true); // Configura la solicitud AJAX
    
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
            // Maneja la respuesta del servidor
            var response = JSON.parse(xhr.responseText);
            if (response.status === 'success') {
                // Muestra un SweetAlert de éxito
                Swal.fire({
                    title: 'Éxito',
                    text: response.message,
                    icon: 'success'
                });
            } else {
                // Muestra un SweetAlert de error si hay algún problema
                Swal.fire({
                    title: 'Error',
                    text: response.message,
                    icon: 'error'
                });
            }
        }
    };
    
    xhr.send(formData); // Envía la solicitud AJAX con los datos del formulario
});
