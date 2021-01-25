<?php

namespace harby\services\Console\Commands;
use Illuminate\Console\GeneratorCommand;

class MutationCommand extends GeneratorCommand {
    /**
     * The name of the console command.
     *
     * @var string
     */
    protected $name = 'service:mutation' ;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a class for a single field on the root Mutation type.' ;

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Mutation';

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace( $rootNamespace ) : string {
        return config( 'harby-services.namespaces.Mutation' , config( 'lighthouse.namespaces.mutations' ) ) ;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub( ) : string {
        return __DIR__ . '/stubs/field.stub' ;
    }
}
