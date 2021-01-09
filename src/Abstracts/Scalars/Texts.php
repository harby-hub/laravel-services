<?php

namespace harby\services\Abstracts\Scalars;

use GraphQL\Language\AST\StringValueNode;

Abstract class Texts extends type {

	public function __construct( ) {
		$this -> description = "like normal string but limit from $this->min to $this->max characters" ;
	}

	public function serialize( $value ) {
		return $this -> serialize_string( ) ;
	}

	public function parseValueReturn( $value ) {
		return htmlspecialchars( $value , ENT_NOQUOTES , 'utf-8' , false );
	}

}