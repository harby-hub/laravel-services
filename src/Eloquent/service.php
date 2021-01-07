<?php 

namespace harby\services\Eloquent ;

use Validator;

abstract class service implements InterfaceService{

	public $code = 404		;

	public $check = true	;

	public $title	;

	public $message	;

	public $body	;

	public $errors	;

	public $Request	;

	abstract public function getRequest( );

	abstract public function getEvents( );

	public function validRequest( $inputs , $options = [ ] ){

		$validatedData = Validator::make( $inputs , $options );
		if ( $validatedData -> fails( ) ) return (array) [
			"code"		=> 402	,
			"check"		=> false,
			"body"		=> null ,
			"title"		=> 'error, check response body'			,
			"message"	=> __( 'error, check response body' )	,
			"errors"	=> $validatedData -> errors( ) 			,
		];

		else return (array) [
			"code"		=> 200	,
			"check"		=> true	,
			"errors"	=> null ,
			"title"		=> 'successful, all inputs is Valid'		,
			"message"	=> __( 'successful, all inputs is Valid' )	,
			"body"		=> $this -> getRequest( ) -> store( ) -> sanitize( ),
		];

	}

	public static function curl_get_file_contents( $url ){

		$c = curl_init( );
		curl_setopt( $c , CURLOPT_RETURNTRANSFER , 1 );
		curl_setopt( $c , CURLOPT_URL , $url );
		$contents = curl_exec( $c );
		$err  = curl_getinfo( $c , CURLINFO_HTTP_CODE );
		curl_close( $c );
		if ( $contents ) return json_decode( $contents ) ;
		else return FALSE ;

	}

	public function response( ) {
		return (array) [
			"code"		=> $this -> code	,
			"check"		=> $this -> check	,
			"title"		=> $this -> title	,
			"message"	=> $this -> message	,
			"body"		=> ( $check ) ? $this -> body	: null				,
			"errors"	=> ( $check ) ? null			: $this -> errors	,
		];
	}

}


