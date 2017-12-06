<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;

/**
 * @SWG\Tag(
 *   name="Products",
 *   description="Main products inventory"
 * )
 */
class ProductsController extends Controller
{

    private $productService;

    public function __construct(ProductService $ProductService)
    {
        $this->productService = $ProductService;
    }

    public function create(Request $request)
    {
        return response()->json($this->productService->create($request));
    }

    public function update($productId, Request $request)
    {
        return response()->json($this->productService->update($productId, $request));
    }

    public function read()
    {
        return response()->json(["products" => $this->productService->getAll()]);
    }

    public function delete($productId)
    {
        return response()->json($this->productService->delete($productId));
    }
}
