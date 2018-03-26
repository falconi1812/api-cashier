<?php

namespace App\Repositories;

use App\Models\ProductsPerTerrain;
use App\Exceptions\CommonExceptions;

class ProductsPerTerrainRepository extends Repository {

    private $productsPerTerrain;

    private $commonExceptions;

    public function __construct(ProductsPerTerrain $productsPerTerrain, CommonExceptions $commonExceptions)
    {
        $this->productsPerTerrain = $productsPerTerrain;
        $this->commonExceptions = $commonExceptions;
        parent::__construct();
    }

    public function getAll()
    {
        return $this->productsPerTerrain::all();
    }

    public function create(int $productId, int $terrainId)
    {
        return $this->productsPerTerrain::create(['product_id' => $productId, 'terrain_id' => $terrainId]);
    }

    public function filterProductsPerTerrain(int $terrainId, array $productsId)
    {
        return $this->productsPerTerrain::whereIn('product_id', $productsId)->where('terrain_id', $terrainId)->get();
    }

    public function delete(int $productId, int $terrainId)
    {
        $relationship = $this->productsPerTerrain::where('terrain_id', $terrainId)->where('product_id', $productId)->first();

        if (empty($relationship)) {
            $this->commonExceptions->notFound('ProductPerTerrain', "$terrainId - $productId");
        }

        return $relationship->delete();
    }

}

?>
