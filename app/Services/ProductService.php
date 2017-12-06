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

    public function create($body)
    {
        $body = $this->getBody($body);

        return $this->productRepository->create($body);
    }

    public function update($productId, $body)
    {
        $body = $this->getBody($body);

        return $this->productRepository->update($productId, $body);
    }

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
