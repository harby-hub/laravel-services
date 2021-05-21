<?php

namespace harby\services\GraphQL\Scalars;

use harby\services\Consts\regularExpression;

use harby\services\Abstracts\Scalars\type;

class Url extends type {

	public $name = "Url" ;

	public function parseValue( $value ) {
		if ( empty( $value ) ) return '' ;
		$value = filter_var( $value , FILTER_SANITIZE_URL ) ;
		if ( ! preg_match( regularExpression::URLREGEX , $value ) ) $this -> Error( "Cannot represent following value as Url: " . $this -> printSafeJson( $value ) );
		return $value ;
	}

}