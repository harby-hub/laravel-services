<?php

namespace harby\services\Traits\Relations;

use harby\services\Models\OauthAccessToken   ;
use harby\services\Models\pincode            ;
use harby\services\Models\Notification       ;
use harby\services\Models\image              ;
use harby\services\Models\country            ;

trait UserRelations {

	public function authAcessTokens( ){
		return $this -> hasMany( OauthAccessToken::class );
	}

	public function profile_image( ) {
		return $this -> belongsTo( image::class , 'profile_image_id' );
	}

	public function pincode( ) {
		return $this -> hasOne( pincode::class );
	}

    public function Notifications( ) {
        return $this -> morphMany( Notification::class , 'notifiable' ) -> orderBy( 'created_at' , 'desc' );
    }

	public function country( ) {
		return $this -> belongsTo( country::class );
	}

}