<?php

namespace harby\services\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class TestMakeCommand extends GeneratorCommand {
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'service:test {name : The name of the class} {--unit : Create a unit test}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new test class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Test';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub( ) {
        return __DIR__ . '/stubs/test.stub' ;
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath( $name ) {
        $name = Str::replaceFirst( $this -> rootNamespace( ) , '' , $name );
        return base_path( 'tests' ) . str_replace( '\\' , '/' , $name ) . 'Test.php' ;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace( $rootNamespace ) {
            return $rootNamespace . '\Unit' ;
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace( ) {
        return 'Tests' ;
    }
}
