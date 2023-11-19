<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer();
$mail->CharSet = "UTF-8";


$mail->isSMTP();
$mail->SMTPDebug = 1; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages

$mail->Host = "us2.smtp.mailhostbox.com";

$mail->SMTPAuth = true;

$mail->Username = 'no-reply@indiaskills.org';
$mail->Password = 'dlMusUD$V0';

//	$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use TLS

//$mail->SMTPSecure = 'tls';

$mail->Port = 587; 

$mail->setFrom('no-reply@indiaskills.org', 'no-reply@indiaskills.org');

//$mail->SMTPSecure = 'tls'; // ssl is depracated

?>








