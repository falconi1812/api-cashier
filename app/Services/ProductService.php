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
        $body = $this->getBody($body);

        return $this->productRepository->create($body);
    }

    /**
     * @SWG\Definition(
     * 		definition="genericOkResponse",
     *    @SWG\Property(property="ok", type="boolean")
     * )
     */
    public function update($productId, $body)
    {
        $body = $this->getBody($body);

        return $this->productRepository->update($productId, $body);
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
        return $this->productRepository->getAll();
    }

    public function delete($productId)
    {
        return $this->productRepository->delete($productId);
    }
}

?>
