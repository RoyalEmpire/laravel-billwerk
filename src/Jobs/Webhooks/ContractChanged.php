<?php

namespace Lefamed\LaravelBillwerk\Jobs\Webhooks;

use Exception;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Lefamed\LaravelBillwerk\Billwerk\Contract;
use Lefamed\LaravelBillwerk\Events\UpOrDowngrade;
use Lefamed\LaravelBillwerk\Models\BillwerkContract;
use Lefamed\LaravelBillwerk\Models\BillwerkCustomer;

class ContractChanged implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	private $contractId;

	/**
	 * Create a new job instance.
	 *
	 * @param string $contractId
	 */
	public function __construct(string $contractId)
	{
		$this->contractId = $contractId;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$contractClient = new Contract();

		try {
			$res = $contractClient->get($this->contractId)->data();
            $contract = BillwerkContract::findOrFail($res->Id);
            BillwerkCustomer::where('billwerk_id', $res->CustomerId)->firstOrFail();

            if (isset($res->EndDate) && Carbon::parse($res->EndDate)->isPast()) {
				// contract has ended, remove it
				$contract->delete();
				return;
			}

            if ($contract->plan_id !== $res->PlanId) {
                $contract->plan_id = $res->PlanId;
                $contract->save();

                event(new UpOrDowngrade($contract));
            }
		} catch (Exception $e) {
			Log::error($e->getMessage());
		}
	}
}
