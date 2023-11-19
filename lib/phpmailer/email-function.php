<?php
include 'email-config.php'; 
function sendEmail($recipient, $subject, $message) {
    global $mail;

    $mail->addAddress($recipient);
    $mail->isHTML(false);
    $mail->Subject = $subject;
    $mail->Body = $message;

    if ($mail->send()) {
        return true;
    } else {
        return false;
    }
}
