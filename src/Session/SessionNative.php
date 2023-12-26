<?php

namespace Lite\Session;

class SessionNative implements ISession
{
    public  function start(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public  function id(): string
    {
        return session_id();
    }
    public  function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }
    public  function get(string $key, $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public  function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public  function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }
}
