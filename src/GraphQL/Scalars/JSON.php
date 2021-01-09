<?php

namespace harby\services\GraphQL\Scalars;

use Safe\Exceptions\JsonException;

use harby\services\GraphQL\Abstracts\type;

class JSON extends type {

    public $description = 'Arbitrary data encoded in JavaScript Object Notation. See https://www.json.org/.';

    public function serialize( $value ): string {
        return \Safe\json_encode( $value );
    }

    public function parseValue( $value ) {
        return $this -> decodeJSON( $value );
    }

    public function parseLiteral( $valueNode ) {
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
