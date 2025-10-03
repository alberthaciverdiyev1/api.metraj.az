<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        health: '/up',
    )
    ->withSchedule(function ($schedule) {
        $schedule->command('ads:deactivate-expired')->dailyAt('01:00');
    })
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

//web: function () {
//    require base_path('/Modules/WebUI/Routes/web.php');
//    require base_path('/Modules/AdminUI/Routes/web.php');
//},
