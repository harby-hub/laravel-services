<?php

namespace harby\services\GraphQL\Scalars\Text;

use Illuminate\Support\Facades\Hash;

use harby\services\Services\Functions;

use harby\services\GraphQL\Abstracts\type;

class PassWord extends type {

	public $name = 'Password';

	public function parseValue( $value ) {
		if ( ! preg_match( Functions::PASSWORDREGEX , $value ) ) $this -> Error( "Cannot represent following value as Password: $this->printSafeJson($value)" );
		return Hash::make( $value );
	}

}
