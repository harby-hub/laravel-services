<?php

namespace harby\services\Console\Commands ;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class ModelMakeCommand extends GeneratorCommand {
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'service:model';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a new Eloquent model class';

	/**
	 * The type of class being generated.
	 *
	 * @var string
	 */
	protected $type = 'Model';

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function handle( ) {
		if ( parent::handle( ) === false && ! $this -> option( 'force' ) ) {
			return false;
		}

		if ( $this -> option( 'all' ) ) {
			$this -> input -> setOption( 'factory'		, true );
			$this -> input -> setOption( 'migration'	, true );
			$this -> input -> setOption( 'controller'	, true );
		}

		if ( $this -> option( 'factory' ) ) $this -> createFactory( );

		if ( $this -> option( 'migration' ) ) $this -> createMigration( );

		if ( $this -> option( 'controller' ) ) $this -> createController( );

	}

	/**
	 * Create a model factory for the model.
	 *
	 * @return void
	 */
	protected function createFactory( ) {
		$factory = Str::studly(class_basename($this->argument('name')));

		$this->call('service:factory', [
			'name' => "{$factory}Factory",
			'--model' => $this->qualifyClass($this->getNameInput()),
		]);
	}

	/**
	 * Create a migration file for the model.
	 *
	 * @return void
	 */
	protected function createMigration( ) {
		$table = Str::snake( Str::pluralStudly( class_basename( $this -> argument( 'name' ) ) ) );

		$this -> call( 'service:migration' , [
			'name' => "create_{$table}_table" ,
			'--create' => $table ,
		]);
	}

	/**
	 * Create a controller for the model.
	 *
	 * @return void
	 */
	protected function createController( ) {
		$controller = Str::studly(class_basename($this->argument('name')));

		$modelName = $this->qualifyClass($this->getNameInput());

		$this->call('service:controller', [
			'name' => "{$controller}Controller",
			'--model' => $this->option('resource') ? $modelName : null,
		]);
	}

	/**
	 * Get the stub file for the generator.
	 *
	 * @return string
	 */
	protected function getStub( ) {
		return __DIR__.'/stubs/model.stub';
	}

	/**
	 * Get the default namespace for the class.
	 *
	 * @param  string  $rootNamespace
	 * @return string
	 */
	protected function getDefaultNamespace( $rootNamespace ) {
		return config( 'harby-services.namespaces.Models' , $rootNamespace . '\Models' ) ;
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions( ) {
		return [
			['all'			, 'a'	, InputOption::VALUE_NONE, 'Generate a migration, factory, and resource controller for the model'			],
			['controller'	, 'c'	, InputOption::VALUE_NONE, 'Create a new controller for the model'											],
			['factory'		, 'f'	, InputOption::VALUE_NONE, 'Create a new factory for the model'												],
			['migration'	, 'm'	, InputOption::VALUE_NONE, 'Create a new migration file for the model'										],
		];
	}
}
