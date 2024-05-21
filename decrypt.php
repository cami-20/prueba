<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function decrypt($encryptedMessage, $key)
{
    return openssl_decrypt($encryptedMessage, 'aes-256-cbc', $key, 0, str_repeat('0', 16));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $key = $_POST['key'];
    $encryptedMessage = $_POST['encryptedMessage'];
    $email = $_POST['email'];

    $decryptedMessage = decrypt($encryptedMessage, $key);

    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'camilatefa2542@@gmail.com'; 
        $mail->Password = 'bkuq zech xxnx moga'; 
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Destinatarios
        $mail->setFrom('camilatefa2542@gmail.com', 'Encriptador');
        $mail->addAddress($email);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Mensaje Desencriptado';
        $mail->Body = "Mensaje Desencriptado: $decryptedMessage";

        $mail->send();
        echo 'El mensaje desencriptado ha sido enviado';
    } catch (Exception $e) {
        echo "El mensaje no pudo ser enviado. Error de Mailer: {$mail->ErrorInfo}";
    }
}
?>