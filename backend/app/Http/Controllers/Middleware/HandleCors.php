<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\HandleCors as Middleware;

class HandleCors extends Middleware
{
    protected array $allowedOrigins = ['http://localhost:5173'];

    protected array $allowedMethods = ['*'];

    protected array $allowedHeaders = ['*'];

    protected bool $supportsCredentials = false;
}
