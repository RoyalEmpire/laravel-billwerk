<?php

namespace Lefamed\LaravelBillwerk;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Lefamed\LaravelBillwerk\Jobs\DoBillwerkSignup;
use Lefamed\LaravelBillwerk\Models\BillwerkContract;
use Lefamed\LaravelBillwerk\Models\BillwerkCustomer;

/**
 * Trait Billable
 *
 * This trait makes an other object (like User Objekt) billable.
 *
 * @package Lefamed\LaravelBillwerk\Trait
 */
trait BillableTrait
{
	/**
	 *
	 */
	public static function bootBillableTrait()
	{
		static::created(function (Model $model) {
		    if (config('laravel-billwerk.sync')) {
                        dispatch(new DoBillwerkSignup($model));
                    }
		});
	}

	/**
	 * @return BillwerkCustomer
	 */
	public function getCustomer(): BillwerkCustomer
	{
		return $this->customer;
	}

	/**
	 * @return mixed
	 */
	public function customer()
	{
		return $this->hasOne(BillwerkCustomer::class, 'billable_id');
	}

	public function hasContract($planIds): bool
	{
		if (!is_array($planIds) && !$planIds instanceof Collection) {
			$planIds = [$planIds];
		}

		return $this->customer->contracts()->whereIn('plan_id', $planIds)->count() > 0;
	}

	/**
	 * @return array
	 */
	abstract public function getCustomerTransformation(): array;
}
