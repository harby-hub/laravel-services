<?php

namespace harby\services\Traits\Boots;

trait globalBootTypeFunction {

    protected static function boot( ) {

        parent::boot( );

		static::addGlobalScope( 'all' , function ( $builder ) {
			$builder -> addSelect( '*' );
		});

		static::addGlobalScope( 'is_active' , function ( $builder ) {
			$builder -> where( with ( new static ) -> getTable( ) . '.is_active' , 1 );
		});

    }

}
