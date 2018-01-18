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
        $terrain = Terrain::where('name', $terrainName)->first();

        if (isset($terrain->id)) {
          return $terrain->id;
        }

        $terrain = Terrain::create(['name' => $terrainName]);

        return $terrain->id;
    }

}

?>
