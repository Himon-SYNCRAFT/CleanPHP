<?php

namespace CleanPhp\Invoicer\Persistence\Doctrine\Repository;

use CleanPhp\Invoicer\Domain\Repository\InvoiceRepositoryInterface;


class InvoiceRepository extends AbstractDoctrineRepository
	implements InvoiceRepositoryInterface {

	protected $entityClass = 'CleanPhp\Invoicer\Domain\Entity\Invoice';
}
