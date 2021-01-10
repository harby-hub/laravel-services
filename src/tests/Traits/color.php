<?php

namespace harby\services\tests\Traits;

trait color {

    protected string $textColor     = '242;242;242' ;
    protected string $positive      = '80;191;97'   ;
    protected string $accent        = '71;83;62'    ;
    protected string $danger        = '219;34;49'   ;
    protected string $success       = '80;191;97'   ;
    protected string $warning       = '191;91;4'    ;
    protected string $primary       = '248;196;41'  ;
    protected string $secondary     = '43;165;201'  ;
    protected string $info          = '4;175;197'   ;
    protected string $dark          = '31;35;38'    ;
    protected string $gold          = '248;196;41'  ;
    protected string $default_color = '248;196;41'  ;

	public function danger( string $word ) : string {
		return $this -> wordColor( $word , $this -> danger ) ;
	}

	public function success( string $word ) : string {
		return $this -> wordColor( $word , $this -> success ) ;
	}

	public function warning( string $word ) : string {
		return $this -> wordColor( $word , $this -> warning ) ;
	}

	public function primary( string $word ) : string {
		return $this -> wordColor( $word , $this -> primary ) ;
	}

	public function default_color( string $word ) : string {
		return $this -> wordColor( $word , $this -> default_color ) ;
	}

	public function secondary( string $word ) : string {
		return $this -> wordColor( $word , $this -> secondary ) ;
	}

	public function info( string $word ) : string {
		return $this -> wordColor( $word , $this -> info ) ;
	}

	public function accent( string $word ) : string {
		return $this -> wordColor( $word , $this -> accent ) ;
	}

	public function positive( string $word ) : string {
		return $this -> wordColor( $word , $this -> positive ) ;
	}

	public function makeBackgroundColor( String $backgroundColor = null) : string  {
		return $backgroundColor ? "48;2;$backgroundColor;" : "49;" ;
	}

	public function makeForegroundColor( String $foregroundColor = null ) : string  {
		return $foregroundColor ?  "38;2;$foregroundColor;" : "38;5;0;" ;
	}

	public function makeEscapeColor( String $foregroundColor = null , String $backgroundColor = null ) : string  {
		return $this -> Escape . $this -> makeForegroundColor( $foregroundColor ) . $this -> makeBackgroundColor( $backgroundColor ) . "65m";
	}

	public function wordColor( String $word , String $foregroundColor = null , String $backgroundColor = null ) : string {
		return $this -> makeEscapeColor( $foregroundColor , $backgroundColor ) . $word . $this -> EndLine ;
	}

}