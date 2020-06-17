<?php

namespace Lefamed\LaravelBillwerk\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Lefamed\LaravelBillwerk\Models\BillwerkCustomer;

/**
 * Class OrderSucceeded
 *
 * @package Lefamed\LaravelBillwerk\Events
 */
class OrderSucceeded
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	/**
	 * @var \Lefamed\LaravelBillwerk\Models\BillwerkCustomer
	 */
	public $customer;

	public $order;

    /**
     * Create a new event instance.
     * @param BillwerkCustomer $customer
     * @param $order
     */
	public function __construct(BillwerkCustomer $customer, $order)
	{
		$this->customer = $customer;
		$this->order = $order;
	}
}
