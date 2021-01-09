<?php

namespace App\Traits\Attributes;

use Auth ;

trait UserAttributes {

    public function getisAuthAttribute( ) {
        return Auth::check( ) && Auth::id( ) === $this -> id /* && Auth::user( ) -> tokenCan( class_basename( static::class ) ) */ ;
    }

    public function receivesBroadcastNotificationsOn( ) {
        return class_basename( static::class ) . '.' . $this -> id ;
    }

    public function getneedPasswordAttribute( ) {
        return is_null( $this -> attributes[ 'password' ] ) ;
    }

    public function getforAuthAttribute( ) {
        if ( $this -> isAuth ) return $this ;
        else return null ;
    }

	public function getfirebaseIdsAttribute( ) {
		return $this -> authAcessTokens -> pluck( 'firebaseId' ) -> unique( ) -> values ( ) -> toArray( );
	}

	public function getcountNotificationsUnReadAttribute( ) {
		return $this -> unreadNotifications( ) -> count( ) ;
	}

}