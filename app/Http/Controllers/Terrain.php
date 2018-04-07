<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TerrainService;

/**
 * @SWG\Tag(
 *   name="Terrain",
 *   description="Mostly a catalog of terrains available"
 * )
 */
class TerrainController extends Controller
{
    private $terrainService;

    public function __construct(TerrainService $terrainService)
    {
        $this->terrainService = $terrainService;
    }
    /**
     * @SWG\Get(
     *     path="/terrains",
     *     @SWG\Response(
     *          response="200",
     *          description="Return all terrains as an array",
     *          @SWG\Schema(ref="#/definitions/GetAllTerrains")),
     *     tags={"Terrain"},
     * )
     */
    public function read()
    {
        return response()->json(["terrains" => $this->terrainService->getAll()]);
    }
}

?>
