<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
 * PHPMailer simple contact form example.
 * If you want to accept and send uploads in your form, look at the send_file_upload example.
 */
//Import the PHPMailer class into the global namespace
use PHPMailer\PHPMailer\PHPMailer;

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Europe/Stockholm');

require '../vendor/autoload.php';
if (array_key_exists('name', $_POST)) {
    $err = false;
    $msg = '';
    $email = '';
    //Apply some basic validation and filtering to the subject
    if (array_key_exists('subject', $_POST)) {
        $subject = substr(strip_tags($_POST['subject']), 0, 255);
    } else {
        $subject = 'No subject given';
    }
    //Apply some basic validation and filtering to the message
    if (array_key_exists('message', $_POST)) {
        //Limit length and strip HTML tags
        $message = substr(strip_tags($_POST['message']), 0, 16384);
    } else {
        $message = '';
        $msg = 'Please enter a message';
        $err = true;
    }
    //Apply some basic validation and filtering to the name
    if (array_key_exists('name', $_POST)) {
        //Limit length and strip HTML tags
        $name = substr(strip_tags($_POST['name']), 0, 255);
    } else {
        $name = '';
        $msg .= 'Please provide your name';
        $err = true;
    }
    //Make sure the address they provided is valid before trying to use it
    if (array_key_exists('email', $_POST) and PHPMailer::validateAddress($_POST['email'])) {
        $email = $_POST['email'];
    } else {
        $msg .= "Error: invalid email address provided";
        $err = true;
    }
    if (!$err) {
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp01.binero.se';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = 'info@christianblom.se';
        $mail->Password = 'scqLqzO7FNm';
        $mail->CharSet = 'utf-8';
        //It's important not to use the submitter's address as the from address as it's forgery,
        //which will cause your messages to fail SPF checks.
        //Use an address in your own domain as the from address, put the submitter's address in a reply-to
        $mail->setFrom('info@christianblom.se', (empty($name) ? 'Contact form' : $name));
        $mail->addAddress('christian@christianblom.se');
        $mail->addReplyTo($email, $name);
        $mail->Subject = 'Contact form: ' . $subject;
        $mail->Body = "Contact form submission\n\n" . $message;
        if (!$mail->send()) {
            $msg .= "Mailer Error: " . $mail->ErrorInfo;
            echo $msg;
        } else {
            $msg .= "Message sent!";
            echo $msg;
        }
    }
} else {
?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="https://christianblom.se/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="https://christianblom.se/favicon-16x16.png" sizes="16x16" />
    <link rel="stylesheet" href="public/css/style.min.css">
    <link href="https://fonts.googleapis.com/css?family=Cabin|Lobster" rel="stylesheet">
    <title>Portfolio of Christian Blom</title>
</head>
<body>
    <section class="contact">
        <form method="POST">
            <h3>Contact me:</h3>
            <label for="name">Name:</label>
            <input type="text" name="name" required />
            <label for="name">Your email:</label>
            <input type="email" name="email" required />
            <label for="subject">Subject:</label>
            <input type="text" name="subject" required>
            <label for="message">Message:</label>
            <textarea name="message" rows="5" cols="40" required></textarea>
            <button type="submit">Send message</button>
        </form>
    </section>
</body>
<?php } ?>
