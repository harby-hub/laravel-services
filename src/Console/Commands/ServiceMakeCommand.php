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
		$name = Str::studly( class_basename(  $name ) ) ;
		return $this -> laravel [ 'path' ] . '/' . str_replace( '\\' , '/' , $name ) . 'Services.php';
	}

	/**
	 * Replace the class name for the given stub.
	 *
	 * @param  string  $stub
	 * @param  string  $name
	 * @return string
	 */
	protected function replaceClass( $stub , $name ) {
		$name = Str::studly( class_basename(  $name ) ) ;

		$class = str_replace( $this -> getNamespace( $name ) . '\\' , '' , $name );

		return str_replace( 'DummyClass' , $class , $stub );
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
			$this -> input -> setOption( 'lang'			, true ) ;
		}

		if ( $this -> option( 'factory'		) ) $this -> createFactory(		) ;
		if ( $this -> option( 'migration'	) ) $this -> createMigration(	) ;
		if ( $this -> option( 'model'		) ) $this -> createModel(		) ;
		if ( $this -> option( 'request'		) ) $this -> createRequest(		) ;
		if ( $this -> option( 'controller'	) ) $this -> createController(	) ;
		if ( $this -> option( 'test'		) ) $this -> createTest(		) ;
		if ( $this -> option( 'lang'		) ) $this -> createLang(		) ;

		/*if ( config( 'harby-services.graphql.exists' , true ) ) {
			if ( config( 'harby-services.graphql.edit' , true ) ) $this -> editGraphqlSchemaFile(		) ;
		};*/

	}

	/**
	 * edit a graphql schema file.
	 *
	 * @return void
	 */
	protected function editGraphqlSchemaFile( ) : void {
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
	protected function editwebRouteFile( ) : void {
		$path = config( 'harby-services.web.Path' , base_path( 'routes/web.php' ) );
		$classname = Str::studly( class_basename( $this -> argument( 'name' ) ) );

		if ( File::exists( $path ) ){
			$contents = File::get( $path );
			$new_contents = $contents . PHP_EOL . PHP_EOL . "Route::resource( '{$classname}' , '{$classname}Controller' ) -> except([ " . PHP_EOL . "	'create', 'store', 'update', 'destroy' " . PHP_EOL . "]);" ;
			File::put( $path , $new_contents );
			$this -> info( 'edit a web route file successfully.' );
		}
	}

	/**
	 * edit a api route file.
	 *
	 * @return void
	 */
	protected function editapiRouteFile( ) : void {
		$path = config( 'harby-services.api.Path' , base_path( 'routes/api.php' ) );
		$classname = Str::studly( class_basename( $this -> argument( 'name' ) ) );

		if ( File::exists( $path ) ){
			$contents = File::get( $path );
			//$new_contents = $contents . PHP_EOL . PHP_EOL . "Route::apiResource( '{$classname}' , '{$classname}Controller' ) ;" ;
			$new_contents = $contents . PHP_EOL . `Route::prefix( '` . $classname . `' ) -> group( function ( ) {
				Route::model( '` . $classname . `'		, 'App\\Models\\` . $classname . `' ) ;
				Route::get(		'/'			, '` . $classname . `Controller@index'	) -> name( '` . $classname . `.index'		) ;
				Route::post(	'/'			, '` . $classname . `Controller@store'	) -> name( '` . $classname . `.store'		) -> middleware( 'auth' );
				Route::get(		'{` . $classname . `}'	, '` . $classname . `Controller@show'		) -> name( '` . $classname . `.show'	) ;
				Route::post(	'{` . $classname . `}'	, '` . $classname . `Controller@update'		) -> name( '` . $classname . `.update'	) ;
				Route::delete(	'{` . $classname . `}'	, '` . $classname . `Controller@destroy'	) -> name( '` . $classname . `.destroy'	) ;
			});` ;
			File::put( $path , $new_contents );
			$this -> info( 'edit a api route file successfully.' );
		}
	}

	/**
	 * Build the test replacement values.
	 *
	 * @return void
	 */
	protected function createLang ( ) : void {
		$testClass = Str::studly( $this -> argument( 'name' ) );
		$this -> call( 'service:lang' , [
			'name' => $testClass,
		]); 
	}

	/**
	 * Build the test replacement values.
	 *
	 * @return void
	 */
	protected function createTest ( ) : void {
		$testClass = Str::studly( $this -> argument( 'name' ) );
		$this -> call( 'service:test' , [
			'name' => $testClass,
		]); 
	}

	/**
	 * Build the model replacement values.
	 *
	 * @return void
	 */
	protected function createModel ( ) : void {
		$modelClass = Str::studly( $this -> argument( 'name' ) );
		$this -> call( 'service:model' , [
			'name' => $modelClass,
		]); 
	}

	/**
	 * Build the request replacement values.
	 *
	 * @return void
	 */
	protected function createRequest ( ) : void {
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
	protected function createFactory( ) : void {
		$factory = Str::studly( class_basename( $this -> argument( 'name' ) ) );
		$this -> call( 'service:factory' , [
			'name' => $factory ,
			'--model' => $this -> argument( 'name' ) ,
		]); 
	 }

	/**
	 * Create a migration file for the model.
	 *
	 * @return void
	 */
	protected function createMigration( ) : void {
		$table = Str::studly( class_basename( $this -> argument( 'name' ) ) );

		$this -> info( $table );

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
	protected function createController( ) : void {

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
			[ 'lang'		, 'l'		, InputOption::VALUE_NONE		, 'Create a new lang file for the service'									],
		];
	}
}
