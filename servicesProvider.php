<?php

namespace Nuwave\Lighthouse;

use Illuminate\Support\ServiceProvider;

use App\Console\Commands\RequestsMakeCommand;
use App\Console\Commands\ServiceMakeCommand;

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
