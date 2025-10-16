<?php


@session_start();
date_default_timezone_set('Asia/Dhaka');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
//require 'phpmail_password.php';
// require_once "../../../controllers/routing/default_values.php";
// require_once SERVER_AUTH."db_con_live_static.php";

function mailer($to, $subject, $body) {

    global $conn;

    $mail = new PHPMailer(true);                              
    try {
$mail->SMTPDebug = 2; // for debugging
$mail->isSMTP();
$mail->Host = 'mail.ezzy-erp.com';
$mail->SMTPAuth = true;
$mail->Username = 'xiaomierp@ezzy-erp.com';
$mail->Password = 'RwYqCM5Zep92SU2';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->Port = 465;    
        $mail->setFrom('erp@gmail.com', 'ERP COM BD');
        $mail->addAddress($to);    
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        
        
        $reason='N/A';
        
    } catch (Exception $e) {
        $reason=$mail->ErrorInfo;
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
}

 $subject = 'Test Email from Axiata Group of Companies';
 $body = '
     <html>
     <body>
         <p>Dear Fahim,</p>
         <p>I hope this email finds you well.</p>
         <p>We are writing to inform you that we are currently conducting a test of our email server to ensure its efficiency and reliability. As part of this process, you have received this email.</p>
    
  
         <p>Thank you for your attention, and we apologize for any inconvenience this test may have caused.</p>
         <p>Best regards,</p>
         <p>Axiata Group of Companies</p>
     </body>
     </html>
 ';

 mailer('fahimfoysal177@gmail.com', $subject, $body);
?>
