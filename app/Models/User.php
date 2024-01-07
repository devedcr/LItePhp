<?php

namespace App\Models;

use Lite\Auth\Authentication;

class User extends Authentication
{
    protected array $fillable = ["name", "email", "password"];
    protected array $hidden = ["password"];
}
