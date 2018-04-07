<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TypeLocationService;

/**
 * @SWG\Tag(
 *   name="TypesLocation",
 *   description="Mostly a catalog of type of game available for a location"
 * )
 */
class TypeOfLocations extends Controller
{
    private $typeLocationService;

    public function __construct(TypeLocationService $typeLocationService)
    {
        $this->typeLocationService = $typeLocationService;
    }

    /**
     * @SWG\Get(
     *     path="/type-of-location",
     *     @SWG\Response(
     *          response="200",
     *          description="Return all types as an array",
     *          @SWG\Schema(ref="#/definitions/GetAllTypes")),
     *     tags={"TypesLocation"},
     * )
     */
    public function read()
    {
        return response()->json(["types" => $this->typeLocationService->getAll()]);
    }
}
