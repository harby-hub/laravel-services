<?php

namespace harby\services\GraphQL\Scalars;

use harby\services\Consts\regularExpression;

use harby\services\Abstracts\Scalars\type;

class HexadecimalColorWithAlpha extends type {

    public $name = "HexadecimalColorWithAlpha" ;

	public function parseValue( $value ) {
		if ( ! preg_match( regularExpression::HEXADECIMALCOLORWITHALPHAEGEX , $value ) ) $this -> Error( "Cannot represent following value as color:$this->printSafeJson( $value )" );
		return $value ;
	}

}