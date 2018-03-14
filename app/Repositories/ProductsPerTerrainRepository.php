<?php

namespace App\Repositories;

use App\Models\ProductsPerTerrain;
use App\Exceptions\CommonExceptions;

class ProductsPerTerrainRepository extends Repository {

    private $productsPerTerrain;

    public function __construct(ProductsPerTerrain $productsPerTerrain)
    {
        $this->productsPerTerrain = $productsPerTerrain;
        parent::__construct();
    }

    public function getAll()
    {
        return $this->productsPerTerrain::all();
    }

    public function create($productId, $terrainId)
    {
        return $this->productsPerTerrain::create(['product_id' => $productId, 'terrain_id' => $terrainId]);
    }

}

?>
