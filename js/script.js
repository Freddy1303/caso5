// script.js
document.getElementById('contactForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Evita el comportamiento predeterminado del formulario
    
    var formData = new FormData(this); // Recolecta los datos del formulario
    
    var xhr = new XMLHttpRequest(); // Crea una nueva solicitud AJAX
    
    xhr.open('POST', this.getAttribute('action'), true); // Configura la solicitud AJAX
    
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
            // Maneja la respuesta del servidor (opcional)
            var response = JSON.parse(xhr.responseText);
            if (response.status === 'success') {
                // Muestra un SweetAlert de éxito
                Swal.fire('Éxito', '¡Formulario enviado correctamente!', 'success');
            } else {
                // Muestra un SweetAlert de error si hay algún problema
                Swal.fire('Error', 'Hubo un problema al enviar el formulario', 'error');
            }
        }
    };
    
    xhr.send(formData); // Envía la solicitud AJAX con los datos del formulario
});
