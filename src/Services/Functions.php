<?php

namespace harby\services\Services;

use Illuminate\Http\UploadedFile;

class Functions{

	public static function rand( int $length = 5 ) : int {
		return rand( pow( 10 , $length - 1 ) , pow( 10 , $length ) - 1 ) ;
	}

	public static function hashThing( $thing ) : String {
		return base64_encode( json_encode( $thing ) )  ;
	}

	public static function unhashThing( String $Hash ) {
		return json_decode( base64_decode( $Hash ) , true )  ;
	}

	public static function command_exists( string $command ) : bool {
		return Process::runProcess( [ PHP_OS == 'WINNT' ? 'where' : 'which' , $command ] ) -> getOutPut( ) ;
	}

	public static function CreateTempFileFromString( String $content , String $FileName = '' , String $tempPrefix = 'php' , String $extension = '' ) : UploadedFile {
		$path = tempnam( sys_get_temp_dir( ) , $tempPrefix );
		rename( $path , $path = $path . $extension );
		$temp = fopen( $path , "r+b" );
		fwrite( $temp , $content );
		register_shutdown_function( fn( ) => unlink( $path ) );
		return ( new UploadedFile ( $path , $FileName , mime_content_type( $path ) , null , true ) );
	}

    public static function getFilesFromArchiveFile( UploadedFile $file , Int $fromSeconds = 1 ) : array {
		$process = Process::runProcess( [ 'bsdtar' , '-tvf' , $file -> path( ) ] ) ;
        return ! $process -> isSuccessful( ) ? [ ] : \Str::of( $process -> getOutPut( ) )
            -> explode ( "\n" )
            -> filter  (      )
            -> values  (      )
            -> map( fn( string $item ) : array => [
				'fileName' => ( $item = preg_split( "/\s{1,}/" , $item ) ) [ 8 ] ,
				'size'     => $item [ 4 ] ,
			] )
            -> toArray( )
        ;

    }
}
