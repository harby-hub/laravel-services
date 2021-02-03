<?php

namespace harby\services\Services;

class Functions{

	const URLREGEX = 
		'_^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?'.
		'!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{'.
		'1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1'.
		'\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:'.
		'[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}-\x{ffff}0-9]+-?'.
		')*[a-z\x{00a1}-\x{ffff}0-9]+)(?:\.(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*['.
		'a-z\x{00a1}-\x{ffff}0-9]+)*(?:\.(?:[a-z\x{00a1}-\x{ffff}]{2,})))(?::'.
		'\d{2,5})?(?:/[^\s]*)?$_iuS'
	;

	const PASSWORDREGEX = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?).{8,}$/' ;

	const HEXADECIMALCOLORWITHALPHAEGEX = '/#([a-f]|[A-F]|[0-9]){4}(([a-f]|[A-F]|[0-9]){4})?\b/' ;

	public static function rand( int $length = 5 ) : int {
		return rand( pow( 10 , $length - 1 ) , pow( 10 , $length ) - 1 ) ;
	}

	public static function hashThing( $thing ) : String {
		return base64_encode( json_encode( $thing ) )  ;
	}

	public static function unhashThing( String $Hash ) {
		return json_decode( base64_decode( $Hash ) , true )  ;
	}

}
