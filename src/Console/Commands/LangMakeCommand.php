<?php

namespace harby\services\Console\Commands ;

use Illuminate\Console\GeneratorCommand ;
use Illuminate\Support\Str;

class LangMakeCommand extends GeneratorCommand {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'service:lang';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a lang file';

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath( $name ) {
        $name = Str::replaceFirst( $this -> rootNamespace( ) , '' , $name );
        return $this -> laravel -> langPath ( ) . DIRECTORY_SEPARATOR . 'en' . '/' . str_replace( '\\' , '/' , $name ) . '.php';
    }

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Lang';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub() {
        return __DIR__.'/stubs/Lang.stub';
    }

}
