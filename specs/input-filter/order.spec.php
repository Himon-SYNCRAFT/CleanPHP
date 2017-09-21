<?php

use CleanPhp\Invoicer\Service\InputFilter\OrderInputFilter;


describe('InputFilter\Order', function() {
	beforeEach(function() {
		$this->inputFilter = new OrderInputFilter();
	});

	describe('->isValid()', function() {
		it('should require a customer.id', function() {
			$this->inputFilter->setData([]);
			$isValid = $this->inputFilter->isValid();

			$error = [
				'id' => [
					'isEmpty' => 'Value is required and can\'t be empty'
				]
			];

			$customer = $this->inputFilter->getMessages()['customer'] ?? null;

			expect($isValid)->to->equal(false);
			expect($customer)->to->equal($error);
		});

		it('should require an order number', function() {
			$this->inputFilter->setData([]);
			$isValid = $this->inputFilter->isValid();

			$error = [
				'isEmpty' => 'Value is required and can\'t be empty'
			];

			$orderNo = $this->inputFilter->getMessages()['orderNumber'] ?? null;

			expect($isValid)->to->equal(false);
			expect($customer)->to->equal($error);
		});
	});
});
