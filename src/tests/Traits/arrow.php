<?php

namespace harby\services\tests\Traits;

trait arrow {

    protected string $RightwardsArrow = '' ;
    protected string $LeftwardsArrow  = '' ;
	protected Int    $arraycount       = 0 ;

	protected array $arrayLog   = [
		'~' , '@' , '+' , '#' , '=' ,
		'$' , '-' , '%' , '>' , '&' ,
		'═' , '◇' , '☭' , '☸' , '☮' ,
		'☯' , '☪' , '☢' , '☣' , '☤' ,
		'☩' , '♆' , '☫' , '⚛' , '⇄' ,
		'⌘' , '↬' , '⇭' , '✇' , '☘' ,
		'⚜' , '⚙' , '✉' , '✠' , '❄' ,
		/* 
		'⛺' , '⛹' , '✌' , '⛽' ,
		'⛤' , '⛧' , '⛥' , '⛦' ,
		'☷' , '⚝' , '⎆' , '⛯' ,
		'֍' , '֎' , '⏣' , '⌬' ,
		'⎔' , '֎' , '⏣' , '⌬' ,
		'⌗' , '۞' , '࿎' , '࿌' ,
		'࿈' , '࿏' , '⛓' ,
		*/
	] ;

	public function start_arrow( string $type = 'right' , String $backgroundColor = '242;242;242' ) : string {
		if( $type === "right" ) return $this -> wordColor ( $this -> RightwardsArrow , null , $backgroundColor ) ;
		else                    return $this -> wordColor ( $this -> LeftwardsArrow  ,        $backgroundColor ) ;
	}

	public function end_arrow( string $type = 'right' , String $backgroundColor = '242;242;242' ) : string {
		if( $type === "left" ) return $this -> wordColor ( $this -> LeftwardsArrow  , null , $backgroundColor ) ;
		else                   return $this -> wordColor ( $this -> RightwardsArrow ,        $backgroundColor ) ;
	}

	public function arrow( String $word , String $foregroundColor , String $backgroundColor = '242;242;242' , string $type = 'right' ) : string {
		return
			$this -> start_arrow( $type                                , $backgroundColor ) .
			$this -> wordColor  ( ' ' . $word . ' ' , $foregroundColor , $backgroundColor ) .
			$this -> end_arrow  ( $type                                , $backgroundColor )
		;
	}

	public function autoIncrementArrayLogCounter( ) : printer {
		( $this -> arraycount >= count( $this -> arrayLog ) - 1 ) ? $this -> arraycount = 0 : $this -> arraycount++ ;
		return $this ;
	}

	public function repeatSnake( int $length = 0 ) : string {
		$repeat = $this -> repeat( $this -> arrayLog[ $this -> arraycount ] , $length ) ;
		$this -> autoIncrementArrayLogCounter( );
		return $repeat ;
	}

	public function arrow_snake( String $type , Int $length = 1 , string $dir = 'right' ) : string {
		switch( $dir ) {
			case 'right'  : $word =       $this -> repeatSnake( $length - 5 ) . '>' ; break ;
			case 'left'   : $word = '<' . $this -> repeatSnake( $length - 5 )       ; break ;
			case 'center' : $word = '<' . $this -> repeatSnake( $length - 6 ) . '>' ; break ;
		}
		return $this -> arrow( $word , '0;0;0' , $type , $dir );
	}

	public function line_arrow_snake( string $word , string $type = 'default_color' ) : printer {
		$name = $this -> $type( $word ) ;
		$length = floor( $this -> Fullcols - $this -> length( $name ) ) / 2 ;
		return $this -> line(
			$this -> arrow_snake( $this -> $type , floor( $length ) , 'left' ) .
			$name .
			$this -> arrow_snake( $this -> $type , ceil( $length ) )
		);
	}


}