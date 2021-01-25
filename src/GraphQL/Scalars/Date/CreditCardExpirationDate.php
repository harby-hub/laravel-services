<?php

namespace harby\services\GraphQL\Scalars\Date;

use Carbon\Carbon;

use harby\services\Abstracts\Scalars\DateScalar ;

class CreditCardExpirationDate extends DateScalar {

    public $name = "CreditCardExpirationDate" ;
    public string $pattern = 'm/Y' ;

    protected function format( Carbon $carbon ) : string {
        return $carbon -> format( $this -> pattern );
    }

}
