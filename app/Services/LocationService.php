<?php

namespace App\Services;

use App\Locations;
use App\Repositories\LocationsRepository as locationRepository;

class LocationService extends Service
{
    private $locationsRepository;

    public function __construct(locationRepository $locationsRepository)
    {
        parent::__construct();
        $this->locationsRepository = $locationsRepository;
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
        return $this->locationsRepository->removeLocation(
                                $this->locationsRepository->getIdFromCode($code)
                              );
    }

}

?>
