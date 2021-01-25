<?php

namespace harby\services\Traits\Methods;

trait ActiveMethods {

    public function disActive( ) {

        $this -> is_active = 0 ;
        $this -> save( ) ;

    }

    public function beActive( ) {

        $this -> is_active = 1 ;
        $this -> save( ) ;

    }

}
