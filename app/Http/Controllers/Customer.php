<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CustomerService;

class Customer extends Controller
{
    private $customerService;

    public function __construct()
    {
        $this->customerService = new CustomerService();
    }

    /**
     * @SWG\Get(
     *     path="/clients",
     *     @SWG\Response(response="200", description="An example resource")
     * )
     */
    public function customers()
    {
        return response()->json($this->customerService->getClients());
    }
}
