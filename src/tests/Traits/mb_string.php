<?php

namespace harby\services\tests\Traits;

class mb_string {

	protected string $Escape            = "\e["           ;
	protected string $MakeNewLine       = "\n"            ;
	protected string $removeLine        = "\r"            ;
	protected string $EndLine           = "\e[0m"         ;
	protected string $MovesCursorToHome = "\e[1J"         ;
	protected string $EraseScreen       = "\e[0;0H"       ;
	protected string $asc               = '      ' ;

	public function repeat( string $string ,  int $length = 0 ) : string {
		return str_repeat( $string , $length > 0 ? $length : 0 ) ;
	}

	public function filter_ansi_string( string $word ) : string {
		return preg_replace( '#\\x1b[[][^A-Za-z]*[A-Za-z]#' , '' , $word ) ;
	}

	public function length( string $word ) : int {
		return mb_strlen( $this -> filter_ansi_string ( $word ) ) ;
	}

	public function convert_html_to_ansi( string $line ) : string {
		return strtr( $line , [
			'<b>'  => $this -> Escape . "1m"  ,
			'<B>'  => $this -> Escape . "1m"  ,
			'</b>' => $this -> Escape . "21m" ,
			'</B>' => $this -> Escape . "21m" ,
		] );
	}

	public function str_pad( string $str , int $pad_len , string $pad_str = ' ' , int $dir = STR_PAD_RIGHT ) : string {
		$str_len     = $this -> length( $str     ) ;
		$pad_str_len = $this -> length( $pad_str ) ;
		if ( ! $str_len && ( $dir == STR_PAD_RIGHT || $dir == STR_PAD_LEFT ) ) $str_len = 1; // @debug 
		if ( ! $pad_len || ! $pad_str_len || $pad_len <= $str_len ) return $str; 
		$str_repeat = $this -> repeat( $pad_str , ceil( - $str_len + $pad_len ) ) ;
		switch( $dir ){
			case STR_PAD_RIGHT ; return $this -> mb_substr( $str . $str_repeat , 0 , $pad_len ) ; break ;
			case STR_PAD_LEFT  ; return $this -> mb_substr( $str_repeat . $str , -   $pad_len ) ; break ;
			case STR_PAD_BOTH ;
				$length = ( $pad_len - $str_len ) / 2;
				$repeat = ceil( $length / $pad_str_len );
				return
					$this -> mb_substr( $str_repeat , 0 , floor( $length ) ) .
					$str .
					$this -> mb_substr( $str_repeat , 0 , ceil ( $length ) )
				;
			break ;
		}
	}

	public function mb_substr_replace( string $output , string $replace , int $posOpen , int $posClose ) : string {
        return $this -> mb_substr( $output , 0 , $posOpen ) . $replace . $this -> mb_substr( $output , $posClose + 1 );
    }

	public function mb_substr( string $string , int $start , int $length = null , string $encoding = null ) : string {
        if( preg_match( "/(\\e([^.]+)m)([^<]+)(\\e\[0m)/s" , $string ) ) return preg_replace_callback(
			"/(\\e([^.]+)m)([^<]+)(\\e\[0m)/s", 
			function( $matches ) use ( &$string , &$start , &$length ){
				/*
				 * Indexes of array:
				 *    0 - full tag
				 *    1 - open tag, for example <h1>
				 *    2 - tag name h1
				 *    3 - content
				 *    4 - closing tag
				 */
				// print_r($matches);
				return $matches[ 1 ].mb_substr( $matches[ 3 ] , $start , $length ).$matches[ 4 ] ;
				dd(
					$string                                       ,
					$matches                                      ,
					$matches[ 3 ]                                 ,
					$matches[ 1 ] . $matches[ 3 ] . $matches[ 4 ] ,
					$start                                        ,
					$length                                       ,
				);
			}, 
			$string
		);
		else return mb_substr( $string , $start , $length ) ;
    }

}