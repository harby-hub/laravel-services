<?php 

namespace harby\services\Eloquent ;

use Validator;
//use harby\services\Interfaces\Request as InterfaceRequest;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;

abstract class Request /* implements InterfaceRequest*/ {
	use HasAttributes;

	public function rules( ) {
		return $this -> rules ;
	}


	public function sanitize( ) {
		$input = collect( $this -> form );

		foreach ( $this -> rules as $key => $rules ) {
			switch ( explode( '|' , $rules ) [ 1 ] ) {
				case 'email'		: $input [ $key ] = filter_var( $input [ $key ] , FILTER_SANITIZE_EMAIL		)	; break	;
				case 'url'			: $input [ $key ] = filter_var( $input [ $key ] , FILTER_SANITIZE_URL			)	; break	;
				case 'string'		: $input [ $key ] = filter_var( $input [ $key ] , FILTER_SANITIZE_STRING		)	; break	;
				case 'date'			: $input [ $key ] = filter_var( $input [ $key ] , FILTER_SANITIZE_STRING		)	; break	;
				case 'date_format'	: $input [ $key ] = filter_var( $input [ $key ] , FILTER_SANITIZE_STRING		)	; break	;
				case 'numeric'		: $input [ $key ] = filter_var( $input [ $key ] , FILTER_SANITIZE_NUMBER_INT	)	; break	;
				case 'Boolean'		: $input [ $key ] = ( $input [ $key ] ) ? true : false							; break	;
				default: $input -> $key = $input -> $key ;
			}
		}

		return $input -> all( ) ;
	}

}