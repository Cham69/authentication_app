<?php

namespace Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    protected $mail;
    protected $smtpHost;
    protected $smtpPort;
    protected $email;
    protected $password;
    protected $encryption;
    protected $fromName;
    protected $port;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        require_once 'config/smtp.php';
        $this->smtpHost = $host;
        $this->smtpPort = $port;
        $this->email = $email;
        $this->password = $password;
        $this->encryption = $encryption;

        // Server settings
        $this->mail->isSMTP();
        $this->mail->Host = $this->smtpHost;    // SMTP server
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $this->email;          // SMTP username
        $this->mail->Password = $this->password;         // SMTP password
        $this->mail->SMTPSecure = $this->encryption;                  // Encryption
        $this->mail->Port = $this->smtpPort;                           // TCP port
        $this->mail->CharSet = 'UTF-8';

        // Sender Info
        $this->mail->setFrom($this->email, $this->fromName);
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
