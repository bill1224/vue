<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\URL;

class SetDefaultLocateForUrls
{
    public function handle($request, Closure $next)
    {
        URL::defaults(['locate' => "Seoul"]);

        return $next($request);
    }
}