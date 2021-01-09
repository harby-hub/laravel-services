<?php

namespace App\Traits\Methods;

use Storage;
use Hash;

use App\Services\BaseAuthClass	;
use App\Models\image        	;

trait UserMethods {

	public static function Storage( ) {
		return Storage::disk( class_basename( static::class ) );
	}

	public function setLocale( ) {

		$this -> Locale = app( ) -> getLocale( )  ;
		$this -> save( ) ;

	}

	public function EditPassword( $password ) {

		$this -> password = $password ;
		$this -> save( ) ;
		return $this -> refresh( ) ;

	}

	public function HashAndEditPassword( $password ) {

		return $this -> EditPassword( Hash::make( $password ) );

	}

	public function MakeBearerToken( ) {

		return ( new BaseAuthClass( ) ) -> makeBearerToken( $this , class_basename( static::class ) ) ;

	}

	public function updateProfile( array $args ) {

		$this -> updateBaseData( $args );

		return $this ;

	}

	public function sessionsDelete( int $id ) {

		$this -> sessions( ) -> where( 'id' , $id  ) -> update( [ 'delete_for_students' => now( ) ] ) ;

		return $this ;

	}

	public function broadcastAttributes( ) {
		return [
			"my_id"                       => $this -> id                       ,
			"my_countNotificationsUnRead" => $this -> countNotificationsUnRead ,
		] ;
	}

}
