<?php

namespace App\Services;

use App\Locations;

class LocationService extends Service
{
    public function __construct()
    {
        parent::__construct();
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
     * 		@SWG\Property(property="products", type="array", @SWG\Items(
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
     *   ),
     * )
     */
    public function getLocationByCode(string $code)
    {
        $result = Locations::where('code', $code)->with('products')->first();
        return $result;
    }

}
