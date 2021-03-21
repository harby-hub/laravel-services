<?php

namespace harby\services\tests\Traits;

use DB;
use Artisan;
use Arr;
use Str;

use Illuminate\Testing\TestResponse ;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\UploadedFile ;

use Illuminate\Support\Collection ;
use \Laravel\Passport\Passport ;

use Tests\TestCase;

trait Teststrait {

	use CreatesApplication ;

    public $Status = 'Status{
        code
        title
        message
        check
    }';

    public $BearerTokenResponse = 'BearerTokenResponse{
		access_token
		refresh_token
		expires_in
		token_type
	}' ;

	public static testconsole $console          ;
	public static bool        $wasSetup = false ;

	protected function buildMacros( ) : void {
		$_this = $this ;
		TestResponse::macro( 'assertResponseStatusMessageAndLog' , fn( ... $args ) => $_this -> assertResponseStatusMessageAndLog ( $this , ... $args ) );
		TestResponse::macro( 'assertMessagesLog'                 , fn( ... $args ) => $_this -> assertMessagesLog                 (         ... $args ) );
	}

	protected function setUp( ) : void {
		parent::setUp( );
		if ( ! static::$wasSetup ) {
			static::$console  = new testconsole ( ) ;
			static::$wasSetup = true                ;
		}
		static::$console -> updateCase( $this );
	}

	public function database_startup( ) {

		Schema:: disableForeignKeyConstraints ( ) ;
		if ( static::$ModelsTranck ) foreach( static::$ModelsTranck as $model ) ( static::$ModelsRoute . '\\' . $model )::truncate ( ) ;
		Schema:: enableForeignKeyConstraints  ( ) ;
		artisan:: call( 'db:seed' ) ;

		return $this ;

	}

	protected function tearDown( ) : void {
		parent::tearDown( );
		static::$console -> tearDown( );
	}

	public function passport ( ...$args ) {
		Passport::actingAs( ...$args );
		return $this ;
	}

	public function log( string $line , string $msg , string $type = 'text' , string $color = 'success' , bool $check = null , int $code = null ) {
		static::$console -> log( $line , $msg , $type , $color , $check , $code );
		return $this ;
	}

	public function makeFile( $path ) : UploadedFile {

		[ 'filename' => $filename ] = pathinfo( $path = storage_path( ) . $path ) ;

		return new UploadedFile ( $path , $filename , mime_content_type( $path ) , null , true ) ;

	}

	public function GraphQLFiles( string $query , array $variables = [ ] )  {

		foreach ( \Arr::dot( $variables ) as $key => $variable ) if ( $variable instanceof UploadedFile ) {
			$map   [ str_replace( '.' , '_' , $key ) ] = [ "variables.$key" ] ;
			$files [ str_replace( '.' , '_' , $key ) ] = $variable            ;
		} ;

        return $this -> call( 'POST' , config( 'lighthouse.route.uri' ) , [
			'operations' => json_encode( [
				'query'		=> $query ,
				'variables'	=> $variables
			] ),
			'map' => json_encode( $map ?? [ ] )
		], [ ] , $files ?? [ ] , $this -> transformHeadersToServerVars( [ 'Content-Type' => 'multipart/form-data' ] ) );

	}

	public function assertResponseStatusMessageAndLog ( TestResponse $response , String $mutation = '' , Bool $Check = True , Int $Code = 200 , Array $Array = [ ] , String $log = '' ) : TestResponse {

		[ , $functionName ] = Str::of( $mutation ) -> explode( '.' ) ;

		$response -> assertJson( [ 'data' => [ $functionName => [ 'Status' => [
			'code'    => $Code                  ,
			'check'   => $Check                 ,
			'title'   => "Mutations::$mutation" ,
			'message' => __( "Mutations::$mutation" , $Array )
		] ] ] ] );

		$this -> log(
			static::$console -> FunName( ) . " $log Case"  ,
			__( "Mutations::$mutation" , $Array ) ,
			'Mutations' ,
			( $Check ) ? 'success' : 'danger' ,
			$Code ,
			$Code
		) ;

		return $response ;
	}

	public function assertMessagesLog( String $typeUpdate , string $modName , Collection $Collection , String $type , array $data ) {

		$Message = __( "$typeUpdate::$modName.$type" , $data ) ;

		$this -> assertStringContainsString( $Collection -> firstWhere( 'type' , $type ) -> message , $Message ) ;

		$this -> log(
			static::$console -> FunName( ) . ' ' . $typeUpdate . ' on ' . $modName . ' ' . Str::afterLast( $type , '\\' ) . " Message" ,
			$Message    ,
			$typeUpdate ,
			'success'   ,
			true        ,
			200
		);

		return $this ;
	}

	public function assertBearerTokenResponse( TestResponse $response , string $functionName ) {

		$response -> assertJsonStructure ([ 'data' => [ $functionName => [ 'BearerTokenResponse' => [
			'access_token'  ,
			'refresh_token' ,
			'expires_in'    ,
			'token_type'
		] ] ] ]) ;

		return $this ;
	}

}
