<?
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// require 'PHPMailer/src/Exception.php';
// require 'PHPMailer/src/PHPMailer.php';
// require 'PHPMailer/src/SMTP.php';
// require 'phpmail_password.php';

// function mailerwithCC($to, $subject, $body) {
//     $mail = new PHPMailer(true);                              
//     try {
//         $mail->SMTPDebug = 0;                            
//         $mail->isSMTP();                               
//         $mail->Host = 'smtp.robi.com.bd';     
        // $mail->SMTPAuth = true;           
        // $mail->Username = 'eSourcing';
        // $mail->Password = 'SmTp@1357';
        // $mail->SMTPSecure = 'STARTLS';
//         $mail->Port = 25;     
//         $mail->setFrom('esourcing@robi.com.bd', 'Robi Group');
//         foreach ($to as $recipient) {
//          if($recipient->action=='Owner'){
//             $mail->addAddress($recipient->email);    
            
//          }else{
//             $mail->addCC($recipient->email,$recipient->fname);
//          }
//         }
//         $mail->isHTML(true);
//         $mail->Subject = $subject;
//         $mail->Body = $body;
 
//         $mail->send();
       
//     } catch (Exception $e) {
//         echo 'Message could not be sent.';
//         echo 'Mailer Error: ' . $mail->ErrorInfo;
//     }
// }


?>
<?php

$host		= 'localhost';
$port		= '3306';
$user 		= 'ezzyerp_clouduser23';
$pass 		= 'cloudpass224423';
$db 	 	= 'ezzyerp_saas_masterdb';


$conn = mysqli_connect($host,$user,$pass,$db,$port);
if(!$conn) {    die("Database connection failed: M" . mysqli_connect_error()); }
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'phpmail_password.php';

function mailerwithCCReminder($to,$ownerteam, $subject, $body) {
    global $conn;

    $mail = new PHPMailer(true);                              
    try {
        $mail->SMTPDebug = 0;                                
        $mail->isSMTP();                                    
        $mail->Host = 'smtp.gmail.com';                      
        $mail->SMTPAuth = true;                              
        $mail->Username = 'fahimfoysal177@gmail.com';        // Your Gmail address
        $mail->Password = 'ynldhriprenqcdxg';                      // Your Gmail password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;     
        $mail->setFrom('fahimfoysal177@gmail.com', 'ERP COM BD');

        $toAddresses = [];
        $ccAddresses = [];

        foreach ($to as $recipient) {
            if ($recipient->action == 'Owner') {
                $mail->addAddress($recipient->email);    
                $toAddresses[] = $recipient->email;
            } else {
                $mail->addCC($recipient->email, $recipient->fname);
                $ccAddresses[] = $recipient->email;
            }
        }

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();

        // Combine addresses into a single string for logging
        $toList = implode(', ', $toAddresses);
        $ccList = implode(', ', $ccAddresses);
        $ccList=empty($ccList)?'N/A':$ccList;
        $recipientList = $toList . ($ccList ? ", CC: " . $ccList : "");

        $rfq_no = $_SESSION['rfq_no'] ?? 'N/A'; // Default to 'N/A' if rfq_no is not set
        $reason = 'N/A';

        $sql_mail_history = "INSERT INTO mail_logs (cc,sender, rfq_no, recipients, subject, status, reason, sent_at) 
        VALUES ('$ccList','Reminder', '$rfq_no', '$toList', '$subject', 'Success', '$reason', NOW())";

        mysqli_query($conn, $sql_mail_history);
    } catch (Exception $e) {
        $rfq_no = $_SESSION['rfq_no'] ?? 'N/A';
        $reason = $mail->ErrorInfo;

        $sql_mail_history = "INSERT INTO mail_logs (sender, rfq_no, recipients, subject, status, reason, sent_at) 
        VALUES ('Reminder', '$rfq_no', '$recipientList', '$subject', 'Failed', '$reason', NOW())";

        mysqli_query($conn, $sql_mail_history);

        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
}
?>

