<?php

namespace Lefamed\LaravelBillwerk\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Lefamed\LaravelBillwerk\Models\BillwerkCustomer;
use Lefamed\LaravelBillwerk\Transformers\Model\CustomerTransformer;

/**
 * Class SyncBillwerkCustomer
 * @package Lefamed\LaravelBillwerk\Jobs
 */
class SyncBillwerkCustomer implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	/**
	 * @var BillwerkCustomer
	 */
	private $customer;

	/**
	 * Create a new job instance.
	 * @param BillwerkCustomer $customer
	 */
	public function __construct(BillwerkCustomer $customer)
	{
		$this->customer = $customer;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$customerClient = new \Lefamed\LaravelBillwerk\Billwerk\Customer();
		$customerClient->put(
			$this->customer->billwerk_id,
            (new CustomerTransformer())->transform($this->customer)
		);
	}
}
