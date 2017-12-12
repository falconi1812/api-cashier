<?php

namespace App\Services;

use App\Repositories\ProductsRepository as productRepository;
use App\Repositories\LocationsRepository as locationsRepository;

class ProductService extends Service
{
    private $productRepository;

    private $locationsRepository;

    public function __construct(productRepository $productRepository, locationsRepository $locationsRepository)
    {
        parent::__construct();
        $this->productRepository = $productRepository;
        $this->locationsRepository = $locationsRepository;
    }

    /**
     * @SWG\Definition(
     * 		definition="createProduct",
     *          @SWG\Property(property="id", type="string"),
     *          @SWG\Property(property="icon_name", type="string"),
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

          return $this->productRepository->create($this->getBody($body));

        } catch (Exception $e) {

          report($e);
          return $e->getMessage();

        }
    }

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
     *          @SWG\Property(property="icon_name", type="string"),
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

          return $this->productRepository->getAll();

        } catch (Exception $e) {

          report($e);
          return $e->getMessage();

        }
    }

    public function delete(int $productId)
    {
        try {

          return $this->productRepository->delete($productId);

        } catch (Exception $e) {

          report($e);
          return $e->getMessage();
          
        }
    }
}

?>
