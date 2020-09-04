<?php
return [
	'settings' => [
		'displayErrorDetails' => true, // set to false in production
		'addContentLengthHeader' => false, // Allow the web server to send the content-length header
		'determineRouteBeforeAppMiddleware' => false,

		// UploadDir
		'fileupload' => [
			'upload_directory' => __DIR__ . '/uploads/',
		],

		// Routines Dir
		'routinesDir' => [
			'dirRoutinesScript' => __DIR__ . '/routines',
		],

		  // Slim Settings
		  
		  'db' => [
			  'driver' => 'mysql',
			  'host' => '172.17.0.2',
			  'database' => 'teste',
			  'username' => 'root',
			  'password' => '123',
			  'charset'   => 'utf8',
			  'collation' => 'utf8_unicode_ci',
			  'prefix'    => '',
		  ]
	],
];
