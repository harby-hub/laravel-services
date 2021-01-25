<?php

namespace harby\services\Abstracts\Models;

use harby\services\Traits\Attributes\transNameAttribute;
use harby\services\Traits\Boots\globalBootTypeFunction;
use harby\services\Traits\Scopes\getIdInTypeScope;
use harby\services\Traits\Scopes\RandemScope;
use Illuminate\Database\Eloquent\SoftDeletes;

Abstract class Type extends \Eloquent {
    use transNameAttribute     ;
    use globalBootTypeFunction ;
    use getIdInTypeScope       ;
    use RandemScope            ;
}