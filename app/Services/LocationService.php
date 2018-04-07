<?php

namespace App\Services;

use App\Locations;
use App\Repositories\LocationsRepository;
use App\Repositories\ClientsRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\ProductsPerTypeLocationRepository;
use Illuminate\Mail\Message;
use PDF;
use Mail;
use App\Helpers\PDFHelper;

class LocationService extends Service
{
    use PDFHelper;

    private $locationsRepository;

    private $clientsRepository;

    private $paymentsRepository;

    private $productsPerTypeLocationRepository;

    public function __construct(
                                  LocationsRepository $locationsRepository,
                                  ClientsRepository $ClientsRepository,
                                  PaymentRepository $paymentsRepository,
                                  ProductsPerTypeLocationRepository $productsPerTypeLocationRepository
                                )
    {
        parent::__construct();
        $this->locationsRepository = $locationsRepository;
        $this->clientsRepository = $ClientsRepository;
        $this->paymentsRepository = $paymentsRepository;
        $this->productsPerTypeLocationRepository = $productsPerTypeLocationRepository;
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

        // $filterProducts = $this->productsPerTypeLocationRepository->filterProductsPerType($location->type_id, array_pluck($location->allProducts, 'id'));

        // $location->allProducts = $this->locationsRepository->getAllProductsWithIconName($location->allProducts, array_pluck($filterProducts, 'id'));

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
        $payments = $this->paymentsRepository->findBylocation($locationId);

        $attachment = $this->composeInvoice($locationObject, $user, $payments);

        Mail::send('welcome', $user, function ($message) use ($user ,$attachment) {
            $message
                ->subject(env('COMPLETE_SELL_SUBJECT', 'PaintBall'))
                ->to(env('TO_TEST_EMAIL', $user['email']), $user['name'])
                ->cc(env('CC_TEST_EMAIL', 'renatomoor1@gmail.com'), $user['name'])
                ->from($this->mail_from_address, env('MAIL_FROM_NAME'))
                ->attach($attachment)
                ->embedData([
                    'template_id' => $this->template_id
                ], 'sendgrid/x-smtpapi');
        });

        return $this->locationsRepository->removeLocation($locationId);
    }

    public function composeInvoice($locationObject, $user, $payments)
    {
        $allProductsForCard = $this->paymentsRepository->groupForInvoice($payments, 1);
        $allProductsForCash = $this->paymentsRepository->groupForInvoice($payments, 2);

        $allProductsForCard['sub_total'] = $this->paymentsRepository->getTotalForInvoice($allProductsForCard);
        $allProductsForCash['sub_total'] = $this->paymentsRepository->getTotalForInvoice($allProductsForCash);

        $pays = ['allProductsForCard' => $allProductsForCard, 'allProductsForCash' => $allProductsForCash];

        $total = $allProductsForCard['sub_total'] + $allProductsForCash['sub_total'];

        $name = $this->createDir($this->createName($user['name'], '_', $locationObject->code, '_', time()));

        $attachment = PDF::loadView('pdf.invoice', compact('locationObject','pays','total'));

        $attachment->save($name);

        return $name;
    }

    public function restoreLocationByCode(string $code)
    {
        return $this->locationsRepository->restoreLocation($code);
    }

    public function getTrash($date = null)
    {
        $date = is_null($date) ? date('Y-m-d') : $date;

        return $this->locationsRepository->trash($date);
    }

}

?>
