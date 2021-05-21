<?php

namespace harby\services\Services;

use Str;

use Symfony\Component\Process\Process as cmd;
use Illuminate\Http\UploadedFile;

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
		return Str::of( $process -> getOutPut( ) ) -> matchAll ( '/#(?:[a-f0-9]{3}|[a-f0-9]{6})\b/im' ) -> toArray( ) ;
	}

}