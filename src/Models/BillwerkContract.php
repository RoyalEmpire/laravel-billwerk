<?php

namespace Lefamed\LaravelBillwerk\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Contract
 * @package Lefamed\LaravelBillwerk\Models
 */
class BillwerkContract extends Model
{
	public $incrementing = false;

	protected $fillable = [
		'id',
		'customer_id',
		'plan_id',
		'plan_variant_id',
		'end_date',
		'reference_code'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function customer()
	{
		return $this->belongsTo(BillwerkCustomer::class);
	}
}
