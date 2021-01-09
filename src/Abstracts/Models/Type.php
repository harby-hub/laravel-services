<?php

namespace harby\services\Abstracts\Models;

use App\Traits\Attributes\transNameAttribute;
use App\Traits\Boots\globalBootTypeFunction;
use App\Traits\Scopes\getIdInTypeScope;
use App\Traits\Scopes\RandemScope;
use Illuminate\Database\Eloquent\SoftDeletes;

Abstract class Type extends \Eloquent {
    use transNameAttribute     ;
    use globalBootTypeFunction ;
    use getIdInTypeScope       ;
    use RandemScope            ;
}