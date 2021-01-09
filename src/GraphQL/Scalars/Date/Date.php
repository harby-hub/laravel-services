<?php

namespace harby\services\GraphQL\Scalars\Date;

use Carbon\Carbon;

use harby\services\Abstracts\Scalars\DateScalar ;

class Date extends DateScalar {

    public string $pattern = 'Y-m-d' ;

    protected function format( Carbon $carbon ) : string {
        return $carbon -> toDateString( );
    }

}
