<?php

namespace App\Repositories;

use App\Terrain;

class TerrainRepository extends Repository {

    public function getAll()
    {
        return Terrain::all();
    }

    public function createIfdoesNotExist($terrainName)
    {
        $terrain = Terrain::firstOrCreate(['name' => $terrainName]);

        return $terrain->id;
    }

}

?>
