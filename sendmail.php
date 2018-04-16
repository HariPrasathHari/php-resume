<?php
/**
 * Created by PhpStorm.
 * User: hari
 * Date: 26/2/18
 * Time: 9:29 PM
 */
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//Load composer's autoloader
require 'vendor/autoload.php';
$pdf1 = include 'pdfgen.php';
$pdf = include 'res.php';

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'mailtohari.ai@gmail.com';                 // SMTP username
    $mail->Password = 'hari@1998';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('mailtohari.ai@gmail.com', 'Mailer');
    $mail->addAddress('mailtohari.ai@gmail.com');     // Add a recipient
//    $mail->addAddress('ellen@example.com');               // Name is optional
//    $mail->addReplyTo('info@example.com', 'Information');
//    $mail->addCC('cc@example.com');
//    $mail->addBCC('bcc@example.com');

    //Attachments
//    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->addStringAttachment($pdf, 'doc.pdf');

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Assignment OSS 1517110';
    $mail->Body    = 'Resume is attached in this file<br>';
    $mail->AltBody = 'Resume is attached in this file';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}