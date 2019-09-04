<?php

return [

	'namespaces' => [
		'Controllers'	=> 'App\\Http\\Controllers'	,
		'Middleware'	=> 'App\\Http\\Middleware'	,
		'Models'		=> 'App\\Models'			,
		'Requests'		=> 'App\\Requests'			,
		'Services'		=> 'App\\Services'			,
		'queries'		=> 'App\\GraphQL\\Queries'	,
		'mutations'		=> 'App\\GraphQL\\Mutations',
	],

	'graphql' => [
		'Path'		=> base_path( 'graphql/schema.graphql' ),
		'exists'	=> true,
		'edit'		=> true,
	]

	'web' => [
		'Path' => base_path( 'routes/web.php' ),
		'edit' => true,
	]

	'api' => [
		'Path' => base_path( 'routes/api.php' ),
		'edit' => true,
	]

];
