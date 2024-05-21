<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function encrypt($message, $key)
{
    return openssl_encrypt($message, 'aes-256-cbc', $key, 0, str_repeat('0', 16));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $key = $_POST['key'];
    $message = $_POST['message'];
    $email = $_POST['email'];

    $encryptedMessage = encrypt($message, $key);

    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'camilatefa2542@gmail.com'; // Reemplaza con tu correo
        $mail->Password = 'bkuq zech xxnx moga'; // Reemplaza con tu contraseña de aplicación
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Destinatarios
        $mail->setFrom('camilatefa2542@gmail.com', 'Encriptador');
        $mail->addAddress($email);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Mensaje Encriptado';
        $mail->Body = "Clave: $key<br>Mensaje Encriptado: $encryptedMessage";

        $mail->send();
        echo 'El mensaje ha sido enviado';
    } catch (Exception $e) {
        echo "El mensaje no pudo ser enviado. Error de Mailer: {$mail->ErrorInfo}";
    }
}
?>