<?php
 //Server settings

  // $mail->SMTPDebug = 2;                                       // Enable verbose debug output

    $mail->isSMTP();                                            // Set mailer to use SMTP

    $mail->Host       = 'mail.meridian-erp.com';  // Specify main and backup SMTP servers

    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication

    $mail->Username   = 'erp@meridian-erp.com';                     // SMTP username

    $mail->Password   = 'erp22442424';                               // SMTP password

    $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted

    $mail->Port       = 465;  

// TCP port to connect to

// add this to your config file
    $mail->SMTPOptions = array(
        'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
        )
    );
// end here
?>