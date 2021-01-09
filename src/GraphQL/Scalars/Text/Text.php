<?php

namespace harby\services\GraphQL\Scalars\Text;

use harby\services\Abstracts\Scalars\Texts;

class Text extends Texts {

	public $min  = null   ;
	public $max  = 65534  ;
	public $name = "Text" ;

	public function __construct( ) {

		$this -> description = "like normal string but limit from null to $this->max characters" ;

	}

	public function parseValue( $value ) {
		if ( strlen( $value ) > $this -> max ) $this -> Error( "$this->name can not greater than : $this->max" );
        return $this -> parseValueReturn( $value );
	}

}