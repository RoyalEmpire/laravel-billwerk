<?php

namespace Lefamed\LaravelBillwerk\Http\Controllers\Api;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Lefamed\LaravelBillwerk\Billwerk\Contract;
use Lefamed\LaravelBillwerk\Http\Controllers\Controller;

/**
 * Class ContractController
 * @package Lefamed\LaravelBillwerk\Http\Controllers\Api
 */
class ContractController extends Controller
{
    /**
     * @param $contractId
     * @return JsonResponse
     * @throws Exception
     */
	public function getSelfServiceToken($contractId)
	{
		$cacheKey = 'billwerk_contract_' . $contractId . '_token';

		if (Cache::has($cacheKey)) {
            return response()->json(Cache::get($cacheKey));
		}

        $contractService = new Contract();

        try {
            $tokenData = $contractService->selfServiceToken($contractId)->data();
            $expiry = Carbon::parse($tokenData->Expiry);
            $tokenExpireIn = $expiry->diffInMinutes(Carbon::now()) - 60;
            Cache::put($cacheKey, $tokenData, $tokenExpireIn);
            $res = $tokenData;
        } catch (Exception $e) {
            throw new Exception('Error while fetching token from API');
        }

		return response()->json($res ?? []);
	}
}
