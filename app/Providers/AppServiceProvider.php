<?php

namespace App\Providers;

use CleanPhp\Invoicer\Domain\Repository\CustomerRepositoryInterface;
use CleanPhp\Invoicer\Domain\Repository\OrderRepositoryInterface;
use CleanPhp\Invoicer\Persistence\Doctrine\Repository\CustomerRepository;
use CleanPhp\Invoicer\Persistence\Doctrine\Repository\OrderRepository;
use Illuminate\Support\ServiceProvider;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Stdlib\Hydrator\HydratorInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
		$this->app->bind(
			HydratorInterface::class,
			function($app) {
				return new ClassMethods();
			}
		);

		$this->app->bind(
			CustomerRepositoryInterface::class,
			function($app) {
				return new CustomerRepository(
					$app['Doctrine\ORM\EntityManagerInterface']
				);
			}
		);

		$this->app->bind(
			OrderRepositoryInterface::class,
			function($app) {
				return new OrderRepository(
					$app['Doctrine\ORM\EntityManagerInterface']
				);
			}
		);
    }
}
