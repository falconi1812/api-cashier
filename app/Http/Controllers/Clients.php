<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ClientService;

/**
 * @SWG\Tag(
 *   name="Clients",
 *   description="Everything about your daily clients"
 * )
 */
class ClientsController extends Controller
{
    private $clientService;

    public function __construct()
    {
        $this->clientService = new ClientService();
    }

    /**
     * @SWG\Get(
     *     path="/clients",
     *     @SWG\Response(
     *          response="200",
     *          description="Should return all clients for today",
     *          @SWG\Schema(ref="#/definitions/ClientsPerDay")),
     *     tags={"Clients"},
     * )
     */
    public function getAllForToday()
    {
        return response()->json($this->clientService->getClients());
    }
}
