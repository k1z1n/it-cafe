<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'CheckStatusAdmin' => \App\Http\Middleware\CheckAdminStatus::class,
            'CheckAuth' => \App\Http\Middleware\CheckAuth::class,
            'CheckVisit' =>  \App\Http\Middleware\VisitStatistics::class,
            'RecordVisit' =>  \App\Http\Middleware\RecordVisit::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
