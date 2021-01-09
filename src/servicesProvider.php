<?php

namespace harby\services;

use DB;

use Illuminate\Support\ServiceProvider;

use Illuminate\Database\Eloquent\Builder;

use harby\services\Console\Commands\RequestsMakeCommand;
use harby\services\Console\Commands\ServiceMakeCommand;
use harby\services\Console\Commands\ModelMakeCommand;
use harby\services\Console\Commands\ControllerMakeCommand;
use harby\services\Console\Commands\MigrateMakeCommand;
use harby\services\Console\Commands\TestMakeCommand;

class servicesProvider extends ServiceProvider {

    public function boot( ) {
        $this -> loadTranslationsFrom( resource_path( 'lang/Mutations' ) , 'Mutations' );
        $this -> loadTranslationsFrom( resource_path( 'lang/tables'    ) , 'tables'    );
        $this->publishes([ __DIR__ . '/../config/config.php' => base_path( 'config/harby-services.php' ) ] , 'config' );
        if ( $this -> app -> runningInConsole( ) ) {
            $this -> registerMigrateMakeCommand( ) ;
            $this -> commands([
                ModelMakeCommand      :: class ,
                ControllerMakeCommand :: class ,
                RequestsMakeCommand   :: class ,
                ServiceMakeCommand    :: class ,
                MigrateMakeCommand    :: class ,
                TestMakeCommand       :: class ,
            ]);
        }
    }

    protected function registerMigrateMakeCommand( ) {
        $this -> app -> singleton( MigrateMakeCommand::class , function ( $app ) {
            return new MigrateMakeCommand( $app[ 'migration.creator' ] , $app[ 'composer' ] );
        });
    }

}
