<?php

class SessionManager
{
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key)
    {
        return $_SESSION[$key] ?? null;
    }

    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public static function forget(string $key)
    {
        unset($_SESSION[$key]);
    }

    public static function destroy()
    {
        session_unset();
        session_destroy();
    }

    public static function login($email)
    {
        self::set('email', $email);
    }

    public static function logout()
    {
        self::destroy();
    }

    public static function isAuthenticated(): bool
    {
        return self::has('email') && self::has('is_verified');
    }

    public static function registeredOnly(): bool
    {
        return self::has('email') && !self::has('is_verified');
    }
}
