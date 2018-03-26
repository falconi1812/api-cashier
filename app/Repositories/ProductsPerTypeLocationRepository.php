<?php

namespace App\Repositories;

use App\Models\ProductsPerTypeLocation;
use App\Products;
use App\Type;
use App\Exceptions\CommonExceptions;

class ProductsPerTypeLocationRepository extends Repository {

    private $productsPerTypeLocation;

    private $products;

    private $commonExceptions;

    private $type;

    public function __construct(ProductsPerTypeLocation $productsPerTypeLocation, Products $products, Type $type, CommonExceptions $commonExceptions)
    {
        $this->productsPerTypeLocation = $productsPerTypeLocation;
        $this->products = $products;
        $this->type = $type;
        $this->commonExceptions = $commonExceptions;
        parent::__construct();
    }

    public function getAll()
    {
        return $this->productsPerTypeLocation::all();
    }

    public function create(int $productId, int $typeId)
    {
        $this->checkIfProductAndTypeAreValid($productId, $typeId);

        return $this->productsPerTypeLocation::create(['product_id' => $productId, 'type_id' => $typeId]);
    }

    public function filterProductsPerType(int $typeId, array $productsId)
    {
        return $this->productsPerTypeLocation::whereIn('product_id', $productsId)->where('type_id', $typeId)->get();
    }

    public function delete(int $productId, int $typeId)
    {
        $this->checkIfProductAndTypeAreValid($productId, $typeId);

        $relationship = $this->productsPerTypeLocation::where('type_id', $typeId)->where('product_id', $productId)->first();

        if (empty($relationship)) {
            $this->commonExceptions->notFound('Product per type', "$typeId - $productId");
        }

        return $relationship->delete();
    }

    public function findByTypeAndProduct(int $productId, int $typeId)
    {
        $this->checkIfProductAndTypeAreValid($productId, $typeId);

        return $this->productsPerTypeLocation::where('product_id', $productId)->where('type_id', $typeId)->first();
    }

    private function checkIfProductAndTypeAreValid(int $productId, int $typeId)
    {
        if (empty($this->products::find($productId))) {
            $this->commonExceptions->notFound('Product', $productId);
        }

        if (empty($this->type::find($typeId))) {
            $this->commonExceptions->notFound('type location', $productId);
        }
    }

}

?>
