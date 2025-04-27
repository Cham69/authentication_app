<?php

namespace Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    protected $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);

        // Server settings
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com';    // SMTP server
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'softwaresolutions.noreply@gmail.com'; // SMTP username
        $this->mail->Password = 'your_password';         // SMTP password
        $this->mail->SMTPSecure = 'tls';                  // Encryption
        $this->mail->Port = 587;                           // TCP port
        $this->mail->CharSet = 'UTF-8';

        // Sender Info
        $this->mail->setFrom('softwaresolutions.noreply@gmail.com', 'Your Name');
    }

    public function send(string $to, string $subject, string $body, string $altBody = '')
    {
        try {
            $this->mail->clearAddresses(); // Clear previous addresses if reused
            $this->mail->addAddress($to); 
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;
            $this->mail->AltBody = $altBody ?: strip_tags($body);
            $this->mail->isHTML(true);

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            // Optionally log error: $e->getMessage()
            return false;
        }
    }
}
