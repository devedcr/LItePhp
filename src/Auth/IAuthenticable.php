<?php

namespace Lite\Auth;

interface IAuthenticable
{
    public function login(Authentication $auth);
    public function logout(Authentication $auth);
    public function isAuthenticated(Authentication $auth);
    public function resolve(): ?Authentication;
}
