<?php 

namespace harby\services\Eloquent ;

use Validator;
use harby\services\Interfaces\service as InterfaceService;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;

abstract class service implements InterfaceService{
	use HasAttributes;

	public $code	= 200	;

	public $check	= true	;

	public $title	= ''	;

	public $message	= ''	;

	public $body	= []	;

	public $errors	= []	;

	public $Request	;

	abstract public function getRequest( );

	abstract public function getEvents( );

	/**
	 * Dynamically retrieve attributes
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	public function __get( $key ) {
		return $this -> getAttribute( $key );
	}

	public static function whoAmI() {
		return static::class ;
	}

	public function __( $key ) {
		return __( static::class . '.' . $key );
	}

	public function __Valid( $key ) {
		return $this -> __( 'Valid.' . $key );
	}

	public function validRequest(
		array	$form ,
		string	$options
	) : object {
		$Request		= $this		-> getRequest( ) -> $options( $form );
		$sanitize		= $Request	-> sanitize( );
		$rules			= $Request	-> rules( );

		$validatedData	= Validator::make( $sanitize , $rules );

		if ( $validatedData -> fails( ) ) return $this -> responseError(
			'error, check response body for' . debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS ) [ 0 ][ "function" ]	,
			$this -> __Valid( 'error' )	,
			$validatedData -> errors( )
		);

		return $this -> responseSuccessful(
			'successful, all inputs is Valid for' . debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS )[ 0 ][ "function" ]	,
			$this -> __Valid( '.successful' ) ,
			$sanitize
		);

	}

	public static function curl_get_file_contents( $url ) : array {

		$c = curl_init( );

		curl_setopt( $c , CURLOPT_RETURNTRANSFER , 1 );
		curl_setopt( $c , CURLOPT_URL , $url );

		$contents	= curl_exec( $c );
		$err		= curl_getinfo( $c , CURLINFO_HTTP_CODE );

		curl_close( $c );

		if ( $contents ) return $this -> responseSuccessful(
			'successful, all inputs is Valid for curl',
			'successful, all inputs is Valid for curl',
			$contents
		);

		return $this -> responseError(
			'error, check response body for curl',
			'error, check response body for curl',
			$err
		);

	}

	public function responseSuccessful(

		string	$title		= '' ,
		string	$message	= '' ,
		array	$body		= [ ]

	) : object {

		return service::_return(
			200			,
			true		,
			$title		,
			$message	,
			$body		,
			[]
		);

	}

	public function responseError(

		string	$title		= '' ,
		string	$message	= '' ,
		array	$errors		= [ ]

	) : object {

		return service::_return(
			402			,
			false		,
			$title		,
			$message	,
			[]			,
			$errors
		);

	}

	public function response( ) : object {

		return service::_return(
			$this -> code	,
			$this -> check	,
			$this -> title	,
			$this -> message,
			$this -> body	,
			$this -> errors
		);

	}

	static public function _return (

		int		$code		= 200	,
		bool	$check		= true	,
		string	$title		= ''	,
		string	$message	= ''	,
		array	$body		= [ ]	,
		array	$errors		= [ ]

	) : object {

		return ( object ) [
			"code"		=> (int)	$code	,
			"check"		=> (bool)	$check	,
			"title"		=> (string)	$title	,
			"message"	=> (string)	$message,
			"body"		=> ( $check ) ? (array) $body	: null 				,
			"errors"	=> ( $check ) ? null			: (array) $errors	,
		];

	}

}


