<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CustomerService;

/**
 * @SWG\Tag(
 *   name="Customers",
 *   description="Everything about your daily customers"
 * )
 */
class Customer extends Controller
{
    private $customerService;

    public function __construct()
    {
        $this->customerService = new CustomerService();
    }

    /**
     * @SWG\Get(
     *     path="/customers",
     *     @SWG\Response(response="200", description="Should return all clients for today", @SWG\Schema(ref="#/definitions/ClientsPerDay")),
     *     tags={"Customers"},
     * )
     */
    public function customers()
    {
        return response()->json($this->customerService->getClients());
    }
}
