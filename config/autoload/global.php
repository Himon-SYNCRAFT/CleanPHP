<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */


use CleanPhp\Invoicer\Persistence\Hydrator\OrderHydrator;
use Zend\Stdlib\Hydrator\ClassMethods;


return [
	'service_manager' => [
		'factories' => [
			'OrderHydrator' => function($sm) {
				return new OrderHydrator(
					new ClassMethods(),
					$sm->get('CustomerRepository')
				);
			},
			'CustomerRepository' => 'CleanPhp\Invoicer\Persistence\Doctrine\Repository\RepositoryFactory',
			'InvoiceRepository' => 'CleanPhp\Invoicer\Persistence\Doctrine\Repository\RepositoryFactory',
			'OrderRepository' => 'CleanPhp\Invoicer\Persistence\Doctrine\Repository\RepositoryFactory',
		]
	],
];
