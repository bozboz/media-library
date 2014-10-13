<?php

return [
	'allowed_media_types' => [
		'image' => 'Image',
		'pdf' => 'PDF'
	],
	'models' => [
		'Bozboz\Admin\Models\Page' => [
			[
				'media_alias' => 'pages'
			]
		]
	]
];
