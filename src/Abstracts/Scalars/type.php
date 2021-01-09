<?php

namespace harby\services\Abstracts\Scalars;

use GraphQL\Error\Error;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Type\Definition\ScalarType;

Abstract class type extends ScalarType {

	public function serialize( $value ) {
		return $value ;
	}

	public function serialize_string( $value ) {
		return mb_substr( htmlspecialchars( $value , ENT_NOQUOTES , 'utf-8' , false ) , 0 , $this -> max );
	}

	public function Error( string $message , mix $nodes = null ) {
		throw new Error( $message , $nodes );
	}

	public function printSafeJson( $var ) {
        if ( $var instanceof stdClass ) $var = ( array ) $var ;
        if ( is_array(  $var ) ) return json_encode( $var )      ;
        if ( $var === ''       ) return '(empty string)'         ;
        if ( $var === null     ) return 'null'                   ;
        if ( $var === false    ) return 'false'                  ;
        if ( $var === true     ) return 'true'                   ;
        if ( is_string( $var ) ) return sprintf( '"%s"' , $var ) ;
        if ( is_scalar( $var ) ) return ( string ) $var          ;
        return gettype( $var );
	}

	public function parseLiteral( $valueNode ) {
		if ( ! $valueNode instanceof StringValueNode ) $this -> Error( 'Query error: Can only parse strings got: ' . $valueNode -> kind , [ $valueNode ] );
		return $valueNode -> value;
	}

}