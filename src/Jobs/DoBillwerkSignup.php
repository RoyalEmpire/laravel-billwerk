<?php

namespace Lefamed\LaravelBillwerk\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Lefamed\LaravelBillwerk\Models\BillwerkCustomer;

/**
 * Class Signup
 * @package Lefamed\LaravelBillwerk\Jobs
 */
class DoBillwerkSignup implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected $model;

	/**
	 * Create a new job instance.
	 * @param Model $model
	 */
	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		BillwerkCustomer::create($this->model->getCustomerTransformation());
	}
}
