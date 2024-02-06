<?php


use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

//define gmail's smtp mail server
define('MAILHOST', "smtp.gmail.com");

define('USERNAME', "joshuabadmus574@gmail.com");

define('PASSWORD', "dbhg nhho hjht ibcy");

define('SEND_FROM', "joshuabadmus574@gmail.com");

define('SEND_FROM_NAME', 'Guardian Angel');

define('REPLY_TO', "info@guardian-angel.com");

define('REPLY_TO_NAME', "Guardian Angel");

function sendMail($email, $subject, $message)
{
    //creating a new phpmailer object
    $mail = new PHPMailer(true);

    //smtp protocol to send mail
    $mail->isSMTP();

    $mail->SMTPAuth = true;

    $mail->Host = MAILHOST;
    $mail->Username = USERNAME;
    $mail->Password = PASSWORD;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->setFrom(SEND_FROM, SEND_FROM_NAME);
    $mail->addAddress($email);
    $mail->addReplyTo(REPLY_TO, REPLY_TO_NAME);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->AltBody = $message;
}
