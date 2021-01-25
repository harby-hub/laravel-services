<?php

namespace harby\services\tests\Traits;

trait bar {

	/**
		─ ═ ║ │
	*/

	/** 
		╔══╦══╗ 
		╠══╬══╣ 
		╚══╩══╝  
	*/
	protected string $LeftfirstBar  = '╔' ;
	protected string $RightfirstBar = '╗' ;

	protected string $LeftRowBar    = '╠' ;
	protected string $RightRowBar   = '╣' ;

	protected string $spaceRowBar   = '═' ;
	protected string $spaceColBar   = '║' ;

	protected string $spacePluseBar = '╬' ;

	protected string $spaceDownBar  = '╦' ;
	protected string $spaceUpBar    = '╩' ;

	protected string $LeftlastBar   = '╚' ;
	protected string $RightlastBar  = '╝' ;

	/** 
		╓──╥──╖ 
		╟──╫──╢ 
		╙──╨──╜
		protected string $LeftfirstBar  = '╓' ;
		protected string $RightfirstBar = '╖' ;

		protected string $LeftRowBar  = '╟' ;
		protected string $RightRowBar = '╢' ;

		protected string $spaceRowBar   = '─' ;
		protected string $spaceColBar   = '║' ;
		protected string $spacePluseBar = '╫' ;
		protected string $spaceDownBar  = '╥' ;
		protected string $spaceUpBar = '╨' ;

		protected string $LeftlastBar  = '╙' ;
		protected string $RightlastBar = '╜' ;
	*/

	/** 
		╒══╤══╕
		╞══╪══╡
		╘══╧══╛
		protected string $LeftfirstBar  = '╒' ;
		protected string $RightfirstBar = '╕' ;
		protected string $LeftRowBar    = '╞' ;
		protected string $RightRowBar   = '╡' ;
		protected string $spaceRowBar   = '═' ;
		protected string $spaceColBar   = '│' ;
		protected string $spacePluseBar = '╪' ;
		protected string $spaceDownBar  = '╤' ;
		protected string $spaceUpBar    = '╧' ;
		protected string $LeftlastBar   = '╘' ;
		protected string $RightlastBar  = '╛' ;
	*/

	public function printBarfirst( ) : printer {
		return $this -> printBar( $this -> LeftfirstBar , $this -> spaceRowBar , $this -> RightfirstBar ) ;
	}

	public function printBarRow( ) : printer {
		return $this -> printBar( $this -> LeftRowBar , $this -> spaceRowBar , $this -> RightRowBar ) ;
	}

	public function printBarlast( ) : printer {
		return $this -> printBar( $this -> LeftlastBar , $this -> spaceRowBar , $this -> RightlastBar ) ;
	}

	public function printBar( string $first , string $repeat , string $last ) : printer {
		return $this -> printLine( $first , $this -> repeat( $repeat , $this -> Fullcols ) , $last );
	}

	public function printAfterLogBar( ) : printer {
		return $this -> printBarMake( [
			'unicode' => $this -> spaceUpBar ,
			'length'  => $len = $this -> logSpaceStatus
		], [
			'unicode' => $this -> spaceUpBar ,
			'length'  => $len += $this -> logSpace 
		], [
			'unicode' => $this -> spaceUpBar ,
			'length'  => $len += $this -> logSpace
		], [
			'unicode' => $this -> spaceUpBar ,
			'length'  => $len += $this -> logSpaceStatus
		]);
	}

	public function printBeforeLogBar( ) : printer {
		return $this -> printBarMake( [
			'unicode' => $this -> spaceDownBar ,
			'length'  => $len = $this -> logSpaceStatus
		], [
			'unicode' => $this -> spaceDownBar ,
			'length'  => $len += $this -> logSpace 
		], [
			'unicode' => $this -> spaceDownBar ,
			'length'  => $len += $this -> logSpace
		], [
			'unicode' => $this -> spaceDownBar ,
			'length'  => $len += $this -> logSpaceStatus
		]);
	}

	public function printInLogBar( ) : printer {
		return $this -> printBarMake( [
			'unicode' => $this -> spacePluseBar ,
			'length'  => $len = $this -> logSpaceStatus
		] , [
			'unicode' => $this -> spacePluseBar ,
			'length'  => $len += $this -> logSpace 
		] , [
			'unicode' => $this -> spacePluseBar ,
			'length'  => $len += $this -> logSpace
		] , [
			'unicode' => $this -> spacePluseBar ,
			'length'  => $len += $this -> logSpaceStatus
		]);
	}

	public function printBarMake( array ...$array ) : printer {
		$bar = $this -> LeftRowBar . $this -> repeat( $this -> spaceRowBar , $this -> Fullcols ) . $this -> RightRowBar ;
		foreach( $array as $key => [ 'unicode' => $unicode , 'length' => $length ] ) $bar = $this -> mb_substr_replace( $bar , $unicode , $length , $length - $this -> length( $unicode ) + 1 ) ;
		return $this -> print( $this -> default_color( $bar ) ) ;
	}

}