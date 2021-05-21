<?php

namespace harby\services\GraphQL\Scalars\Text;

use Illuminate\Support\Facades\Hash;

use harby\services\Consts\regularExpression;

use harby\services\Abstracts\Scalars\type;

class PassWord extends type {
    public $name = "PassWord" ;

	public function parseValue( $value ) {
		if ( ! preg_match( regularExpression::PASSWORDREGEX , $value ) ) $this -> Error( "Cannot represent following value as Password: $this->printSafeJson($value)" );
		return Hash::make( $value );
	}

}
