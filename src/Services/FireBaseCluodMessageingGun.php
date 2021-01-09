<?php

namespace harby\services\Services;

use GuzzleHttp\Client ;

/*
	* d8TSNgP7Q1SdzTwhsJEUzo:APA91bGvrAnTTBV9u1aYj80YexBcKguT2T7F4qbPfxJ1lOw7Hu1jMBlI2OB7jtH_y_7aXB2_mg7rTKyWaVtQ-ZeTS-y6KP8trIHcfxtzZA-0ZisDRstKymLECmaa5xAxznsfvfc4dWJi
*/

class FireBaseCluodMessageingGun {

	public $tokens ;

	public $body   ;

	public $data   ;

    public function __construct( array $tokens , string $body , array $data ) {
		$this -> tokens = $tokens ;
		$this -> body   = $body   ;
		$this -> data   = $data   ;
	}

	protected function push( ) : array {

		return ( new Client ( [ 'base_uri' => 'https://fcm.googleapis.com/' ] ) ) -> request( 'POST' , 'fcm/send' , $this -> requestDAta( ) ) -> getBody( ) ;

	}

	protected function requestDAta( ) : array {
		return [
			'headers' =>  [
				'Content-Type'  => 'application/json' ,
				'Authorization' => 'key=' . env( 'FIREBASE_LEGACY' )
			],
			'body'    => json_encode( [
				'registration_ids' => $this -> tokens , 
				'data' => [
					'data'    => $this -> data     ,
					'title'   => env( 'APP_NAME' ) ,
					'body'    => $this -> body     ,
					'sound'   => 1                 ,
					'vibrate' => 1                 ,
				]
			] )
		] ;
	}

	static public function fire( array $tokens , string $body , array $data ) {

		return ( ! empty( $tokens ) ) ? ( new static( $tokens , $body , $data ) ) -> push( ) : null ;

	}

}