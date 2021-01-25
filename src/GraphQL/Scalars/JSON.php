<?php

namespace harby\services\GraphQL\Scalars;

use Safe\Exceptions\JsonException;

use harby\services\Abstracts\Scalars\type;
use GraphQL\Language\AST\Node;

class JSON extends type {

    public $name = "JSON" ;
    public $description = 'Arbitrary data encoded in JavaScript Object Notation. See https://www.json.org/.';

    public function serialize( $value ): string {
        return \Safe\json_encode( $value );
    }

    public function parseValue( $value ) {
        return $this -> decodeJSON( $value );
    }

    public function parseLiteral( Node $valueNode, ?array $variables = NULL ) {
        if ( ! property_exists( $valueNode , 'value' ) ) $this -> Error( 'Can only parse literals that contain a value, got ' . $this -> printSafeJson( $valueNode ) );
        return $this -> decodeJSON( $valueNode -> value );
    }

    protected function decodeJSON( $value ) {
        try {
            $parsed = \Safe\json_decode( $value );
        } catch ( JsonException $jsonException ) {
            $this -> Error( $jsonException -> getMessage( ) );
        }
        return $parsed;
    }
}
