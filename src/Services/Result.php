<?php

namespace harby\services\Services;

use DB;

abstract class Result {

	public static $code             = 200  ;
	public static $check            = true ;
	public static $title            = ''   ;
	public static $message          = ''   ;

	public static $MutationsName    = ''   ;

	public static $codeLog          = [ ]  ;
	public static $checkLog         = [ ]  ;
	public static $titleLog         = [ ]  ;
	public static $messageLog       = [ ]  ;

	public static $fieldName        = [ ]  ;
	public static $path             = [ ]  ;
	public static $FieldSelection  	= [ ]  ;
	public static $ReferencedFields	= [ ]  ;
	public static $ReferencedTypes 	= [ ]  ;
	public static $variablekeys     = [ ]  ;
	public static $variableValues  	= [ ]  ;

	public static $QueryLog         = [ ]  ;

	public static $Results          = [ ]  ;
	public static $RequestStatus    = [ ]  ;
	public static $Status           = [ ]  ;

	public function setResolveInfo( $resolveInfo ) : void {

		if ( env( 'APP_ENV' ) === 'local' ) {
			static::$fieldName        = array_merge( static::$fieldName        , [ $resolveInfo -> fieldName ]                          ) ;
			static::$path             = array_merge( static::$path             , $resolveInfo -> path                                   ) ;
			static::$FieldSelection   = array_merge( static::$FieldSelection   , array_keys( $resolveInfo -> getFieldSelection( ) )     ) ;
			static::$variablekeys     = array_merge( static::$variablekeys     , array_keys( $resolveInfo -> variableValues )           ) ;
			static::$variableValues   = array_merge( static::$variableValues   , $resolveInfo -> variableValues                         ) ;
			static::$ReferencedFields = array_merge( static::$ReferencedFields , $resolveInfo -> lookAhead( ) -> getReferencedFields( ) ) ;
			static::$ReferencedTypes  = array_merge( static::$ReferencedTypes  , $resolveInfo -> lookAhead( ) -> getReferencedTypes(  ) ) ;
		}

		static::QueryLog( ) ;

		static::$MutationsName = debug_backtrace( )[ 1 ][ 'function' ] ;

		static::$Status = [
			'code'    => static::$code    = 200  ,
			'check'   => static::$check   = true ,
			'title'   => static::$title   = ''	 ,
			'message' => static::$message = ''   ,
		];

	}

	public static function QueryLog( ) : array {
		foreach( DB::getQueryLog( ) as $Log ) static::$QueryLog = array_merge( static::$QueryLog , [ $Log ] ) ;
		return static::$QueryLog ;
	}

	public function updateResult( string $key , int $code = 502 , bool $check = false , Array $data = [ ] ) : Result {

		$title = 'Mutations::' . class_basename( static::class ) . '.' . static::$MutationsName . '.' . $key ;

		static::$Results = array_merge( static::$Results , [ static::$Status = [
			'code'    => static::$code    = $code          ,
			'check'   => static::$check   = $check         ,
			'title'   => static::$title   = $title         ,
			'message' => static::$message = __    ( $title , $data ) ,
		] ] ) ;

		static::$codeLog    = array_merge( static::$codeLog    , [ static::$code    ] ) ;
		static::$checkLog   = array_merge( static::$checkLog   , [ static::$check   ] ) ;
		static::$titleLog   = array_merge( static::$titleLog   , [ static::$title   ] ) ;
		static::$messageLog	= array_merge( static::$messageLog , [ static::$message ] ) ;

		return $this ;
	}

	public function makeResult( array $array = [ ] ) : array {

		static::QueryLog( ) ;

		static::$RequestStatus = [
			'fieldName'			=> static::$fieldName		,
			'path'				=> static::$path			,
			'FieldSelection'	=> static::$FieldSelection	,
			'ReferencedFields'	=> static::$ReferencedFields,
			'ReferencedTypes'	=> static::$ReferencedTypes	,
			'variablekeys'		=> static::$variablekeys	,
			'variableValues'	=> static::$variableValues	,
			'QueryLog'			=> static::$QueryLog		,
			'codeLog'			=> static::$codeLog			,
			'checkLog'			=> static::$checkLog		,
			'titleLog'			=> static::$titleLog		,
			'messageLog'		=> static::$messageLog		,
			'Results'			=> static::$Results			,
		];

		return array_merge( $array , [
			'RequestStatus' => static::$RequestStatus,
			'Status'		=> static::$Status
		] ) ;
	}

}