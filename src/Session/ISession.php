<?php

namespace Lite\Session;

interface ISession
{
    function start(): void;
    function id(): string;
    function set(string $key, mixed $value): void;
    function get(string $key, $default = null): mixed;
    function has(string $key): bool;
    function remove(string $key): void;
}
