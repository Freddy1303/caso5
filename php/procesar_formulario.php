<?php
require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Variables del formulario
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $asunto = $_POST["asunto"];
    $mensaje = $_POST["mensaje"];

    
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
        $mail->addAddress($email,$nombre ); // Dirección de correo electrónico del destinatario principal
        $mail->addCC($email);
        
        // Construir el mensaje
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = $mensaje;
        
        // Enviar correo electrónico
        $mail->send();
        
        // Mostrar alerta de éxito
        echo '<script>alert("Formulario enviado correctamente");</script>';
        header("Location: ../index.html");
    } catch (Exception $e) { 
        // Mostrar alerta de error
        echo '<script>alert("Error al enviar el formulario. Por favor, inténtalo de nuevo más tarde.");</script>';
        header("Location: ../index.html");
    }
} else {
    // Redireccionar si el método de solicitud no es POST
    header("Location: ../index.html");
    exit();
}
?>
