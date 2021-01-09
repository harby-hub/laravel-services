<?php

namespace harby\services\GraphQL\Scalars\Date;

use Carbon\Carbon;

use harby\services\Abstracts\Scalars\DateScalar ;

class Time extends DateScalar {

    public string $pattern = 'H:i:s' ;

    protected function format( Carbon $carbon ) : string {
        return $carbon -> toTimeString( );
    }

}
