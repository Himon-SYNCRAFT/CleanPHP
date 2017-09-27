<?php

return [
	'mappings' => [
		'type' => 'yaml',
		'paths' => [__DIR__ . '/../core/Persistence/Doctrine/Mapping']
	],
	'orm' => [
		'auto_generate_proxy_classes' => true,
	],
];
