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


use CleanPhp\Invoicer\Domain\Entity\Customer;
use CleanPhp\Invoicer\Persistence\Zend\DataTable\CustomerTable;
use CleanPhp\Invoicer\Persistence\Zend\TableGateway\TableGatewayFactory;
use Zend\Stdlib\Hydrator\ClassMethods;


return [
	'service_manager' => [
		'factories' => [
			'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
			'CustomerTable' => function($sm) {
				$factory = new TableGatewayFactory();
				$hydrator = new ClassMethods();

				return new CustomerTable(
					$factory->createGateway(
						$sm->get('Zend\Db\Adapter\Adapter'),
						$hydrator,
						new Customer(),
						'customers'
					),
					$hydrator
				);
			},
			'InvoiceTable' => function($sm) {
				$factory = new TableGatewayFactory();
				$hydrator = new ClassMethods();

				return new InvoiceTable(
					$factory->createGateway(
						$sm->get('Zend\Db\Adapter\Adapter'),
						$hydrator,
						new Invoice(),
						'invoices'
					),
					$hydrator
				);
			},
			'OrderTable' => function($sm) {
				$factory = new TableGatewayFactory();
				$hydrator = new ClassMethods();

				return new OrderTable(
					$factory->createGateway(
						$sm->get('Zend\Db\Adapter\Adapter'),
						$hydrator,
						new Order(),
						'ordrers'
					),
					$hydrator
				);
			},
		]
	]
];
