<?php

namespace harby\services\Services;

use DB;

use App\Models\User;

use Laravel\Passport\Passport;
use Laravel\Passport\Bridge\AccessTokenRepository;
use Laravel\Passport\Bridge\RefreshTokenRepository;
use Laravel\Passport\Bridge\ScopeRepository;
use Laravel\Passport\Bridge\ClientRepository;

use League\OAuth2\Server\Grant\AbstractGrant;
use League\OAuth2\Server\CryptKey;

class BaseAuthClass extends AbstractGrant {

	public function __construct( ) {

		$this -> ScopeRepository = new ScopeRepository( );
		$this -> clients_id      = DB::table( 'oauth_clients' ) -> where( 'password_client' , 1 ) -> get( ) -> first( ) -> id ;
		$this -> Client          = app( ) -> make( ClientRepository::class ) -> getClientEntity( $this -> clients_id ) ;

		$this -> setAccessTokenRepository ( app( ) -> make( AccessTokenRepository::class )                                      );
		$this -> setRefreshTokenRepository( app( ) -> make( RefreshTokenRepository::class )                                     );
		$this -> setRefreshTokenTTL       ( Passport::refreshTokensExpireIn( )                                                  );
		$this -> setPrivateKey            ( new CryptKey( 'file://' . Passport::keyPath( 'oauth-private.key' ) , null , false ) );
		$this -> setEncryptionKey         ( app( 'encrypter' ) -> getKey( )                                                     );

	}

	public function respondToAccessTokenRequest( $request , $responseType , $accessTokenTTL ) { }

	public function getIdentifier( ) : string {
		return 'password' ;
	}

	public static function newMakeBearerToken( User $User ) : array {
		return ( new BaseAuthClass( ) ) -> makeBearerToken( $User ) ;
	}

	public function makeBearerToken( User $user ) : array {

		$finalizedScopes     = $this -> ScopeRepository -> finalizeScopes(
			$this -> validateScopes( [ ] ),
			$this -> getIdentifier( ) ,
			$this -> Client,
			$user -> id
		);
		$token               = $this -> issueAccessToken( Passport::tokensExpireIn( ) , $this -> Client , $user -> id , $finalizedScopes );
		$refreshToken        = $this -> issueRefreshToken( $token );
		$expireDateTime      = $token -> getExpiryDateTime( ) -> getTimestamp( ) - \time( ) ;
		$refreshTokenPayload = json_encode( [
			'client_id'        => $token        -> getClient         ( ) -> getIdentifier( ) ,
			'refresh_token_id' => $refreshToken -> getIdentifier     ( )                     ,
			'access_token_id'  => $token        -> getIdentifier     ( )                     ,
			'scopes'           => $token        -> getScopes         ( )                     ,
			'user_id'          => $token        -> getUserIdentifier ( )                     ,
			'expire_time'      => $refreshToken -> getExpiryDateTime ( ) -> getTimestamp(  ) ,
		] );

		return [
			'token_type'   	=> 'Bearer'          ,
			'expires_in'   	=> $expireDateTime   ,
			'access_token' 	=> ( string ) $token ,
			'refresh_token'	=> $this -> encrypt( $refreshTokenPayload )
		];

	}

}
