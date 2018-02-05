<?php

namespace Lefamed\LaravelBillwerk\Jobs\Webhooks;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Lefamed\LaravelBillwerk\Billwerk\Contract;
use Lefamed\LaravelBillwerk\Models\Customer;

class ContractCreated implements ShouldQueue
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
            //fetch the recently created contract
            $res = $contractClient->get($this->contractId)->data();

            //check if contract already exists
            if (\Lefamed\LaravelBillwerk\Models\Contract::find($res->Id)) {
                return;
            }

            //find corresponding customer
            $customer = Customer::where('billwerk_id', $res->CustomerId)->first();
            if (!$customer) {
                Log::info('Customer ' . $res->CustomerId . ' for contract ' . $res->Id . ' not found. Cannot apply contract.');

                return;
            }

            //customer found, continue
            \Lefamed\LaravelBillwerk\Models\Contract::create([
                'id'             => $res->Id,
                'plan_id'        => $res->PlanId,
                'customer_id'    => $customer->id,
                'end_date'       => isset($res->EndDate) ? Carbon::parse($res->EndDate) : null,
                'reference_code' => $res->ReferenceCode,
            ]);
        } catch (\Exception $e) {
            Bugsnag::notifyException($e);
            Log::error($e->getMessage());
        }
    }
}
