<?php
return [
	'settings' => [
		'displayErrorDetails' => true, // set to false in production
		'addContentLengthHeader' => false, // Allow the web server to send the content-length header

		// UploadDir
		'fileupload' => [
			'upload_directory' => __DIR__ . '/uploads/',
		],

		// Routines Dir
		'routinesDir' => [
			'dirRoutinesScript' => __DIR__ . '/routines',
		],
	],
];
