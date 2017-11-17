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

    public function customers()
    {
        return response()->json($this->customerService->getClients());
    }
}
