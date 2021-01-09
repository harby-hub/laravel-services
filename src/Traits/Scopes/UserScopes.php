<?php

namespace harby\services\Traits\Scopes;

use Auth ;

trait UserScopes {

    use RandemScope ;

    public function scopeIsActive( $query ){
        return $query -> where( 'is_active' , 1 );
    }

    public function scopebyEmail( $query , $email ){
        return $query -> where( 'email' , $email ) ;
    }

    public function scopegetByEmail( $query , $email ){
        return $query -> byEmail( $email ) -> get( );
    }

    public function scopeConditions( $query ){
        return $this -> IsActive( ) ;
    }

    public function findForPassport( $email ) {
        return $this -> where( 'email' , $email ) -> first( );
    }

    public function scopeWithoutAuth( $query ) {
        return $query -> where( with ( new static ) -> getTable( ) . '.id' , '!=' , Auth::id( ) ) ;
    }

}