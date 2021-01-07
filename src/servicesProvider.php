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
        if ($this->app->runningInConsole()) {
            $this->registerMigrateMakeCommand() ;
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
    protected function registerMigrateMakeCommand()
    {
        $this->app->singleton( MigrateMakeCommand::class , function ($app) {
            // Once we have the migration creator registered, we will create the command
            // and inject the creator. The creator is responsible for the actual file
            // creation of the migrations, and may be extended by these developers.
            $creator = $app['migration.creator'];

            $composer = $app['composer'];

            return new MigrateMakeCommand($creator, $composer);
        });
    }
}
