<?php

namespace App\Services;

use GuzzleHttp\Client;

class Service
{
    public $client;

    public function __construct()
    {
        $this->client = new Client();
    }
}
