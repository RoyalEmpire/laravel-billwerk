<?php

namespace Lefamed\LaravelBillwerk\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Lefamed\LaravelBillwerk\Billwerk\Order;
use Lefamed\LaravelBillwerk\Http\Controllers\Controller;

/**
 * Class OrderController
 * @package Lefamed\LaravelBillwerk\Http\Controllers\Api
 */
class OrderController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
	public function preview(Request $request)
	{
		abort_if(!$request->isJson(), Response::HTTP_NOT_ACCEPTABLE);

		$payload = json_decode($request->getContent());
		abort_if(!$request->planVariantId, Response::HTTP_BAD_REQUEST);

		$planVariantId = $payload->planVariantId;
		$couponCode = $payload->couponCode ?? null;

		$orderClient = new Order();
		$res = $orderClient->preview($request->user()->merchant->getCustomer()->billwerk_id, $planVariantId, $couponCode);

		return response()->json($res->data()->Order);
	}

    /**
     * Place order in REST Api
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
	public function order(Request $request)
	{
		//only allow json requests
		abort_if(!$request->isJson(), 406);

		//find out the plan variant id
		$payload = json_decode($request->getContent());
		abort_if(!$request->planVariantId, 400);

		$planVariantId = $payload->planVariantId;

		$orderClient = new Order();
		$res = $orderClient->orderForExistingCustomer($request->user()->merchant->getCustomer()->billwerk_id, $planVariantId);

		return response()->json($res->data());
	}
}
