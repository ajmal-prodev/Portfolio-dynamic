<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

function sendOTP($email, $otp) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;

        // CHANGE THESE ↓↓↓
        $mail->Username   = 'mohamedajmal.dev@gmail.com';
        $mail->Password   = 'lowzlzliocbbhfby'; // Gmail App Password

        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('mohamedajmal.dev@gmail.com', 'OTP System');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'AjmalProWebDev';
        $mail->Body = "<h3>Your OTP is <b>$otp</b> don't share it to anyone.</h3>";

        $mail->send();
        return true;

    } catch (Exception $e) {
        return false;
    }
}
?>