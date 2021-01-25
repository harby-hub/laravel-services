<?php

namespace harby\services\Traits\Scopes;

trait RandemScope {

    public function scopeRandem( $query , $number ){
        return $this -> limit( $number ) -> inRandomOrder( ) -> get( ) ;
    }

    public function scopeRandemOne( $query ){
        return $this -> Randem( 1 ) -> first( ) ;
    }

}
