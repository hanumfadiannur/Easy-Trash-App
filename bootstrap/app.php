<?php

use App\Http\Middleware\Authenticate;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        // Menambahkan alias untuk middleware auth
        $middleware->alias([
            'auth' => Authenticate::class, // Alias untuk middleware auth
        ]);

        // Mengatur redirection setelah autentikasi
        $middleware->redirectTo(
            guests: 'account/login', // Redirect untuk pengguna tamu (belum login)
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
