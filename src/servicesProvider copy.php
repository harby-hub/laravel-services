<?php

namespace harby\services;

use DB;

use Illuminate\Support\ServiceProvider;

use Illuminate\Database\Eloquent\Builder;

use harby\services\Console\Commands\RequestsMakeCommand;
use harby\services\Console\Commands\ServiceMakeCommand;
use harby\services\Console\Commands\ModelMakeCommand;
use harby\services\Console\Commands\ControllerMakeCommand;
use harby\services\Console\Commands\MigrateMakeCommand;
use harby\services\Console\Commands\TestMakeCommand;

class BuilderProvider extends ServiceProvider {

    protected function register( ) {
		DB::connection( ) -> enableQueryLog( ) ;

		Builder::macro( 'tabelStatus' , function( ) {
			return DB::table( 'INFORMATION_SCHEMA.TABLES' )
				-> whereRaw( 'TABLE_SCHEMA = DATABASE( )' )
				-> where( 'TABLE_NAME' , $this -> getModel( ) -> getTable( ) )
				-> first( )
			;
		});
		Builder::macro( 'NewId' , function( ) {
			return $this -> tabelStatus( ) -> AUTO_INCREMENT ;
		});

		Builder::macro( 'createOrUpdateByPrimaryKey' , function( array $formatted_array ) {
			$id = $this -> getModel( ) -> getKeyName( ) ;
			if( ! array_key_exists( $id , $formatted_array ) ) return null ;
			else return $this -> updateOrCreate( [ $id => $formatted_array[ $id ] ] , $formatted_array );
		});
		Builder::macro( 'createOrUpdateWithoutGlobalScopes' , function( array $formatted_array ) {
			return $this -> getModel( ) -> WithoutGlobalScopes( ) -> createOrUpdateByPrimaryKey( $formatted_array );
		});
		Builder::macro( 'createOrUpdateSeed' , function( array $formatted_array ) {
			return collect( $formatted_array ) -> map( function( $formatted ) {
				return $this -> createOrUpdateWithoutGlobalScopes( $formatted );
			}) -> filter( );
		});

		Builder::macro( 'orWhereByString' , function( string $attribute , string $searchTerm ) {
			return $this -> orWhere( $attribute , 'REGEXP' , $searchTerm );
		});
		Builder::macro( 'whereByString' , function( $attributes , string $searchTerm ) {
			if ( ! is_array( $attributes ) ) $attributes = [ $attributes ] ;
			return $this -> where( function( $query ) use ( $attributes , $searchTerm ) {
				foreach( $attributes as $attribute ) $query -> orWhereByString( $attribute , $searchTerm ) ;
			} ) ;
		});
		Builder::macro( 'SearchByStrings' , function( $attributes , $searchTerm ) {
			if ( is_array( $searchTerm ) ) $searchTerm = implode( "|" , $searchTerm ) ;
			return $this -> whereByString( $attributes , $searchTerm ) ;
		});

		Builder::macro( 'WhereSub' , function( string $attribute , string $opr , Builder $builder ) {
			return $this -> WhereRaw( $attribute . ' ' . $opr . ' ( ' . $builder -> toSql( ) . ' ) ' , $builder -> getBindings( ) ) ;
		});
		Builder::macro( 'orWhereSub' , function( string $attribute , string $opr , Builder $builder ) {
			return $this -> orWhereRaw( $attribute . ' ' . $opr . ' ( ' . $builder -> toSql( ) . ' ) ' , $builder -> getBindings( ) ) ;
		});

    }

}
