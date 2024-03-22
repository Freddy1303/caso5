<?php
require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

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
    
    // Configuración de correo electrónico
    $mail = new PHPMailer(true);
    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.zoho.com'; // Servidor SMTP de Zoho Mail
        $mail->SMTPAuth   = true;
        $mail->Username   = 'josueccenta@creativiq.site'; // Tu dirección de correo electrónico de Zoho Mail
        $mail->Password   = 'z5gJtze1UAsy'; // Tu contraseña de Zoho Mail
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587; // Puerto SMTP de Zoho Mail
        
        // Destinatario principal
        $mail->setFrom('josueccenta@creativiq.site', 'GRUPO 1');
        $mail->addAddress($email, $nombre); // Dirección de correo electrónico del destinatario principal
        $mail->addCC($email);
        
        // Construir el mensaje
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = $mensaje;

        // Agrega el archivo adjunto al correo electrónico, si se proporcionó uno
        if (isset($adjunto_tmp) && isset($adjunto_nombre)) {
            $mail->addAttachment($adjunto_tmp, $adjunto_nombre);
        }
        
        // Enviar correo electrónico
        $mail->send();
        
        // Agregar información de éxito a la respuesta
        $response['status'] = 'success';
        $response['message'] = 'Formulario enviado correctamente';
    } catch (Exception $e) { 
        // Agregar información de error a la respuesta
        $response['status'] = 'error';
        $response['message'] = 'Error al enviar el formulario. Por favor, inténtalo de nuevo más tarde.';
    }
} else {
    // Si el formulario no fue enviado por POST, agregar información de error a la respuesta
    $response['status'] = 'error';
    $response['message'] = 'El formulario no se envió correctamente.';
}

// Devolver la respuesta como JSON
echo json_encode($response);
?>