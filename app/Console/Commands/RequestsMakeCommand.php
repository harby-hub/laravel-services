<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class RequestsMakeCommand extends GeneratorCommand {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:request';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new form request class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Requests';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/Requests.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Requests';
    }

}
