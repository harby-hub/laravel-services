<?php

namespace harby\services\Middleware;

use Closure;

class convertGraphQLVariablesToRequestVariables {
    public function handle( $request , Closure $next ) {
        if ( $request -> operations ) $vars = json_decode( $request -> operations , true ) [ 'variables' ] ;
        if ( $request -> variables  ) $vars = $request -> variables ;
        if ( is_array( $vars ) && count( $vars ) ){
            $request -> request -> add( $vars );
            if ( $request -> variables === null  ) $request -> request -> add( [ 'variables' => $vars ] );
        };
        return $next( $request );
    }
}
