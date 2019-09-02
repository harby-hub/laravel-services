<?php

namespace harby\services;

use Illuminate\Support\ServiceProvider;

use harby\services\Console\Commands\RequestsMakeCommand;
use harby\services\Console\Commands\ServiceMakeCommand;
use harby\services\Console\Commands\ModelMakeCommand;
use harby\services\Console\Commands\ControllerMakeCommand;
use harby\services\Console\Commands\MigrateMakeCommand;

class servicesProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register( ): void {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ModelMakeCommand::class,
                ControllerMakeCommand::class,
                RequestsMakeCommand::class,
                ServiceMakeCommand::class,
                MigrateMakeCommand::class,
            ]);
        }
    }
}
