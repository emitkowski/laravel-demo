<?php

namespace App\Providers;

use App\Services\Logger;
use Illuminate\Support\ServiceProvider;

class LoggerServiceProvider extends ServiceProvider
{
    /**
     * Register the binding
     *
     * @return void
     */
    public function register()
    {
        /**** Logger Binding ***/
        app()->bind('logger', function () {
            return new Logger\MyLogger();
        });
    }

}