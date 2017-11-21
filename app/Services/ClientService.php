<?php

namespace App\Services;

class ClientService extends Service
{
    public function __construct()
    {
        parent::__construct();
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
    public function getClients()
    {
        $today = date('Y-m-d');
        $uri = str_replace('{YYYY-MM-DD}', '2017-10-28', env('GET_CLIENTS'));
        $response = $this->client->request('GET', $uri);

        return json_decode($response->getBody());
    }
}
