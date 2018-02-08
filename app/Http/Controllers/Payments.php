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

    /**
     * @SWG\Put(
     *     path="/payments/{location_id}/{type_id}",
     *     @SWG\Parameter(name="location_id", in="path", description="location ID", required=true, type="integer"),
     *     @SWG\Parameter(name="type_id", in="path", description="type of payment", required=true, type="integer"),
     *     @SWG\Parameter(
     *        name="body",
     *        in="body",
     *        description="Payment properties",
     *        required=true,
     *        @SWG\Property( type="array", @SWG\Items(
     *              @SWG\Property(property="product_id", type="integer"),
     *              @SWG\Property(property="quantity", type="integer"),
     *          )
     *        ),
     *      ),
     *     @SWG\Response(
     *          response="200",
     *          description="Creates new payment record",
     *          @SWG\Schema(ref="#/definitions/GetAllPayments")),
     *     tags={"Payments"},
     * )
     */
    public function savePayment($locationId, $typeId, Request $request)
    {
        return response()->json($this->paymentService->processSave($locationId, $typeId, $request));
    }

    /**
     * @SWG\Get(
     *     path="/payments/{location_id}",
     *     @SWG\Parameter(name="location_id", in="path", description="location ID", required=true, type="integer"),
     *     @SWG\Response(
     *          response="200",
     *          description="Return all payments as an array",
     *          @SWG\Schema(ref="#/definitions/findBylocation")),
     *     tags={"Payments"},
     * )
     */
   public function findBylocation($locationId)
   {
       return response()->json($this->paymentService->findBylocation($locationId));
   }

}

?>
