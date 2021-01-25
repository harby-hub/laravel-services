<?php

namespace harby\services\GraphQL\Scalars\Text;

use harby\services\Abstracts\Scalars\Texts;

class Name extends Texts {

	public $min  = 3      ;
	public $max  = 191    ;
	public $name = "Name" ;

	public function parseValue( $value ) {
		if ( is_null ( $value )                ) $this -> Error( "$this->name can not be null"                   );
		if ( strlen  ( $value ) < $this -> min ) $this -> Error( "$this->name can not lower than : $this->min"   );
		if ( strlen  ( $value ) > $this -> max ) $this -> Error( "$this->name can not greater than : $this->max" );
        return $this -> parseValueReturn( $value );
	}

} 