<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'phpmail_password.php';

function mailer($to, $subject, $body) {

    // $count_email=0;

    $mail = new PHPMailer(true);                              
    try {
        $mail->SMTPDebug = 0;                            
        $mail->isSMTP();                               
        $mail->Host = '10.101.254.146';     
        $mail->SMTPAuth = true;           
        $mail->Username = 'eSourcing';
        $mail->Password = 'SmTp@1357';
        $mail->SMTPSecure = 'STARTLS';
        $mail->Port = 25;     
        $mail->setFrom('esourcing@robi.com.bd', 'Robi Group');      
        $mail->addAddress($to);           
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
       
    } catch (Exception $e) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
}


function mailerwithCCReminder($to,$ownerteam, $subject, $body) {
    $mail = new PHPMailer(true);                              
    try {
        $mail->SMTPDebug = 0;                            
        $mail->isSMTP();                               
        $mail->Host = '10.101.254.146';     
        $mail->SMTPAuth = true;           
        $mail->Username = 'eSourcing';
        $mail->Password = 'SmTp@1357';
        $mail->SMTPSecure = 'STARTLS';
        $mail->Port = 25;     
        $mail->setFrom('esourcing@robi.com.bd', 'Robi Group');
        foreach ($ownerteam as $recipient) {
         if($recipient->action=='Owner'){
            $mail->addCC($recipient->email,$recipient->fname);    
            
         }
        }
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
 
        $mail->send();
       
    } catch (Exception $e) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
}

/*$subject = 'Test Email from Axiata Group of Companies';
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

mailer('fahimfoysal177@gmail.com', $subject, $body);*/
?>
