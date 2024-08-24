<?php
$to_email = "sksugikaran4@gmail.com";
$subject = "Simple Email Test via PHP";
$body = "Hi, This is a test email sent by PHP Script";
$headers = "From: your-email@gmail.com";

// Gmail SMTP server configuration
$smtp_server = "smtp.gmail.com";
$smtp_username = "sksugikaran4@gmail.com";
$smtp_password = "ESS@789@";
$smtp_port = 587;

ini_set("SMTP", $smtp_server);
ini_set("smtp_port", $smtp_port);
ini_set("sendmail_from", $headers);

if (mail($to_email, $subject, $body, $headers)) {
    echo "Email successfully sent to $to_email...";
} else {
    echo "Email sending failed...";
}
?>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Create a PHPMailer instance
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->SMTPDebug = 0; // Enable verbose debug output if needed
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'sksugikaran4@gmail.com'; // Your Gmail address
    $mail->Password   = 'ESS@789@'; // Your Gmail password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Sender and recipient settings
    $mail->setFrom('sksugikaran4@gmail.com', 'Your Name');
    $mail->addAddress('', 'Recipient Name');

    // Email content
    $mail->isHTML(true);
    $mail->Subject = 'Subject of the email';
    $mail->Body    = 'Body of the email';

    // Send the email
    $mail->send();
    echo 'Email has been sent';
} catch (Exception $e) {
    echo "Email sending failed. Error: {$mail->ErrorInfo}";
}
?>

