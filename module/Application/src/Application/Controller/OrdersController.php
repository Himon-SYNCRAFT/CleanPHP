<?php

namespace Application\Controller;

use CleanPhp\Invoicer\Domain\Entity\Order;
use CleanPhp\Invoicer\Domain\Repository\CustomerRepositoryInterface;
use CleanPhp\Invoicer\Domain\Repository\OrderRepositoryInterface;
use CleanPhp\Invoicer\Persistence\Hydrator\OrderHydrator;
use CleanPhp\Invoicer\Service\InputFilter\OrderInputFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class OrdersController extends AbstractActionController {
	protected $orderRepository;
	protected $customerRepository;
	protected $inputFilter;
	protected $hydrator;

	public function __construct(
		OrderRepositoryInterface $orderRepository,
		CustomerRepositoryInterface $customerRepository,
		OrderInputFilter $inputFilter,
		OrderHydrator $hydrator
	) {
		$this->orderRepository = $orderRepository;
		$this->customerRepository = $customerRepository;
		$this->inputFilter = $inputFilter;
		$this->hydrator = $hydrator;
	}

	public function viewAction() {
		$id = $this->params()->fromRoute('id');
		$order = $this->orderRepository->getById($id);

		if (!$order) {
			$this->getResponse()->setStatusCode(404);
			return null;
		}

		return [
			'order' => $order,
		];
	}

	public function indexAction() {
		$orders = $this->orderRepository->getAll();
		return [
			'orders' => $orders
		];
	}

	public function newAction() {
		$viewModel = new ViewModel();
		$order = new Order();

		if ($this->getRequest()->isPost()) {
			$this->inputFilter
				->setData($this->params()->fromPost());

			if ($this->inputFilter->isValid()) {
				$this->hydrator->hydrate(
					$this->inputFilter->getValues(),
					$order
				);

				print_r($order);

				$this->orderRepository
					->begin()
					->persist($order)
					->commit();

				$this->flashMessenger()->addSuccessMessage('Order Created');
				$this->redirect()->toUrl('/order/view/' . $order->getId());
			} else {
				$this->hydrator->hydrate(
					$this->params()->fromPost(),
					$order
				);

				$viewModel->setVariable('errors', $this->inputFilter->getMessages());
			}
		}

		$viewModel->setVariable('customers', $this->customerRepository->getAll());
		$viewModel->setVariable('order', $order);

		return $viewModel;
	}
}
