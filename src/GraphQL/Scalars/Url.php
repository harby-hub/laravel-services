<?php

namespace harby\services\GraphQL\Scalars;

use harby\services\Services\Functions;

use harby\services\GraphQL\Abstracts\type;

class Url extends type {

	public function serialize( $value ) {
		return $value;
	}

	public function parseValue( $value ) {
		if ( empty( $value ) ) return '' ;
		$value = filter_var( $value , FILTER_SANITIZE_URL ) ;
		if ( ! preg_match( Functions::URLREGEX , $value ) ) $this -> Error( "Cannot represent following value as Url: " . $this -> printSafeJson( $value ) );
		return $value ;
	}

}