<?php

namespace Lefamed\LaravelBillwerk\Billwerk;

use Exception;

/**
 * Class Customer
 * @package Lefamed\LaravelBillwerk\Billwerk
 */
class Customer extends BaseClient
{
	protected $resource = 'Customers';

    /**
     * @param $customerId
     * @return ApiResponse
     * @throws Exception
     */
    public function getContracts($customerId)
	{
		return $this->get($customerId, 'Contracts');
	}
}
