<?php

namespace harby\services;

use Illuminate\Support\ServiceProvider;

use harby\services\Console\Commands\RequestsMakeCommand;
use harby\services\Console\Commands\ServiceMakeCommand;

class servicesProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register( ): void {
        if ($this->app->runningInConsole()) {
            $this->commands([
                RequestsMakeCommand::class,
                ServiceMakeCommand::class,
            ]);
        }
    }
}
