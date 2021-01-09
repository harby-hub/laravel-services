<?php

namespace App\Traits\Relations;

use App\Models\OauthAccessToken   ;
use App\Models\pincode            ;
use App\Models\Notification       ;
use App\Models\image              ;
use App\Models\session            ;
use App\Models\country            ;

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