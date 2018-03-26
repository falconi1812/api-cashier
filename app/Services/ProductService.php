<?php

namespace App\Services;

use App\Repositories\ProductsRepository;
use App\Repositories\LocationsRepository;
use App\Repositories\ProductsPerTerrainRepository;

class ProductService extends Service
{
    private $productRepository;

    private $locationsRepository;

    private $productsPerTerrainRepository;

    public function __construct(ProductsRepository $productRepository, LocationsRepository $locationsRepository, ProductsPerTerrainRepository $productsPerTerrain)
    {
        parent::__construct();
        $this->productRepository = $productRepository;
        $this->locationsRepository = $locationsRepository;
        $this->productsPerTerrainRepository = $productsPerTerrain;
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

          $terrains = $body['terrain'];

          $product = $this->productRepository->create(array_except($body, ['terrain']));

          if (!empty($terrains)) {
              foreach ($terrains as $key => $belongs_to) {
                  $this->productsPerTerrainRepository->create($product->id, $belongs_to['id']);
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

          $productId = array_pluck($products, 'id');

          return $productId;

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
    public function deleteProductPerTerrain(int $productId, int $terrainId)
    {
        return $this->productsPerTerrainRepository->delete($productId, $terrainId);
    }
}

?>
