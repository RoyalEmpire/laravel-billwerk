<?php

namespace Lefamed\LaravelBillwerk\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

/**
 * Class RecurringBillingApproaching
 * @package Lefamed\LaravelBillwerk\Events
 */
class RecurringBillingApproaching
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public $contract;

	/**
	 * Create a new event instance.
	 *
	 * @param $contract
	 */
	public function __construct($contract)
	{
		$this->contract = $contract;
	}
}
