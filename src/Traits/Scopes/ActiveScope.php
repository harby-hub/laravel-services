<?php

namespace App\Traits\Scopes;

trait ActiveScope {

    public function scopegetActiveForUser( $query , $user_id ){
        return $query -> withoutGlobalScope( 'is_active' ) -> where( 'user_id' , $user_id ) -> get( ) ;
    }

}
