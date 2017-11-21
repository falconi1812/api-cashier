<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LocationService;

/**
 * @SWG\Tag(
 *   name="Locations",
 *   description="Terrains and clients relationship"
 * )
 */
class LocationsController extends Controller
{
    private $locationService;

    public function __construct()
    {
        $this->locationService = new LocationService();
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
}
