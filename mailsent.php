<?php
$to      = 'jigar128@gmail.com';
$subject = 'Testing sendmail';
$message = 'Hi, you received an email!';
$headers = 'From: sender@gmail.com' . "\r\n" . 
           'MIME-Version: 1.0' . "\r\n" .
           'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
           'X-Mailer: PHP/' . phpversion();

if(mail($to, $subject, $message, $headers))
 echo "Email sent successfully..!!"; 
else
 echo "Email sending failed";
?>