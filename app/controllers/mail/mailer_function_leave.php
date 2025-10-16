<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to send mail
function mail_send($f_mail, $t_mail, $f_name, $t_name, $sub, $body) {
    // Load Composer's autoloader
    require 'vendor/autoload.php';

    $mail = new PHPMailer(true);

    try {
        // Include SMTP configuration
        include('config_mail_settings.php');

        // Set sender and recipient
        $mail->setFrom($f_mail, $f_name);
        $mail->addAddress($t_mail, $t_name);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = $sub;
        $mail->Body    = $body;
        $mail->AltBody = strip_tags($body); // Use plain text fallback

        // Send email
        $mail->send();
        echo 'Message has been sent';

    } catch (Exception $e) {
        // Log or handle the error message
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
