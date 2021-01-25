<?php

namespace harby\services\Middleware;

use Closure;

class addHeadersInOptionsRequest {

	public function handle( $request , Closure $next ) {

		if ( $request -> headers -> has( 'user-agent' ) && $request -> headers -> get( 'user-agent' ) === 'Symfony' ) return $next( $request ) ;

		if ( $request -> getMethod( ) == "GET" ) return $next( $request ) ;

		header( "Access-Control-Allow-Origin: *" ); 

		$headers = [
			'Access-Control-Allow-Methods' => 'POST,GET,OPTIONS,PUT,DELETE',
			'Access-Control-Allow-Headers' => 'Content-Type, X-Auth-Token, Origin, Authorization',
		];

		//The client-side application can set only headers allowed in Access-Control-Allow-Headers
		if ( $request -> getMethod( ) == "OPTIONS" ) return response( ) -> json( 'OK' , 200 , $headers );

		$response = $next( $request );
		foreach ( $headers as $key => $value ) $response -> header( $key , $value ); 
		return $response;

	}
}
