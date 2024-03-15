<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Variables del formulario
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $asunto = $_POST["asunto"];
    $mensaje = $_POST["mensaje"];

    // Dirección de correo electrónico a la que enviar el formulario
    $destinatario = "tucorreo@dominio.com"; // Reemplaza con tu dirección de correo electrónico

    // Dirección de correo electrónico del remitente (para el campo "Reply-To" o "From")
    $remitente = $email;

    // Construir el mensaje
    $contenido = "Nombre: $nombre\n";
    $contenido .= "Email: $email\n";
    $contenido .= "Asunto: $asunto\n";
    $contenido .= "Mensaje:\n$mensaje\n";

    // Enviar correo electrónico al destinatario principal
    $enviado_destinatario = mail($destinatario, $asunto, $contenido);

    // Enviar una copia del correo electrónico al remitente
    $enviado_remitente = mail($remitente, $asunto, $contenido);

    // Comprobar si se enviaron ambos correos electrónicos correctamente
    if ($enviado_destinatario && $enviado_remitente) {
        // Mostrar una alerta emergente de "Enviado correctamente"
        echo '<script>alert("Formulario enviado correctamente");</script>';
    } else {
        // Si hubo un error al enviar los correos electrónicos, muestra un mensaje de error
        echo '<script>alert("Error al enviar el formulario. Por favor, inténtalo de nuevo más tarde.");</script>';
    }
}else {
    // Si el método de solicitud no es POST, redireccionar a la página de formulario
    header("Location: index.php");
    exit();
}

