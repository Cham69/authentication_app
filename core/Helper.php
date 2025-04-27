<?php

namespace Core;

require_once 'core/Mailer.php';
use Core\Mailer;

class Helper
{
    public static function loadEmailTemplate(string $template, array $data = []): string
    {
        $templatePath = __DIR__ . '/../views/emails/' . $template . '.php';

        if (!file_exists($templatePath)) {
            throw new \Exception("Email template $template not found!");
        }

        extract($data);

        ob_start();
        include $templatePath;
        $template = ob_get_clean();
        return $template;
    }

    public static function sendEmail(string $to, string $subject, string $template, array $data = []): bool
    {
        $mailer = new Mailer();

        $body = self::loadEmailTemplate($template, $data);

        $success = $mailer->send(
            $to,
            $subject,
            $body
        );

        return $success;
    }


}


