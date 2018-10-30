<?php

namespace App\Services;

use App\Repositories\TerrainRepository;

class TerrainService extends Service
{
    private $terrainRepository;

    public function __construct(TerrainRepository $terrainRepository)
    {
        parent::__construct();
        $this->terrainRepository = $terrainRepository;
    }

    /**
     * @SWG\Definition(
     * 		definition="GetAllTerrains",
     *    @SWG\Property(property="terrains", type="array", @SWG\Items(
     *          @SWG\Property(property="id", type="integer"),
     *          @SWG\Property(property="name", type="string"),
     *          @SWG\Property(property="created_at", type="string"),
     *          @SWG\Property(property="updated_at", type="string"),
     *      )
     *    ),
     * )
     */
    public function getAll()
    {
      try {

        return $this->terrainRepository->getAll();

      } catch (Exception $e) {

        report($e);
        return $e->getMessage();

      }
    }

}

?>
