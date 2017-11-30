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
     *      @SWG\Property(property="id", type="string"),
     *      @SWG\Property(property="code", type="string"),
     *      @SWG\Property(property="players", type="string"),
     *      @SWG\Property(property="hour_end", type="string"),
     *      @SWG\Property(property="hour_start", type="string"),
     *      @SWG\Property(property="type_id", type="string"),
     *      @SWG\Property(property="terrain_id", type="string"),
     *      @SWG\Property(property="created_at", type="string"),
     *      @SWG\Property(property="updated_at", type="string"),
     * 		  @SWG\Property(property="products", type="array", @SWG\Items(
     *          type="object",
     *              @SWG\Property(property="id", type="string"),
     *              @SWG\Property(property="product_id", type="string"),
     *              @SWG\Property(property="location_id", type="string"),
     *              @SWG\Property(property="products_in_list", type="string"),
     *              @SWG\Property(property="products_in_payment", type="string"),
     *              @SWG\Property(property="total_in_list", type="string"),
     *              @SWG\Property(property="total_in_payment", type="string"),
     *              @SWG\Property(property="total_payed", type="string"),
     *              @SWG\Property(property="created_at", type="string"),
     *              @SWG\Property(property="updated_at", type="string"),
     *      )
     *    ),
     *    @SWG\Property(property="client", type="array", @SWG\Items(
     *          type="object",
     *              @SWG\Property(property="id", type="string"),
     *              @SWG\Property(property="name", type="string"),
     *              @SWG\Property(property="last_name", type="string"),
     *              @SWG\Property(property="email", type="string"),
     *              @SWG\Property(property="phone", type="string"),
     *      )
     *   ),
     * )
     */
    public function getLocationByCode(string $code)
    {
        return $this->locationsRepository->getAllIncludingClientByCode($code);
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
    public function setItems(string $code, int $product_id, $body)
    {
      if (isset($body['add'])) {
        $this->locationsRepository->addItemsToList($code, $product_id, array_get($body, 'add'));
      }

      if (isset($body['remove'])) {
        $this->locationsRepository->removeItemsFromList($code, $product_id, array_get($body, 'remove'));
      }

      return $this->locationsRepository->getProductsByCodeAndProductId($code, $product_id);
    }

}
