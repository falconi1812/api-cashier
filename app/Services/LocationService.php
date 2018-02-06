<?php

namespace App\Services;

use App\Locations;
use App\Repositories\LocationsRepository as locationRepository;
use App\Repositories\ClientsRepository;
use Illuminate\Mail\Message;
use PDF;
use Mail;

class LocationService extends Service
{
    private $locationsRepository;

    private $clientsRepository;

    public function __construct(locationRepository $locationsRepository, ClientsRepository $ClientsRepository)
    {
        parent::__construct();
        $this->locationsRepository = $locationsRepository;
        $this->clientsRepository = $ClientsRepository;
        $this->template_id = env('SENDGRID_TEMPLATE_ID', null);
        $this->mail_from_address = env('MAIL_FROM_ADDRESS', 'noreply@paintballarena.ch');
    }

    /**
     * @SWG\Definition(
     * 		definition="LocationByCode",
     *    @SWG\Property(property="products", type="array", @SWG\Items(
     *          @SWG\Property(property="id", type="string"),
     *          @SWG\Property(property="icon_name", type="string"),
     *          @SWG\Property(property="icon_id", type="integer"),
     *          @SWG\Property(property="price", type="integer"),
     *          @SWG\Property(property="products_in_list", type="integer"),
     *          @SWG\Property(property="products_in_payment", type="integer"),
     *          @SWG\Property(property="created_at", type="string"),
     *          @SWG\Property(property="updated_at", type="string"),
     *      )
     *    ),
     *    @SWG\Property(property="location", type="object",
     *          @SWG\Property(property="id", type="string"),
     *          @SWG\Property(property="code", type="string"),
     *          @SWG\Property(property="players", type="integer"),
     *          @SWG\Property(property="hour_end", type="string"),
     *          @SWG\Property(property="hour_start", type="string"),
     *          @SWG\Property(property="type_id", type="integer"),
     *          @SWG\Property(property="terrain_id", type="integer"),
     *          @SWG\Property(property="created_at", type="string"),
     *          @SWG\Property(property="updated_at", type="string"),
     *    ),
     *    @SWG\Property(property="client", type="object",
     *           @SWG\Property(property="id", type="integer"),
     *           @SWG\Property(property="name", type="string"),
     *           @SWG\Property(property="last_name", type="string"),
     *           @SWG\Property(property="email", type="string"),
     *           @SWG\Property(property="phone", type="string")
     *   ),
     * )
     */
    public function getLocationByCode(string $code) : array
    {
        $location = $this->locationsRepository->getAllIncludingClientByCode($code);

        return [
                'client' => $location->client,
                'products' => $location->allProducts,
                'location' => array_except($location, ['allProducts','client'])
             ];
    }

    /**
     * @SWG\Definition(
     * 		definition="setItemsPerLocationCode",
     *    @SWG\Property(property="id", type="string"),
     *    @SWG\Property(property="product_id", type="string"),
     *    @SWG\Property(property="location_id", type="string"),
     *    @SWG\Property(property="products_in_list", type="string"),
     *    @SWG\Property(property="products_in_payment", type="string"),
     *    @SWG\Property(property="total_payed", type="string"),
     * )
     */
    public function setItems(string $code, int $product_id, $body) : \App\LocationProducts
    {
      if (isset($body['add'])) {
        $this->locationsRepository->addItemsToList($code, $product_id, array_get($body, 'add'));
      }

      if (isset($body['remove'])) {
        $this->locationsRepository->removeItemsFromList($code, $product_id, array_get($body, 'remove'));
      }

      return $this->locationsRepository->getProductsByCodeAndProductId($code, $product_id);
    }

    public function processClose(string $code)
    {
        $locationId = $this->locationsRepository->getIdFromCode($code);
        $user = $this->clientsRepository->getClientByLocationId($locationId)->toArray();
        $locationObject = $this->locationsRepository->getAllIncludingClientByCode($code);

        // var_dump($locationObject);die;

        $data = ['user' => $user, 'location' => $locationObject];

        $attachment = PDF::loadView('pdf.invoice', compact('locationObject'));

        $name = 'tmp/githsub1111'. rand(0, 100) .'2wss.pdf';

        $attachment->save($name);

        Mail::send('welcome', $user, function ($message) use ($user ,$attachment, $name) {
            $message
                ->subject(env('COMPLETE_SELL_SUBJECT', 'PaintBall arena'))
                ->to(env('TO_TEST_EMAIL', $user['email']), $user['name'])
                ->from($this->mail_from_address, env('MAIL_FROM_NAME'))
                ->attach($name)
                ->embedData([
                    'template_id' => $this->template_id
                ], 'sendgrid/x-smtpapi');
        });

        return $this->locationsRepository->removeLocation($locationId);
    }

}

?>
