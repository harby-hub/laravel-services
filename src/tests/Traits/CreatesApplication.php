<?php

namespace harby\services\tests\Traits;

use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication {

	protected static $wasSetupCreatesApplication = false ;

	protected function beforeAll( ) : void {
		if ( ! static::$wasSetupCreatesApplication ++ ) {
			$this -> database_startup ( );
			$this -> buildMacros      ( );
			static::$wasSetupCreatesApplication = true ;
		}
	}

    public function createApplication( ) {
        $app = require __DIR__ . '/../../../../../../bootstrap/app.php' ;
        $app -> make( Kernel::class ) -> bootstrap( ) ;
        $this -> beforeAll ( );
        return $app;

    }
}
