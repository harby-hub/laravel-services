<?php

namespace harby\services\Middleware;

use Closure;
use Auth;

class Localization {
  	public function handle( $request , Closure $next ) {
    	$local = ( $request -> hasHeader( 'localization' ) ) ? $request -> header( 'localization' ) : 'en' ;
		app( ) -> setLocale( $local );
		if ( Auth::check( ) && Auth::user( ) -> Locale != $local ) Auth::user( ) -> setLocale( );
    	return $next( $request );
  	}
}
