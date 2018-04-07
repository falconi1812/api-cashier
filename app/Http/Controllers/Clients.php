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

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
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
     *
     * @SWG\Get(
     *     path="/clients/{date}",
     *     @SWG\Parameter(name="date", in="path", description="date format like this YYYY-MM-DD (2017-10-21)", required=true, type="string"),
     *     @SWG\Response(
     *          response="200",
     *          description="Should return all clients for that day",
     *          @SWG\Schema(ref="#/definitions/ClientsPerDay")),
     *     tags={"Clients"},
     * )
     */
    public function getAllForToday($date = null)
    {
        return response()->json($this->clientService->getClients($date));
    }

}

?>
