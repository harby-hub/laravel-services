<?php

namespace harby\services\GraphQL\Scalars;

use harby\services\Services\Functions;

use harby\services\GraphQL\Abstracts\type;

class hexadecimalColorWithAlpha extends type {

	public function parseValue( $value ) {
		if ( ! preg_match( Functions::HEXADECIMALCOLORWITHALPHAEGEX , $value ) ) $this -> Error( "Cannot represent following value as color:$this->printSafeJson( $value )" );
		return $value ;
	}

}