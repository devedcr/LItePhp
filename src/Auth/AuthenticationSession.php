<?php

namespace Lite\Auth;

class AuthenticationSession implements IAuthenticable
{
    public function login(Authentication $auth)
    {
        session()->set("_auth", $auth);
    }

    public function logout(Authentication $auth)
    {
        session()->remove("_auth");
    }

    public function isAuthenticated(Authentication $auth)
    {
        return session()->get("_auth")?->id == $auth->id();
    }
    public function resolve(): ?Authentication
    {
        return session()->get("_auth");
    }
}
