<?php

namespace harby\services\Services;

use Str;

use Symfony\Component\Process\Process as cmd;
use Illuminate\Http\UploadedFile;

use harby\services\Consts\regularExpression;

class Process extends cmd{

    public static function runProcess( array $arrayOfCommand ) : Process {
        $process = new static( $arrayOfCommand ) ;
        $process -> setTimeout( 3600 );
        $process -> run( );
		return $process ;
    }

	public static function get_average_colours( UploadedFile $file ) : array {
		$process = static::fromShellCommandline( 'convert "$Filename" pnm:- | pnmquant 6 | convert - -unique-colors -depth 8 txt:' ) ;
		$process -> run( null , [ 'Filename' => $file -> getPathname( ) ] );
		return Str::of( $process -> getOutPut( ) ) -> matchAll ( regularExpression::DETECTHEXADECIMALCOLOR ) -> toArray( ) ;
	}

}