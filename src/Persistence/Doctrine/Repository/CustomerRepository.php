<?php

namespace CleanPhp\Invoicer\Persistence\Doctrine\Repository;

use CleanPhp\Invoicer\Domain\Repository\CustomerRepositoryInterface;


class CustomerRepository extends AbstractDoctrineRepository
	implements CustomerRepositoryInterface {
	protected $entityClass = 'CleanPhp\Invoicer\Domain\Entity\Customer';
}
