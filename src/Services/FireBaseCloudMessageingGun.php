<?php

namespace harby\services\Services;

use Illuminate\Support\Facades\Http;

class FireBaseCloudMessageingGun {

	/** 
     *
	   FireBase id tokens that will reserve massages
	 * 
	 * @var string[] $tokens
	*/
	public array $tokens ;

	/** 
     *
	   FireBase massages Notification attrs will send with massage
	 * 
	 * @var array $Notification
	*/
	public $Notification   ;

	/** 
     *
	   FireBase massages all attrs will send with massage
	 * 
	 * @var array $data
	*/
	public $data   ;

    /**
       Create a new FireBase Cloud Messageing.
     *
	 * @var string[] $tokens
     * @param string $Notification
	 * @var array $data
     * @return void
     */
    public function __construct( array $tokens , array $Notification , array $data ) {
		$this -> tokens       = $tokens       ;
		$this -> Notification = $Notification ;
		$this -> data         = $data         ;
	}

    /**
     * push Cloud Messageing.
     *
     * @return array|mixed
     */
	protected function push( ) : array {
		return Http::withHeaders( $this -> Headers( ) ) -> post( 'https://fcm.googleapis.com/fcm/send' , $this -> request( ) ) -> json( ) ;
	}

    /**
       make request attrs to send.
     *
     * @return array
     */
	protected function request( ) : array { return [
		'registration_ids' => $this -> tokens       ,
		'notification'     => $this -> Notification ,
		'data'             => $this -> data         ,
	] ; }

    /**
       make request attrs to send.
     * @return array
     */
	protected function Headers( ) : array { return [
		'Content-Type'  => 'application/json' ,
		'Authorization' => 'key=' . env( 'FIREBASE_LEGACY' )
	] ; }

	/** 
	   static function to send massage
	 * @param string[] $tokens
     * @param string $Notification
     * @param string $body
     * @param array $data
	 * @return array
	*/
	static public function fire( array $tokens , array $Notification , array $data ) : array {
		return ( ! empty( $tokens ) ) ? ( new static( $tokens , $Notification , $data ) ) -> push( ) : [ ] ;
	}

}