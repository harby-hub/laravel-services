<?php

namespace harby\services\Traits\Scopes;
use Illuminate\Database\Eloquent\Builder ;

trait getIdInTypeScope {

	public function scopegetId( Builder $query , string $key ) :? Int {
		$record = $query -> withoutGlobalScope( 'Admin' ) -> where( 'context' , $key ) -> first( );
		if ( $record ) return $record -> id ;
		else return null ;
	}

	public function scopefindByContext( Builder $query , string $key ) {
		return $query -> withoutGlobalScope( 'Admin' ) -> where( 'context' , $key ) -> first( );
	}

	public function scopeid_MimeType( Builder $query , string $value ) {
		return $query -> where( 'mime_type' , $value ) -> first( ) -> id ;
	}

	public function scopeis_MimeType_exist( Builder $query , string $value ) : bool {
		return $query -> where( 'mime_type' , $value ) -> exists( ) ;
	}

}