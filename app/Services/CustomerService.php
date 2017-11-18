<?php

namespace App\Services;

class CustomerService extends Service
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getClients()
    {
        $today = date('Y-m-d');
        $uri = str_replace('{YYYY-MM-DD}', $today, env('GET_CLIENTS'));
        $response = $this->client->request('GET', $uri);

        return json_decode($response->getBody());
    }
}
