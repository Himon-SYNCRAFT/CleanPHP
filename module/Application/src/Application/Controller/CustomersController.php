<?php

namespace Application\Controller;

use CleanPhp\Invoicer\Domain\Entity\Customer;
use CleanPhp\Invoicer\Domain\Repository\CustomerRepositoryInterface;
use CleanPhp\Invoicer\Service\InputFilter\CustomerInputfilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\View\Model\ViewModel;


class CustomersController extends AbstractActionController {
	protected $customerRepository;
	protected $inputFilter;

	public function __construct(
		CustomerRepositoryInterface $customers,
		CustomerInputFilter $inputFilter,
		HydratorInterface $hydrator
	) {
		$this->customerRepository = $customers;
		$this->inputFilter = $inputFilter;
		$this->hydrator = $hydrator;
	}

	public function indexAction() {
		return [
			'customers' => $this->customerRepository->getAll(),
		];
	}

	public function newOrEditAction() {
		$viewModel = new ViewModel();
		$id = $this->params()->fromRoute('id');
		$customer = $id ? $this->customerRepository->getById($id) : new Customer();

		if ($this->getRequest()->isPost()) {
			$this->inputFilter->setData($this->params()->fromPost());

			if ($this->inputFilter->isValid()) {
				$customer = $this->hydrator->hydrate(
					$this->inputFilter->getValues(),
					$customer
				);

				$this->customerRepository
					->begin()
					->persist($customer)
					->commit();

				$this->flashMessenger()->addSuccessMessage('Customer Saved');
				$this->redirect()->toUrl('/customers/edit/' . $customer->getId());
			} else {
				$this->hydrator->hydrate(
					$this->params()->fromPost(),
					$customer
				);

				$viewModel->setVariable('errors', $this->inputFilter->getMessages());
			}
		}

		$viewModel->setVariable('customer', $customer);
		return $viewModel;
	}
}
