<?php
require '../MailerSend/MailerSend.php';
require '../MailerSend/Helpers/Builder/EmailParams.php';
require '../MailerSend/Helpers/Builder/Recipient.php';

use MailerSend\MailerSend;
use MailerSend\Helpers\Builder\Recipient;
use MailerSend\Helpers\Builder\EmailParams;

// Array para almacenar la respuesta
$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Variables del formulario
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $asunto = $_POST["asunto"];
    $mensaje = $_POST["mensaje"];

    // Verifica si se cargó un archivo
    if (isset($_FILES['adjunto']) && $_FILES['adjunto']['error'] === UPLOAD_ERR_OK) {
        // Ruta temporal del archivo cargado
        $adjunto_tmp = $_FILES['adjunto']['tmp_name'];

        // Nombre del archivo original
        $adjunto_nombre = $_FILES['adjunto']['name'];
    }

    // Configuración de MailerSend
    $mailerSend = new MailerSend(['api_key' => 'your_api_key']);

    // Configuración de los destinatarios
    $recipients = [
        new Recipient($email, $nombre)
    ];

    // Configuración de los parámetros del correo electrónico
    $emailParams = (new EmailParams())
        ->setFrom('josueccenta@creativiq.site') // Cambia 'your@domain.com' por tu dirección de correo electrónico
        ->setFromName('GRUPO 1') // Cambia 'Your Name' por tu nombre o el nombre de tu empresa
        ->setRecipients($recipients)
        ->setSubject($asunto)
        ->setHtml($mensaje) // Utiliza el contenido HTML del mensaje
        ->setText(strip_tags($mensaje)); // Utiliza una versión de solo texto del mensaje para clientes de correo que no admiten HTML

    // Envía el correo electrónico
    try {
        $mailerSend->email->send($emailParams);

        // Agregar información de éxito a la respuesta
        $response['status'] = 'success';
        $response['message'] = 'Formulario enviado correctamente';
    } catch (Exception $e) { 
        // Agregar información de error a la respuesta
        $response['status'] = 'error';
        $response['message'] = 'Error al enviar el formulario: ' . $e->getMessage();
    }
} else {
    // Si el formulario no fue enviado por POST, agregar información de error a la respuesta
    $response['status'] = 'error';
    $response['message'] = 'El formulario no se envió correctamente.';
}

// Devolver la respuesta como JSON
echo json_encode($response);
?>
