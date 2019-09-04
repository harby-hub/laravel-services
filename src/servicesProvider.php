<?php

namespace harby\services;

use Illuminate\Support\ServiceProvider;

use harby\services\Console\Commands\RequestsMakeCommand;
use harby\services\Console\Commands\ServiceMakeCommand;
use harby\services\Console\Commands\ModelMakeCommand;
use harby\services\Console\Commands\ControllerMakeCommand;
use harby\services\Console\Commands\MigrateMakeCommand;
use harby\services\Console\Commands\TestMakeCommand;

class servicesProvider extends ServiceProvider {

    public function boot( ) {
        $this->publishes([
            __DIR__ . '/../config/config.php' => base_path( 'config/harby-services.php' )
        ], 'config' );
    }

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
                TestMakeCommand::class,
            ]);
        }
    }
}
