<?php

namespace harby\services\Middleware;

use Closure;
use Auth;

class IfHaveHeaderAuth {
    public function handle( $request , Closure $next ) {
        if ( Auth::           user( ) ) return $next( $request                     );
        if ( auth( 'api' ) -> user( ) ) Auth:: login( auth    ( 'api' ) -> user( ) );
        return $next($request);
    }
}
