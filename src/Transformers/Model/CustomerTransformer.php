<?php

namespace Lefamed\LaravelBillwerk\Transformers\Model;

use Lefamed\LaravelBillwerk\Models\BillwerkCustomer;

/**
 * Class CustomerTransformer
 *
 * @package Lefamed\LaravelBillwerk\Transformers\Billwerk
 */
class CustomerTransformer
{
	/**
	 * @param BillwerkCustomer $customer
	 * @return array
	 */
	public function transform(BillwerkCustomer $customer)
	{
		return [
			'CompanyName' => $customer->company_name,
			'EmailAddress' => $customer->email_address,
			'FirstName' => $customer->first_name,
			'LastName' => $customer->last_name,
			'Address' => [
				'Street' => $customer->street,
				'HouseNumber' => $customer->house_number,
				'PostalCode' => $customer->postal_code,
				'City' => $customer->city,
				'Country' => $customer->country ?: 'DE'
			],
			'VatId' => $customer->vat_id
		];
	}
}
