<?php

namespace App\Services;

use App\Repositories\ProductsRepository;
use App\Repositories\LocationsRepository;
use App\Repositories\ProductsPerTypeLocationRepository;

class ProductService extends Service
{
    private $productRepository;

    private $locationsRepository;

    private $productsPerTypeLocationRepository;

    public function __construct(ProductsRepository $productRepository, LocationsRepository $locationsRepository, ProductsPerTypeLocationRepository $productsPerTypeLocationRepository)
    {
        parent::__construct();
        $this->productRepository = $productRepository;
        $this->locationsRepository = $locationsRepository;
        $this->productsPerTypeLocationRepository = $productsPerTypeLocationRepository;
    }

    /**
     * @SWG\Definition(
     * 		definition="createProduct",
     *          @SWG\Property(property="id", type="string"),
     *          @SWG\Property(property="icon_ref", type="string"),
     *          @SWG\Property(property="icon_id", type="integer"),
     *          @SWG\Property(property="price", type="integer"),
     *          @SWG\Property(property="created_at", type="string"),
     *          @SWG\Property(property="updated_at", type="string"),
     *    ),
     * )
     */
    public function create($body)
    {
        try {
            $body = $this->getBody($body);

            $types = $body['type'];

            $product = $this->productRepository->create(array_except($body, ['type']));

            if (!empty($types)) {
                foreach ($types as $key => $belongs_to) {
                    $this->productsPerTypeLocationRepository->create($product->id, $belongs_to['id']);
                }
            }

            return $product;
        } catch (Exception $e) {
            report($e);
            return $e->getMessage();
        }
    }

    /**
    * this would have a generic response
    */
    public function update(int $productId, $body)
    {
        try {
            return $this->productRepository->update($productId, $this->getBody($body));
        } catch (Exception $e) {
            report($e);
            return $e->getMessage();
        }
    }

    /**
     * @SWG\Definition(
     * 		definition="GetAllProducts",
     *    @SWG\Property(property="products", type="array", @SWG\Items(
     *          @SWG\Property(property="id", type="string"),
     *          @SWG\Property(property="icon_ref", type="string"),
     *          @SWG\Property(property="icon_id", type="integer"),
     *          @SWG\Property(property="price", type="integer"),
     *          @SWG\Property(property="created_at", type="string"),
     *          @SWG\Property(property="updated_at", type="string"),
     *      )
     *    ),
     * )
     */
    public function getAll()
    {
        try {
            $products = $this->productRepository->getAll();

            return $products;
        } catch (Exception $e) {
            report($e);
            return $e->getMessage();
        }
    }

   /**
    * this would have a generic response
    */
    public function delete(int $productId)
    {
        try {
            return $this->productRepository->delete($productId);
        } catch (Exception $e) {
            report($e);
            return $e->getMessage();
        }
    }

   /**
    * this would have a generic response
    */
    public function deleteProductPerType(int $productId, int $typeId)
    {
        try {
            return $this->productsPerTypeLocationRepository->delete($productId, $typeId);
        } catch (Exception $e) {
            report($e);
            return $e->getMessage();
        }
    }

    /**
     * @SWG\Definition(
     * 		definition="getTypeLocationProductionRelation",
     *    @SWG\Property(property="id", type="integer"),
     *    @SWG\Property(property="product_id", type="integer"),
     *    @SWG\Property(property="type_id", type="integer"),
     *    @SWG\Property(property="created_at", type="string"),
     *    @SWG\Property(property="updated_at", type="string"),
     *   )
     * )
     */
    public function createProductPerType(int $productId, int $typeId)
    {
        try {
            $this->productsPerTypeLocationRepository->create($productId, $typeId);

            return $this->productsPerTypeLocationRepository->findByTypeAndProduct($productId, $typeId);
        } catch (Exception $e) {
            report($e);
            return $e->getMessage();
        }
    }
}

?>
