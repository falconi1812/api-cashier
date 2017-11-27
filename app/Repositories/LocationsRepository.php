<?php

namespace App\Repositories;

use App\Locations;
use App\ClientLocations;
use App\Clients;

class LocationsRepository extends Repository {

    private $locations;

    private $clientLocations;

    private $clients;

    public function __construct(Locations $locations, ClientLocations $clientLocations, Clients $clients)
    {
        $this->locations = $locations;
        $this->clientLocations = $clientLocations;
        $this->clients = $clients;
    }

    public function saveLocationWithClientsArray(array $clients) : array
    {
        $locations = array_map(function($client) {

            $location = Locations::where('code', $client->code_loc)->first();

            if (empty($location)) {
                $location = Locations::create([
                    "code" => $client->code_loc,
                    "players" => $client->nb,
                    "hour_end" => $client->hour_end,
                    "hour_start" => $client->hour_start,
                    "day" => date('Y-m-d'),
                    "type_id" => 1,
                    "terrain_id" => 1
                ]);
            }

            return ['location_id' => $location->id, 'client_email' => $client->mail];

        }, $clients);

        return $locations;
    }

    public function saveClientLocationRelationshipWithEmail(array $clientsEmailAndLocationId)
    {
        $result = [];

        foreach ($clientsEmailAndLocationId as $client) {
            $email = $client['client_email'];
            $clientObject = Clients::where('email', $email)->first();

            if (empty($clientObject)) {
                throw new \Exception("There's not any user with email {$email}", 409);
            }

            array_push($result, $this->saveClientLocationRelationship($clientObject->id, $client['location_id']));
        }

        return $result;
    }

    public function saveClientLocationRelationship(int $clientId, int $locationId)
    {
        $existRelationship = ClientLocations::where('client_id', $clientId)->where('location_id', $locationId)->first();

        if (!empty($existRelationship)) {
            return $existRelationship;
        }

        return ClientLocations::create(['client_id' => $clientId, 'location_id' => $locationId, 'day' => date('Y-m-d')]);
    }

    public function getAllIncludingClientByCode(string $code)
    {
        $locationObject = Locations::where('code', $code)->with(['products', 'clients.client'])->first();

        $client = $locationObject->clients->client;

        $locationObject->client = $client;

        unset($locationObject->clients);

        return $locationObject;
    }
}
