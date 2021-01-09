<?php

namespace harby\services\GraphQL\Scalars\Date;

use Carbon\Carbon;

use harby\services\Abstracts\Scalars\DateScalar ;

class DateTime extends DateScalar {

    public string $pattern = Carbon::DEFAULT_TO_STRING_FORMAT ;

    protected function format( Carbon $carbon ) : string {
        return $carbon -> toDateTimeString( );
    }

}
