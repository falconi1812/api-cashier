<?php

namespace App\Repositories;

use App\ClientLocations;
use App\Clients;

/**
 * Class ClientsRepository
 * @package App\Repositories
 */
class ClientsRepository extends Repository {

    /**
     * @var ClientLocations
     */
    private $clientLocations;

    /**
     * @var Clients
     */
    private $clients;

    /**
     * ClientsRepository constructor.
     * @param ClientLocations $clientLocations
     * @param Clients $clients
     */
    public function __construct(ClientLocations $clientLocations, Clients $clients)
    {
        $this->clientLocations = $clientLocations;
        $this->clients = $clients;
    }

    /**
     * @param array $clients
     * @return array
     */
    public function saveClientsArray(array $clients) : array
    {
        $result = [];

        foreach ($clients as $client) {

            $clientExist =  Clients::where('email', $client->mail)->first();

            if (!empty($clientExist)) {
                array_push($result, $clientExist);
            } else {
                $currentClient = Clients::create([
                    'name' => $client->nom,
                    'last_name' => $client->prenom,
                    'email' => $client->mail,
                    'phone' => $client->tel
                ]);
                array_push($result, $currentClient);
            }
        }

        return $result;
    }

    /**
     * @param int $locationId
     * @return mixed
     */
    public function getClientByLocationId(int $locationId)
    {
        $relation = $this->clientLocations::where('location_id', $locationId)->first();
        return $this->clients->find($relation->client_id);
    }

}

?>
