<?php

namespace App\Repositories;

use App\ClientLocations;
use App\Clients;

class ClientsRepository extends Repository {

    private $clientLocations;

    private $clients;

    public function __construct(ClientLocations $clientLocations, Clients $clients)
    {
        $this->clientLocations = $clientLocations;
        $this->clients = $clients;
    }

    public function saveClientsArray(array $clients)
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

}