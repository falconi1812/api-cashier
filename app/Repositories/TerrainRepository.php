<?php

namespace App\Repositories;

use App\Terrain;

/**
 * Class TerrainRepository
 * @package App\Repositories
 */
class TerrainRepository extends Repository {

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return Terrain::all();
    }

    /**
     * @param $terrainName
     * @return mixed
     */
    public function createIfdoesNotExist($terrainName)
    {
        $terrain = Terrain::firstOrCreate(['name' => $terrainName]);

        return $terrain->id;
    }

}

?>
