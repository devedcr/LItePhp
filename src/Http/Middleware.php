<?php

namespace Lite\Http;

use Closure;
use Lite\Http\Request;

interface Middleware
{
    public function handle(Request $request, Closure $next);
}
