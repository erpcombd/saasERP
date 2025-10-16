<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "error: only POST method allowed";
    exit;
}

$to = isset($_POST['to']) ? trim($_POST['to']) : '';
$subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
$body = isset($_POST['body']) ? trim($_POST['body']) : '';

if (!$to || !$subject) {
    echo "error: missing required fields";
    exit;
}

// Optional debug log to inspect files received
file_put_contents('/tmp/mail_debug.log', print_r($_FILES, true), FILE_APPEND);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'mail.ezzy-erp.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'xiaomierp@ezzy-erp.com';
    $mail->Password = 'RwYqCM5Zep92SU2';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    $mail->setFrom('xiaomierp@ezzy-erp.com', 'ERP COM BD');
    $mail->addAddress($to);
    $mail->isHTML(true);
    $mail->Subject = $subject;

    // ✅ Handle attachments
    $hasAttachment = false;
    foreach ($_FILES as $file) {
        if (isset($file['error']) && $file['error'] === UPLOAD_ERR_OK) {
            $mail->addAttachment($file['tmp_name'], $file['name']);
            $hasAttachment = true;
        }
    }

    // Append default body if body is empty or no file found
    if (!$body) {
        $body = "<strong>Note:</strong> No log found.";
    } elseif (!$hasAttachment) {
        $body .= "<br><strong>Note:</strong> No log found.";
    }

    $mail->Body = $body;

    $mail->send();
    echo "success: Email sent to $to";
} catch (Exception $e) {
    echo "error: Mailer Error: " . $mail->ErrorInfo;
}
