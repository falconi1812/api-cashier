<?php

namespace App\Services;

use GuzzleHttp\Client;

class Service
{
    public $client;

    /**
     * @SWG\Definition(
     * 		definition="genericOkResponse",
     *    @SWG\Property(property="ok", type="boolean")
     * )
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    public function getBody(\Illuminate\Http\Request $body)
    {
      if (empty($body->all())) {
          abort(400, "Body empty.");
      }

      return $body;
    }
}

?>
