<?php

namespace harby\services\GraphQL\Scalars\Text;

use GraphQL\Error\Error;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Type\Definition\ScalarType;

class ShortText extends Text {
	public $max  = 191         ;
    public $name = "ShortText" ;
}