<?php

use Lite\Auth\Auth;
use Lite\Auth\Authentication;

function auth(): ?Authentication
{
    return Auth::user();
}

function isGuest(): bool
{
    return Auth::isGuest();
}
