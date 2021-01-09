<?php

namespace harby\services\GraphQL\Scalars\Text;

use harby\services\GraphQL\Abstracts\Texts;

class NickName extends Texts {

	public $min = 3   ;
	public $max = 191 ;

	public function parseValue( $value ) {
		if ( strlen ( $value ) < $this -> min ) $this -> Error( "$this->name can not lower than : $this->min"   );
		if ( strlen ( $value ) > $this -> max ) $this -> Error( "$this->name can not greater than : $this->max" );
        return $this -> parseValueReturn( $value );
	}

} 