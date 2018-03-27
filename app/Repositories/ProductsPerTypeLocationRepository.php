<?php

namespace App\Repositories;

use App\Models\ProductsPerTypeLocation;
use App\Products;
use App\Type;
use App\Exceptions\CommonExceptions;

/**
 * Class ProductsPerTypeLocationRepository
 * @package App\Repositories
 */
class ProductsPerTypeLocationRepository extends Repository {

    /**
     * @var ProductsPerTypeLocation
     */
    private $productsPerTypeLocation;

    /**
     * @var Products
     */
    private $products;

    /**
     * @var CommonExceptions
     */
    private $commonExceptions;

    /**
     * @var Type
     */
    private $type;

    /**
     * ProductsPerTypeLocationRepository constructor.
     * @param ProductsPerTypeLocation $productsPerTypeLocation
     * @param Products $products
     * @param Type $type
     * @param CommonExceptions $commonExceptions
     */
    public function __construct(ProductsPerTypeLocation $productsPerTypeLocation, Products $products, Type $type, CommonExceptions $commonExceptions)
    {
        $this->productsPerTypeLocation = $productsPerTypeLocation;
        $this->products = $products;
        $this->type = $type;
        $this->commonExceptions = $commonExceptions;
        parent::__construct();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return $this->productsPerTypeLocation::all();
    }

    /**
     * @param int $productId
     * @param int $typeId
     * @return mixed
     */
    public function create(int $productId, int $typeId)
    {
        $this->checkIfProductAndTypeAreValid($productId, $typeId);

        return $this->productsPerTypeLocation::create(['product_id' => $productId, 'type_id' => $typeId]);
    }

    /**
     * @param int $typeId
     * @param array $productsId
     * @return mixed
     */
    public function filterProductsPerType(int $typeId, array $productsId)
    {
        return $this->productsPerTypeLocation::whereIn('product_id', $productsId)->where('type_id', $typeId)->get();
    }

    /**
     * @param int $productId
     * @param int $typeId
     * @return mixed
     */
    public function delete(int $productId, int $typeId)
    {
        $this->checkIfProductAndTypeAreValid($productId, $typeId);

        $relationship = $this->productsPerTypeLocation::where('type_id', $typeId)->where('product_id', $productId)->first();

        if (empty($relationship)) {
            $this->commonExceptions->notFound('Product per type', "$typeId - $productId");
        }

        return $relationship->delete();
    }

    /**
     * @param int $productId
     * @param int $typeId
     * @return mixed
     */
    public function findByTypeAndProduct(int $productId, int $typeId)
    {
        $this->checkIfProductAndTypeAreValid($productId, $typeId);

        return $this->productsPerTypeLocation::where('product_id', $productId)->where('type_id', $typeId)->first();
    }

    /**
     * @param int $productId
     * @param int $typeId
     */
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
