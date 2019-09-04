<?php

namespace harby\services\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Input\InputOption;

class ServiceMakeCommand extends GeneratorCommand {

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $name = 'service:service';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a new Service class';

	/**
	 * The type of class being generated.
	 *
	 * @var string
	 */
	protected $type = 'Service';

	/**
	 * Get the stub file for the generator.
	 *
	 * @return string
	 */
	protected function getStub( ) {
		return __DIR__.'/stubs/Service.stub';
	}

	/**
	 * Get the default namespace for the class.
	 *
	 * @param  string  $rootNamespace
	 * @return string
	 */
	protected function getDefaultNamespace( $rootNamespace ) {
		return config( 'harby-services.namespaces.Services' , $rootNamespace . '\Services' ) ;
	}

	/**
	 * Get the destination class path.
	 *
	 * @param  string  $name
	 * @return string
	 */
	protected function getPath( $name ) {
		$name = Str::replaceFirst( $this -> rootNamespace( ) , '' , $name );
		return $this -> laravel [ 'path' ] . '/' . str_replace( '\\' , '/' , $name ) .'Service.php';
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function handle( ) {
		if ( parent::handle( ) === false && ! $this -> option( 'force' ) ) return false;

		if ( $this -> option( 'all' ) ) {
			$this -> input -> setOption( 'factory'		, true ) ;
			$this -> input -> setOption( 'migration'	, true ) ;
			$this -> input -> setOption( 'model'		, true ) ;
			$this -> input -> setOption( 'request'		, true ) ;
			$this -> input -> setOption( 'controller'	, true ) ;
			$this -> input -> setOption( 'test'			, true ) ;
		}

		if ( $this -> option( 'factory'		) ) $this -> createFactory(		) ;
		if ( $this -> option( 'migration'	) ) $this -> createMigration(	) ;
		if ( $this -> option( 'model'		) ) $this -> createModel(		) ;
		if ( $this -> option( 'request'		) ) $this -> createRequest(		) ;
		if ( $this -> option( 'controller'	) ) $this -> createController(	) ;
		if ( $this -> option( 'test'		) ) $this -> createTest(		) ;

		if ( config( 'harby-services.graphql.exists' , true ) ) {
			if ( config( 'harby-services.graphql.edit' , true ) ) $this -> editGraphqlSchemaFile(		) ;
		};

	}

	/**
	 * edit a graphql schema file.
	 *
	 * @return void
	 */
	protected function editGraphqlSchemaFile( ) {
		$path = config( 'harby-services.graphql.Path' , base_path( 'graphql/schema.graphql' ) );

		if ( File::exists( $path ) ){
			$contents = File::get( $path );
			$new_contents = $contents . PHP_EOL . "#import {$this -> argument( 'name' )}/*.graphql" ;
			File::put( $path , $new_contents );
			$this -> info( 'edit a web route file successfully.' );
		}
	}

	/**
	 * edit a web route file.
	 *
	 * @return void
	 */
	protected function editwebRouteFile( ) {
		$path = config( 'harby-services.web.Path' , base_path( 'routes/web.php' ) );
		$classname = Str::studly( class_basename( $this -> argument( 'name' ) ) );

		if ( File::exists( $path ) ){
			$contents = File::get( $path );
			$new_contents = $contents . PHP_EOL . "Route::resource( '{$classname}' , '{$classname}Controller' ) -> except([ " . PHP_EOL . "	'create', 'store', 'update', 'destroy' " . PHP_EOL . "]);" ;
			File::put( $path , $new_contents );
			$this -> info( 'edit a web route file successfully.' );
		}
	}

	/**
	 * edit a api route file.
	 *
	 * @return void
	 */
	protected function editapiRouteFile( ) {
		$path = config( 'harby-services.api.Path' , base_path( 'routes/api.php' ) );
		$classname = Str::studly( class_basename( $this -> argument( 'name' ) ) );

		if ( File::exists( $path ) ){
			$contents = File::get( $path );
			$new_contents = $contents . PHP_EOL . "Route::apiResource( '{$classname}' , '{$classname}Controller' ) ;" ;
			File::put( $path , $new_contents );
			$this -> info( 'edit a api route file successfully.' );
		}
	}

	/**
	 * Build the test replacement values.
	 *
	 * @param  array  $replace
	 * @return array
	 */
	protected function createTest ( array $replace = [ ] ) {
		$testClass = Str::studly( $this -> argument( 'name' ) );
		$this -> call( 'service:test' , [
			'name' => "{$testClass}Test",
		]); 
	}

	/**
	 * Build the model replacement values.
	 *
	 * @param  array  $replace
	 * @return array
	 */
	protected function createModel ( array $replace = [ ] ) {
		$modelClass = Str::studly( $this -> argument( 'name' ) );
		$this -> call( 'service:model' , [
			'name' => "{$modelClass}Model",
		]); 
	}

	/**
	 * Build the request replacement values.
	 *
	 * @param  array  $replace
	 * @return array
	 */
	protected function createRequest ( array $replace = [ ] ) {
		$requestClass = Str::studly( $this -> argument( 'name' ) );
		$this -> call( 'service:request' , [
			'name' => "{$requestClass}Request",
		]); 
	}

	/**
	 * Create a model factory for the model.
	 *
	 * @return void
	 */
	protected function createFactory( ) {
		$factory = Str::studly( class_basename( $this -> argument( 'name' ) ) );
		$this -> call( 'make:factory' , [
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
			'name' => "create_{$table}_table",
			'--create' => $table,
		]); 
	 }

	/**
	 * Create a controller for the model.
	 *
	 * @return void
	 */
	protected function createController( ) {
		if ( config( 'harby-services.web.edit' , true ) ) $this -> editwebRouteFile( ) ;
		if ( config( 'harby-services.api.edit' , true ) ) $this -> editapiRouteFile( ) ;
		$controller = Str::studly( class_basename( $this -> argument( 'name' ) ) );
		$this -> call('service:controller', [
			'name' => "{$controller}",
			'--resource' => 'resource'
		]);
		$this -> line( shell_exec( 'php artisan route:list' ) );
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions( ) {
		return [
			[ 'all'			, 'a'		, InputOption::VALUE_NONE		, 'Generate a migration, factory, and resource controller for the model'	],
			[ 'model'		, 'mo'		, InputOption::VALUE_OPTIONAL	, 'Generate a resource controller for the given model.'						],
			[ 'controller'	, 'c'		, InputOption::VALUE_NONE		, 'Create a new controller for the model'									],
			[ 'factory'		, 'f'		, InputOption::VALUE_NONE		, 'Create a new factory for the model'										],
			[ 'force'		, null		, InputOption::VALUE_NONE		, 'Create the class even if the model already exists'						],
			[ 'migration'	, 'mi'		, InputOption::VALUE_NONE		, 'Create a new migration file for the model'								],
			[ 'request'		, 'r'		, InputOption::VALUE_NONE		, 'Create a new form request class for the model'							],
			[ 'test'		, 't'		, InputOption::VALUE_NONE		, 'Create a new form test class for the service'							],
		];
	}
}
