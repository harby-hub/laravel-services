<?php

namespace harby\services\GraphQL\Scalars;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;
use harby\services\Abstracts\Scalars\type;

class Email extends type {

    public $name        = "Email"                                                              ;
    public $description = 'A [RFC 5321](https://tools.ietf.org/html/rfc5321) compliant email.' ;

	public function parseValue( $value ) {
		if ( ! $this -> isValid( $value ) ) $this -> Error( "Cannot represent following value as color:$this->printSafeJson($value)" );
		return $value ;
    }

    protected function isValid( string $stringValue ) : bool {
        return ( new EmailValidator( ) ) -> isValid( $stringValue , new RFCValidation( ) );
    }
}
