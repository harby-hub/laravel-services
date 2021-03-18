<?php

namespace harby\services\Services;

use GuzzleHttp\Client ;

class FireBaseCluodMessageingGun {

	/** 
     *
	 * FireBase id tokens that will reserve massages
	 * 
	 * @var string[] $tokens
	*/
	public array $tokens ;

	/** 
     *
	 * FireBase massages body
	 * 
	 * @var string $body
	*/
	public $body   ;

	/** 
     *
	 * FireBase massages all attrs will send with massage
	 * 
	 * @var array $data
	*/
	public $data   ;

    /**
     * Create a new FireBase Cluod Messageing.
     *
	 * @var string[] $tokens
	 * @var string $body
	 * @var array $data
     * @return void
     */
    public function __construct( array $tokens , string $body , array $data ) {
		$this -> tokens = $tokens ;
		$this -> body   = $body   ;
		$this -> data   = $data   ;
	}

    /**
     * push Cluod Messageing.
     *
     * @return array
     */
	protected function push( ) : array {

		return ( new Client ( [ 'base_uri' => 'https://fcm.googleapis.com/' ] ) ) -> request( 'POST' , 'fcm/send' , $this -> request( ) ) -> getBody( ) ;

	}

    /**
     * make request attrs to send.
     *
     * @return array
     */
	protected function request( ) : array {
		return [
			'headers' =>  [
				'Content-Type'  => 'application/json' ,
				'Authorization' => 'key=' . env( 'FIREBASE_LEGACY' )
			],
			'body'    => json_encode( [
				'registration_ids' => $this -> tokens , 
				'data' => [
					'title'   => env( 'APP_NAME' ) ,
					'data'    => $this -> data     ,
					'body'    => $this -> body     ,
					'sound'   => 1                 ,
					'vibrate' => 1                 ,
				]
			] )
		] ;
	}

	/** 
	   static function to send massage
	 * @param string[] $tokens
     * @param string $body
     * @param array $data
	 * @return array|null
	*/
	static public function fire( array $tokens , string $body , array $data ) {
		return ( ! empty( $tokens ) ) ? ( new static( $tokens , $body , $data ) ) -> push( ) : null ;
	}

}