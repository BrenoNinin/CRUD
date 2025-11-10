<?php

namespace App\Http\Middleware;

use Closure;

class CorsSimple
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Ajuste aqui se seu Vite mudar de porta:
        $allowed = ['http://localhost:5173', 'http://localhost:5174'];
        $origin  = $request->headers->get('Origin');

        $allowOrigin = in_array($origin, $allowed) ? $origin : $allowed[0];

        $response->headers->set('Access-Control-Allow-Origin', $allowOrigin);
        $response->headers->set('Vary', 'Origin');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept');
        $response->headers->set('Access-Control-Allow-Credentials', 'false'); // sem cookies/CSRF

        // Responder pré-flight
        if ($request->getMethod() === 'OPTIONS') {
            $response->setStatusCode(200);
        }

        return $response;
    }
}
