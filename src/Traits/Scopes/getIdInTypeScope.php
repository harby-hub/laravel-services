<?php

namespace harby\services\Traits\Scopes;

trait getIdInTypeScope {

	public function scopegetId( $query , $key ) {
		$record = $query -> withoutGlobalScope( 'Admin' ) -> where( 'context' , $key ) -> first( );
		if ( $record ) return $record -> id ;
		else return null ;
	}

	public function scopefindByContext( $query , $key ) {
		return $query -> withoutGlobalScope( 'Admin' ) -> where( 'context' , $key ) -> first( );
	}

}