<?php
namespace Lite\Hash;

interface IHash
{
    public function hash(string $password): string;
    public function verify(string $password, string $hash): bool;
}
