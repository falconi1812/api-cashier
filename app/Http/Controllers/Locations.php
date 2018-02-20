<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LocationService;
use App\Services\ClientService;

/**
 * @SWG\Tag(
 *   name="Locations",
 *   description="Terrains and clients relationship"
 * )
 */
class LocationsController extends Controller
{
    private $locationService;

    public function __construct(LocationService $LocationService)
    {
        $this->locationService = $LocationService;
    }

    /**
     * @SWG\Get(
     *     path="/locations/{location_code}",
     *     @SWG\Parameter(name="location_code", in="path", description="location code. Example: DUF3D92P", required=true, type="string"),
     *     @SWG\Response(
     *          response="200",
     *          description="Should return all info by a location",
     *          @SWG\Schema(ref="#/definitions/LocationByCode")),
     *     tags={"Locations"},
     * )
     */
    public function getLocation($location_code)
    {
        return response()->json($this->locationService->getLocationByCode($location_code));
    }

    /**
     * @SWG\Put(
     *     path="/locations/products/{location_code}/{product_id}",
     *     @SWG\Parameter(name="location_code", in="path", description="location code. Example: DUF3D92P", required=true, type="string"),
     *     @SWG\Parameter(name="product_id", in="path", description="product ID", required=true, type="string"),
     *     @SWG\Parameter(
     *        name="body",
     *        in="body",
     *        description="List of ids",
     *        required=false,
     *        @SWG\Schema(
     *          @SWG\Property(property="add", type="object",
     *              @SWG\Property(property="products_in_list", type="integer"),
     *              @SWG\Property(property="products_in_payment", type="integer")
     *          ),
     *          @SWG\Property(property="remove", type="object",
     *              @SWG\Property(property="products_in_list", type="integer"),
     *              @SWG\Property(property="products_in_payment", type="integer")
     *          )
     *        )
     *      ),
     *     @SWG\Response(
     *          response="200",
     *          description="Should save items in the location",
     *          @SWG\Schema(ref="#/definitions/setItemsPerLocationCode")),
     *     tags={"Locations"},
     * )
     */
    public function setItems($location_code, $product_id, Request $request)
    {
        $body = $request->all();
        return response()->json($this->locationService->setItems($location_code, $product_id, $body));
    }

    /**
     * @SWG\Delete(
     *     path="/locations/{location_code}",
     *     @SWG\Parameter(name="location_code", in="path", description="location code. Example DUF3D92P", required=true, type="string"),
     *     @SWG\Response(
     *          response="200",
     *          description="Closes current location, we use logical deletes",
     *          @SWG\Schema(ref="#/definitions/genericOkResponse")),
     *     tags={"Locations"},
     * )
     */
    public function closeLocation($location_code)
    {
        return response()->json($this->locationService->processClose($location_code));
    }

    /**
     * @SWG\Put(
     *     path="/locations/in-trash/{location_code}",
     *     @SWG\Parameter(name="location_code", in="path", description="location code. Example DUF3D92P", required=true, type="string"),
     *     @SWG\Response(
     *          response="200",
     *          description="Restores location if is deleted",
     *          @SWG\Schema(ref="#/definitions/LocationByCode")),
     *     tags={"Locations"},
     * )
     */
    public function restoreLocation($location_code)
    {
        $this->locationService->restoreLocationByCode($location_code);

        return response()->json($this->locationService->getLocationByCode($location_code));
    }

    /**
     * @SWG\Get(
     *     path="/locations/in-trash",
     *     @SWG\Response(
     *          response="200",
     *          description="Should return all locations deleted for today",
     *          @SWG\Schema(ref="#/definitions/ClientsPerDay")),
     *     tags={"Locations"},
     * )
     *
     * @SWG\Get(
     *     path="/locations/in-trash/{date}",
     *     @SWG\Parameter(name="date", in="path", description="date format like this YYYY-MM-DD (2017-10-21)", required=true, type="string"),
     *     @SWG\Response(
     *          response="200",
     *          description="Should return all locations deleted that specific day",
     *          @SWG\Schema(ref="#/definitions/ClientsPerDay")),
     *     tags={"Locations"},
     * )
     */
    public function getDeletedLocations($date = null)
    {
        return response()->json($this->locationService->getTrash());
    }

}

?>
