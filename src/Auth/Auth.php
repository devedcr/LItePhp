<?php

namespace Lite\Auth;

class Auth
{
    public static function user(): ?Authentication
    {
        return app(IAuthenticable::class)->resolve();
    }

    public static function isGuest()
    {
        return  !is_null(self::user());
    }
}
