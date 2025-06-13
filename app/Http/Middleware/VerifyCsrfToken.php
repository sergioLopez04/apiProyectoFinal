<?php
/*
namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Support\Facades\Log;

class VerifyCsrfToken extends Middleware
{
    protected $except = [
    'proyectos*',
    'usuarios*',
    'usuarios/firebase/*',
    'proyectos/*',
    'usuarios',
    'proyectos',
    'api/proyectos/*'
];

    public function handle($request, Closure $next)
    {
        // Loguea ruta y método
        Log::debug('[CSRF Middleware] Request Path: ' . $request->path());
        Log::debug('[CSRF Middleware] Method: ' . $request->method());
        Log::debug('[CSRF Middleware] In except array? ' . ($this->inExceptArray($request) ? 'YES' : 'NO'));

        if ($this->inExceptArray($request)) {
            Log::debug('[CSRF Middleware] Skipping CSRF for this route.');
            return $next($request);
        }

        Log::debug('[CSRF Middleware] Applying CSRF!');
        return parent::handle($request, $next);
    }
}*/
