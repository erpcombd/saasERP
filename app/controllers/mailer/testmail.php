<?php
// Define the SMTP server settings
$smtpServer = '10.101.254.146';
$smtpPort = 25;

// Define sender and recipient email addresses
$from = 'esourcing@robi.com.bd';
$to = 'fahimfoysal177@gmail.com';

// Define the email content
$subject = 'Hello';
$message = "Hello,\n\nThis is a test email from esourcing@robi.com.bd to fahimfoysal177@gmail.com.\n\nRegards,\nesourcing@robi.com.bd";

// Construct the SMTP request body
$request = "MAIL FROM:<$from>\r\n";
$request .= "RCPT TO:<$to>\r\n";
$request .= "DATA\r\n";
$request .= "Subject: $subject\r\n";
$request .= "From: $from\r\n";
$request .= "To: $to\r\n";
$request .= "\r\n";
$request .= "$message\r\n";
$request .= ".\r\n";
$request .= "QUIT\r\n";

// Initialize cURL session
$curl = curl_init();

// Set cURL options
curl_setopt_array($curl, array(
    CURLOPT_URL => "smtp://$smtpServer:$smtpPort",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => 'SMTP',
    CURLOPT_UPLOAD => true,
    CURLOPT_INFILE => fopen("php://memory", "rw"),
    CURLOPT_INFILESIZE => strlen($request),
    CURLOPT_VERBOSE => true
));

// Send the SMTP request
curl_setopt($curl, CURLOPT_INFILE, fopen("php://temp", "rw"));
curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
$response = curl_exec($curl);

// Check for errors
if ($response === false) {
    echo 'Error: ' . curl_error($curl);
} else {
    echo 'Email sent successfully!';
}

// Close cURL session
curl_close($curl);
?>