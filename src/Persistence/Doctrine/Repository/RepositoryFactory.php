<?php

namespace CleanPhp\Invoicer\Persistence\Doctrine\Repository;

use RuntimeException;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class RepositoryFactory implements FactoryInterface {
	public function createService(ServiceLocatorInterface $sl) {
		$class = func_get_arg(2);
		$class = 'CleanPhp\Invoicer\Persistence\Doctrine\Repository\\' . $class;

		if (class_exists($class, true)) {
			return new $class($sl->get('Doctrine\ORM\EntityManager'));
		}

		throw new RuntimeException('Unknown Repository requested: ' . $class);
	}
}
