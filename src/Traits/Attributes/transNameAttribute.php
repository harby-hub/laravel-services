<?php

namespace App\Traits\Attributes;

trait transNameAttribute{

	public function getnameAttribute( ) {
        return $this -> getNameTraslate( ) ;
	}

	public function getNameTraslate( String $lang = null ) {
        return trans( 'tables::' . with ( new static ) -> getTable( ) . '.' . $this -> context , [ ] , $lang ) ;
	}

}