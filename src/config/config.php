<?php

return [
	'allowed_media_types' => [
		'image' => 'Image',
		'pdf' => 'PDF'
	],
	'models' => [
		'Bozboz\Admin\Models\Page' => [
			'alias' => 'pages',
			'sizes' => [
				'thumb' => [
					'width' => 1337,
					'height' => 1337
				]
			]
		]
	]
];
