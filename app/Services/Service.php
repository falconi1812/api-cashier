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

    public function getBody(\Illuminate\Http\Request $body)
    {
      if (empty($body->all())) {
          throw new \Exception("Body empty.", 400);
      }

      return $body;
    }
}

?>
