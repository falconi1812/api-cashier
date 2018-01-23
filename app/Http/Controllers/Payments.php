<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaymentService;

/**
 * @SWG\Tag(
 *   name="Payments",
 *   description="Everything related with payments in a location."
 * )
 */
class PaymentsController extends Controller
{
    private $paymentService;

    public function __construct(PaymentService $PaymentService)
    {
        $this->paymentService = $PaymentService;
    }

     /**
      * @SWG\Get(
      *     path="/payments",
      *     @SWG\Response(
      *          response="200",
      *          description="Return all payments as an array",
      *          @SWG\Schema(ref="#/definitions/GetAllPayments")),
      *     tags={"Payments"},
      * )
      */
    public function readAll()
    {
        return response()->json($this->paymentService->getAll());
    }


    public function savePayment($locationId, Request $request)
    {
        $products = $request->all();
        return response()->json($this->paymentService->processSave($locationId, $products));
    }

}

?>
