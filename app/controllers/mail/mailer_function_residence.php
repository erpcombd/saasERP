<?php
session_start();
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// Load Composer's autoloader

require 'vendor/autoload.php';
// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);
try {
   include_once('config_mail_settings.php');
	$from_email= $_SESSION['from_email'];

	$from_name = $_SESSION['from_name'];

	$to_email= $_SESSION['to_email'];

	$to_name = $_SESSION['to_name'];

	$subject = $_SESSION['subject'];

	$body = $_SESSION['body'];

    //Recipients

    $mail->setFrom($from_email,$from_name);

    $mail->addAddress($to_email,$to_name);     // Add a recipient

// 	$mail->addAddress('ellen@example.com');               // Name is optional

//  $mail->addReplyTo('info@example.com', 'Information');

//  $mail->addCC('cc@example.com');

//  $mail->addBCC('bcc@example.com');



// 	Attachments

//  $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments

//  $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name



    // Content

    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = $subject;

    $mail->Body    = $body;

    $mail->AltBody = '';

    $mail->send();
    echo 'Message has been sent';
unset($_SESSION["to_email"]);
unset($_SESSION["from_email"]);
unset($_SESSION["from_name"]);
unset($_SESSION["subject"]);
unset($_SESSION["body"]);

	echo "<script>window.location = '../house_mod/pages/house_allocation/all_application.php';</script>";

} 

catch (Exception $e) {

    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

}



