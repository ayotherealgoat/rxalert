<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'eventixafrica@gmail.com';
    $mail->Password = 'xnquvfqfuijaibpd'; // your app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('eventixafrica@gmail.com', 'RxAlert');
    $mail->addAddress('ayomideoyelola12@gmail.com');
    $mail->Subject = 'PHPMailer Gmail test';
    $mail->Body    = 'This is a direct PHPMailer test.';

    $mail->send();
    echo "✅ Email sent successfully!";
} catch (Exception $e) {
    echo "❌ Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
