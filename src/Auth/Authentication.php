<?php

namespace Lite\Auth;

use Lite\Database\Model;

class Authentication extends Model
{
    public function id()
    {
        return $this->{$this->primary_key};
    }
    
    public function login()
    {
        app(IAuthenticable::class)->login($this);
    }

    public function logout()
    {
        app(IAuthenticable::class)->logout($this);
    }

    public function isAuthenticated()
    {
        app(IAuthenticable::class)->isAuthenticated($this);
    }
}
