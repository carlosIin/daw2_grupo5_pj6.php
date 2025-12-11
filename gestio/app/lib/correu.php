<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

function enviar_correu($destinatari, $assumpte, $missatge) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'botiga@gmail.com';
        $mail->Password = 'contrasenya_app';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('botiga@gmail.com', 'Botiga Mobiliari');
        $mail->addAddress($destinatari);

        $mail->isHTML(true);
        $mail->Subject = $assumpte;
        $mail->Body = $missatge;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Error enviant correu: " . $mail->ErrorInfo);
        return false;
    }
}
?>
