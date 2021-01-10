<?php

namespace harby\services\tests\Traits;

use Str ;

use Illuminate\Testing\TestResponse ;

use Illuminate\Support\Collection ;

use Symfony\Component\Console\Command\Command;

use Tests\TestCase;

class testconsole extends printer {

	protected Int        $funcount         = 0 ;
	protected Int        $classcount       = 0 ;

	protected Collection $class_tree           ;
	protected Collection $fun_tree             ;
	protected Collection $class_map            ;
	protected Collection $class_method_map     ;

	protected  array           $getComments    = [ 'args' => null , 'Comments' => null ] ;
	protected  TestCase        $TestCase        ;
	protected \ReflectionClass $ReflectionClass ;

    public function __construct( ) {
		parent::__construct( );
		$this -> class_tree       = collect( require 'vendor/composer/autoload_classmap.php' );
		$this -> class_map        = collect( );
		$this -> class_method_map = collect( );
		$this -> fun_tree         = collect( );
		$this -> classes_in_namespace( );
		$this -> makeStatus( );
    }

	public function classes_in_namespace( ) {
		$this -> class_tree = $this -> class_tree
			-> keys   (                                                                                           )
			-> filter ( fn( $class ) => Str::startsWith( $class , 'Tests\\' ) && Str::endsWith( $class , 'Test' ) )
			-> values (                                                                                           )
		;
		$this -> classcount = $this -> class_tree -> count( ) ;
	}

	public function makeStatus( ) {
		$this -> class_tree -> map( function( $class ) {
			collect( get_class_methods( $class ) ) -> map( function( $method ) use ( $class ) {
				if( Str::startsWith( $method , 'test' ) ){
					$this -> class_map = $this -> class_map -> mergeRecursive([ $class => $method ] ) ;
					$this -> class_method_map -> push( $class . '::' . $method ) ;
					$this -> fun_tree -> push( $method ) ;
				}
			});
			return Str::startsWith( $class , 'Tests\\' ) && Str::endsWith( $class , 'Test' );
		});
		$this -> funcount  = $this -> fun_tree -> count( );
	}

	public function get_class_number( ) {
		return $this -> class_tree -> search( $this -> get_class( ) ) + 1 ;
	}

	public function get_function_number( ) : int {
		return $this -> class_method_map -> search( $this -> get_class( ) . '::' . $this -> FunNameParsa( ) ) + 1 ;
	}

	public function updateCase( TestCase $TestCase ) : testconsole {

		$this -> TestCase = $TestCase ;
		$this -> ReflectionClass = new \ReflectionClass( $this -> TestCase ) ;

		$this -> getComments = [ 'args' => [ ] , 'Comments' => [ ] ];

		preg_match_all( "#(@[a-zA-Z]+\s*[a-zA-Z0-9, ()_].*)#" , $this -> ReflectionClass -> getMethod( $this -> FunNameParsa( ) ) , $matches , PREG_PATTERN_ORDER );

		foreach( $matches[ 0 ] as $Comment ) if ( Str::contains( $Comment , '@' ) ){
			$key = ( string ) Str::of( $Comment ) -> match( '/@(\w*) /' ) ;
			   $this -> getComments [ 'args'     ] [ $key ] = Str::after( $Comment , "@$key " ) ;
		} else $this -> getComments [ 'Comments' ] [      ] = $Comment ;

		$this
			-> printNewPage  ( )
			-> printBarfirst ( )
			-> printflag     ( )
			-> printBarRow   ( )
		;

		if( $this -> getComments[ 'args' ] ){

			$this 
				-> line_center( 'comments \ args' , 'info' )
				-> printBarMake( [
					"unicode" => $this -> spaceDownBar ,
					"length"  => $this -> logSpaceStatus
				] )
			;

			foreach( $this -> getComments[ 'args' ] as $key => $val ) $this -> towcell( $key , $val , $this -> logSpaceStatus );

			$this
				-> print( $this -> removeLine )
				-> printBarMake( [
					"unicode" => $this -> spaceUpBar ,
					"length"  => $this -> logSpaceStatus
				] )
			;
	
		}

		return $this 
			-> line_center( 'logs' , 'info' )
			-> printBeforeLogBar( )
			-> printStartLogBar( )
		;

	}

	public function tearDown( ) : void {
		$this 
			-> print( $this -> removeLine )
			-> printAfterLogBar( )
			-> line_arrow_snake( ' ' . $this -> getClassName( ) . ' :: ' . $this -> FunName( ) . ' ' )
			-> printBarlast( )
			-> print( $this -> MakeNewLine )
		;
	}

	public function FunNameParsa( ){
		return ( String ) explode( ' ' ,  $this -> TestCase -> getName( ) )[ 0 ] ;
	}

	public function changeToTitle( String $String = '' ){
		return ( String ) Str::of( Str::of( $String ) -> kebab( ) -> replace( '-' , ' ' ) ) -> title( )  ;
	}

	public function get_class( ){
		return  get_class( $this -> TestCase ) ;
	}

	public function get_class_name( ){
		return Str::of( $this -> get_class( ) ) -> explode( '\\' )[ 2 ] ;
	}

	public function getClassName( ){
		return ( String ) $this -> changeToTitle( Str::of( $this -> get_class( ) ) -> explode( '\\' )[ 2 ] ) ;
	}

	public function FunName( ) : String {
		return ( String ) Str::of( Str::of( $this -> FunNameParsa( ) ) -> kebab( ) -> replace( '-' , ' ' ) ) -> title( )  ;
	}

	public function console( ) {

        $ref = new \ReflectionClass( $this ) ;

        $com =  $ref -> getMethod( explode( ' ' , $this -> FunNameParsa( ) )[ 0 ] );

		preg_match_all( "#(@[a-zA-Z]+\s*[a-zA-Z0-9, ()_].*)#" , $com , $matches , PREG_PATTERN_ORDER);

        dd(
            $ref -> inNamespace( ),
            $ref -> getName( ),
            Self::Class ,
            $this -> get_class( ),
            $ref -> getNamespaceName( ),
            $ref -> getShortName( ),
            class_basename( $this -> get_class( ) ) ,
            $com ,
            $matches ,
			$this -> class_tree,
			//$this -> class_map,
			//$this -> fun_tree,
			$this -> funcount,
			$this -> classcount,
			get_class( $this ) . '::' . explode( ' ' , $this -> FunNameParsa( )  )[ 0 ] ,
		);

		return $this ;

	}

}
