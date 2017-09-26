<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */


use CleanPhp\Invoicer\Domain\Factory\InvoiceFactory;
use CleanPhp\Invoicer\Domain\Service\InvoicingService;
use CleanPhp\Invoicer\Service\InputFilter\CustomerInputFilter;
use CleanPhp\Invoicer\Service\InputFilter\OrderInputFilter;
use Zend\Stdlib\Hydrator\ClassMethods;

return array(
	'router' => array(
		'routes' => array(
			'home' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route'    => '/',
					'defaults' => array(
						'controller' => 'Application\Controller\Index',
						'action'     => 'index',
					),
				),
			),
			// The following is a route to simplify getting started creating
			// new controllers and actions without needing to create a new
			// module. Simply drop new controllers in, and you can access them
			// using the path /application/:controller/:action
			'application' => array(
				'type'    => 'Literal',
				'options' => array(
					'route'    => '/application',
					'defaults' => array(
						'__NAMESPACE__' => 'Application\Controller',
						'controller'    => 'Index',
						'action'        => 'index',
					),
				),
				'may_terminate' => true,
				'child_routes' => array(
					'default' => array(
						'type'    => 'Segment',
						'options' => array(
							'route'    => '/[:controller[/:action]]',
							'constraints' => array(
								'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
							),
							'defaults' => array(
							),
						),
					),
				),
			),
			'customers' => [
				'type' => 'Segment',
				'options' => [
					'route' => '/customers',
					'defaults' => [
						'controller' => 'Application\Controller\Customers',
						'action' => 'index'
					],
				],
				'may_terminate' => true,
				'child_routes' => [
					'new' => [
						'type' => 'Segment',
						'options' => [
							'route' => '/new',
							'defaults' => [
								'action' => 'new-or-edit',
							],
						],
					],
					'edit' => [
						'type' => 'Segment',
						'options' => [
							'route' => '/edit/:id',
							'constraints' => ['id' => '[0-9]+'],
							'defaults' => [
								'action' => 'new-or-edit',
							],
						],
					],
				],
			],
			'orders' => [
				'type' => 'Segment',
				'options' => [
					'route' => '/orders[/:action[/:id]]',
					'defaults' => [
						'controller' => 'Application\Controller\Orders',
						'action' => 'index'
					],
				],
			],
			'invoices' => [
				'type' => 'Segment',
				'options' => [
					'route' => '/invoices[/:action[/:id]]',
					'defaults' => [
						'controller' => 'Application\Controller\Invoices',
						'action' => 'index'
					],
				],
			],
		),
	),
	'service_manager' => array(
		'abstract_factories' => array(
			'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
			'Zend\Log\LoggerAbstractServiceFactory',
		),
		'aliases' => array(
			'translator' => 'MvcTranslator',
		),
	),
	'translator' => array(
		'locale' => 'en_US',
		'translation_file_patterns' => array(
			array(
				'type'     => 'gettext',
				'base_dir' => __DIR__ . '/../language',
				'pattern'  => '%s.mo',
			),
		),
	),
	'controllers' => array(
		'invokables' => array(
			'Application\Controller\Index' => 'Application\Controller\IndexController'
		),
		'factories' => [
			'Application\Controller\Customers' => function($sm) {
				return new \Application\Controller\CustomersController(
					$sm->getServiceLocator()->get('CustomerRepository'),
					new CustomerInputFilter(),
					new ClassMethods()
				);
			},
			'Application\Controller\Orders' => function($sm) {
				return new \Application\Controller\OrdersController(
					$sm->getServiceLocator()->get('OrderRepository'),
					$sm->getServiceLocator()->get('CustomerRepository'),
					new OrderInputFilter(),
					$sm->getServiceLocator()->get('OrderHydrator')
				);
			},
			'Application\Controller\Invoices' => function($sm) {
				return new \Application\Controller\InvoicesController(
					$sm->getServiceLocator()->get('InvoiceRepository'),
					$sm->getServiceLocator()->get('OrderRepository'),
					new InvoicingService(
						$sm->getServiceLocator()->get('OrderRepository'),
						new InvoiceFactory()
					)
				);
			},
		],
	),
	'view_manager' => array(
		'display_not_found_reason' => true,
		'display_exceptions'       => true,
		'doctype'                  => 'HTML5',
		'not_found_template'       => 'error/404',
		'exception_template'       => 'error/index',
		'template_map' => array(
			'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
			'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
			'error/404'               => __DIR__ . '/../view/error/404.phtml',
			'error/index'             => __DIR__ . '/../view/error/index.phtml',
		),
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
	),
	// Placeholder for console routes
	'console' => array(
		'router' => array(
			'routes' => array(
			),
		),
	),
	'view_helpers' => [
		'invokables' => [
			'validationErrors' => 'Application\View\Helper\ValidationErrors',
		],
	],
);
