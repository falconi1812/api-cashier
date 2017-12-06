<?php

namespace App\Services;

use App\Clients;
use App\ClientLocations;
use App\Repositories\ClientsRepository as clientRepository;
use App\Repositories\LocationsRepository as locationRepository;

class ClientService extends Service
{
    private $clientRepository;

    private $locationsRepository;

    public function __construct(clientRepository $clientsRepository, locationRepository $locationsRepository)
    {
        parent::__construct();
        $this->clientRepository = $clientsRepository;
        $this->locationsRepository = $locationsRepository;
    }

    /**
     * @SWG\Definition(
     * 		definition="ClientsPerDay",
     * 		@SWG\Property(property="location", type="array", @SWG\Items(
     *          type="object",
     *          @SWG\Property(property="code_loc", type="string"),
     *          @SWG\Property(property="nom", type="string"),
     *          @SWG\Property(property="prenom", type="string"),
     *          @SWG\Property(property="mail", type="string"),
     *          @SWG\Property(property="tel", type="string"),
     *          @SWG\Property(property="hour_start", type="string"),
     *          @SWG\Property(property="hour_end", type="string"),
     *          @SWG\Property(property="terrain", type="string"),
     *          @SWG\Property(property="nb", type="integer"),
     *          @SWG\Property(property="type_rental", type="string"),
     *      )
     *   ),
     * )
     */
    public function getClients($date)
    {
        $day = is_null($date) ? date('Y-m-d') : $date;
        $uri = str_replace('{YYYY-MM-DD}', $day, env('GET_CLIENTS'));
        $response = $this->client->request('GET', $uri);
        $clients = json_decode($response->getBody());

        if (!is_null($clients)) {
            $this->clientRepository->saveClientsArray($clients->Location);
            $saved = $this->locationsRepository->saveLocationWithClientsArray($clients->Location);
            $clientArray = $this->locationsRepository->saveClientLocationRelationshipWithEmail($saved);

            $clientsId = array_unique(array_pluck($clientArray, 'client_id'));

            return ClientLocations::whereIn('client_id', $clientsId)->with(['client', 'location.type', 'location.terrain'])->get();
        }

        return $clients;
    }

}

?>
