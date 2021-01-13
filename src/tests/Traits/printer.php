<?php

namespace harby\services\tests\Traits;

class printer extends mb_string {

	use arrow ;
	use bar   ;
	use color ;

	protected Int $Fulllines      = 0  ;
	protected Int $Fullcols       = 0  ;
	protected Int $logSpace       = 0  ;
	protected Int $logSpaceStatus = 15 ;
	protected Int $ceilStatus     = 3  ;

    public function __construct( ) {
		$this -> Fullcols  = exec ( 'tput cols'  ) - 2 ;
		$this -> Fulllines = exec ( 'tput lines' )     ;
		$this -> logSpace  = ceil( ( $this -> Fullcols - ( $this -> logSpaceStatus * $this -> ceilStatus ) ) / 2 )  ;
    }

	public function print( string $line ) : printer {
		fwrite( STDOUT , $line );
		return $this ;
	}

	public function printLine( string $first , string $repeat , string $last ) : printer {
		return $this
			-> print( $this -> default_color( $first  ) )
			-> print( $this -> default_color( $repeat ) )
			-> print( $this -> default_color( $last   ) )
		;
	}

	public function printNewPage( ) : printer {
		return $this
			-> print( $this -> repeat( $this -> MakeNewLine , $this -> Fulllines ) )
			-> print( $this -> EraseScreen                                         )
			-> print( $this -> MovesCursorToHome                                   )
		;
	}

	public function line_center( string $word , string $type = 'default_color' ) : printer {
		return $this -> line( $this -> text_center( $this -> $type( $word ) ) );
	}

	public function text_center( string $line , int $length = null ) : string {
		if( is_null( $length ) ) $length = $this -> Fullcols ;
		return $this -> str_pad( $line , $length , ' ' , STR_PAD_BOTH ) ;
	}

	public function line( $line ) : printer {
		return $this -> print(
			$this -> default_color( $this -> spaceColBar ) .
			$line .
			$this -> default_color( $this -> spaceColBar ) .
			$this -> EndLine .
			$this -> MakeNewLine 
		) ;
	}

	public function printflag( ) : printer {

		$number_format = number_format ( static::get_function_number ( ) / $this -> funcount     * 100 ) . '%' ;
		$class         = str_replace   ( [ ' Test' , ' Schema' ] , '' ,    $this -> getClassName ( )   )       ;
		$FunName       = str_replace   ( [ 'Test ' , 'Schema ' ] , '' ,    $this -> FunName      ( )   )       ;

		$line = 
			$this -> arrow( $number_format                  , $this -> textColor , $this -> warning , 'left'   ) .
			$this -> arrow( static::get_class_number    ( ) , $this -> textColor , $this -> warning , 'left'   ) .
			$this -> arrow( $class                          , $this -> textColor , $this -> success , 'center' ) .
			$this -> arrow( static::get_function_number ( ) , $this -> textColor , $this -> warning , 'right'  ) .
			$this -> arrow( $FunName                        , '0;0;0'            , $this -> info    , 'right'  )
		;

		return $this -> line( $this -> text_center( $line ) );

		return $this -> line_arrow_snake( $line ) ;

	}

	public function towcell( $line , $msg , $count = 15 ) {
		return $this -> printCells(
			[
				'print'  => " $line" ,
				"length" => $count   ,
			] , [
				'print'   => " $msg"         ,
				'color'   => $this -> danger ,
				'padType' => STR_PAD_RIGHT   ,
			]
		) -> printBarMake( [
			"unicode" => $this -> spacePluseBar ,
			"length"  => $count
		]) ;
	}

	public function printStartLogBar( ) {
		return $this -> printCells(
			[
				'print'  => 'status'                ,
				'length' => $this -> logSpaceStatus ,
			] ,
			[ 'print' => 'log'     ] ,
			[ 'print' => 'message' ] ,
			[
				'print'  => 'check'                 ,
				'length' => $this -> logSpaceStatus ,
			] ,
			[
				'print'  => 'code'                  ,
				'length' => $this -> logSpaceStatus ,
			]
		) -> printInLogBar( ) ;
    }

	public function log( string $line , string $msg , string $type = 'text' , string $color = 'success' , bool $check = null , int $code = null ) {
		$linewarp = explode( $this -> MakeNewLine , wordwrap( $line , $this -> logSpace - 3 , $this -> MakeNewLine , true ) ) ;
		$msgwarp  = explode( $this -> MakeNewLine , wordwrap( $msg  , $this -> logSpace - 3 , $this -> MakeNewLine , true ) ) ;
		$max	  = max( count ( $linewarp ) , count ( $msgwarp  ) ) - 1 ;
		for ( $i = 0 ; $i <= $max ; $i++ ) $this -> printCells([
			'print'   => $i === 0 ? $type   : '' ,
			'color'   => $this -> $color          ,
			'length'  => $this -> logSpaceStatus ,
		] , [
			'print'    => $linewarp[ $i ] ?? ' ' ,
			'color'    => $this -> $color         ,
			'hasArrow' => $i == $max             ,
			'padType' => STR_PAD_RIGHT            ,
		] , [
			'print'   => $msgwarp[ $i ] ?? ' ' ,
			'color'   => $this -> $color ,
		] , [
			'print'   => $i === 0 ? ( $check ? 'true' : 'false' ) : '' ,
			'length'  => $this -> logSpaceStatus ,
		] , [
			'print'   => $i === 0 ? ( $code === 200 ? 200 : $code ) : '' ,
			'length'  => $this -> logSpaceStatus ,
		] );
		return $this -> printInLogBar( );
	}

	public function printCells( ... $cells ) {
		$cellsHasNotLength = [ ] ;
		$LineParts         = [ ] ;
		foreach ( $cells as $key => $cell ){
			if ( ! is_array( $cell ) ) $cell = [ 'print' => $cell ] ;
			if ( array_key_exists( 'length' , $cell ) ) $LineParts[ $key ] = $this -> makeCell ( $cell ) ;
			else $cellsHasNotLength [ $key ] = $cell ;
		}
		$cellFullLength = ( $this -> Fullcols - count( $cells ) - $this -> length( implode( '' , $LineParts ) ) ) / count( $cellsHasNotLength ) + 2 ;
		foreach( $cellsHasNotLength as $key => $cell ) $LineParts[ $key ] = $this -> makeCell( $cell + [ 'length' => $cellFullLength - ( $key % 2 ) ]) ;
		ksort( $LineParts ) ;
		return $this -> line( implode( $this -> default_color( $this -> spaceColBar ) , $LineParts ) ) ;
	}

	public function makeCell( $cell ) {
		[
			'print'       => $print       ,
			'length'      => $length      ,
			'padType'     => $padType     ,
			'padStr'      => $padStr      ,
			'spaceColBar' => $spaceColBar ,
			'color'       => $color       ,
			'colorBg'     => $colorBg     ,
			'hasArrow'    => $hasArrow    ,
		] = array_merge( [
			'print'       => ' '                  ,
			'length'      => 10                   ,
			'padType'     => STR_PAD_BOTH         ,
			'padStr'      => ' '                  ,
			'spaceColBar' => $this -> spaceColBar ,
			'color'       => $this -> secondary   ,
			'colorBg'     => ''                   ,
			'hasArrow'    => false                ,
			] , $cell
		) ;
		$print = $this -> convert_html_to_ansi( $print ?? ' ' ) ;
		if( $hasArrow && ( $snakelenght = $length - $this -> length( $print ) ) >= 7 ) $print .= ' ' . $this -> arrow_snake ( $color , $snakelenght - 3 ) . ' ' ;
		return $this -> str_pad( $this -> wordColor( $print , $color , $colorBg ) , $length - 1 , $padStr , $padType ) ;
	}

}