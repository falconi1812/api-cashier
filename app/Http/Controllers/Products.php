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

    /**
     * @SWG\Post(
     *     path="/products",
     *     @SWG\Parameter(
     *        name="body",
     *        in="body",
     *        description="Product properties",
     *        required=false,
     *        @SWG\Schema(
     *            @SWG\Property(property="icon_id", type="integer"),
     *            @SWG\Property(property="name", type="string"),
     *            @SWG\Property(property="price", type="integer")
     *        )
     *      ),
     *     @SWG\Response(
     *          response="200",
     *          description="Creates new product",
     *          @SWG\Schema(ref="#/definitions/createProduct")),
     *     tags={"Products"},
     * )
     */
    public function create(Request $request)
    {
        return response()->json($this->productService->create($request));
    }

    /**
     * @SWG\Put(
     *     path="/products/{product_id}",
     *     @SWG\Parameter(name="product_id", in="path", description="product ID", required=true, type="string"),
     *     @SWG\Parameter(
     *        name="body",
     *        in="body",
     *        description="Properties to update",
     *        required=false,
     *        @SWG\Schema(
     *            @SWG\Property(property="icon_id", type="integer"),
     *            @SWG\Property(property="name", type="string"),
     *            @SWG\Property(property="price", type="integer")
     *        )
     *      ),
     *     @SWG\Response(
     *          response="200",
     *          description="Updates chosen product",
     *          @SWG\Schema(ref="#/definitions/genericOkResponse")),
     *     tags={"Products"},
     * )
     */
    public function update($productId, Request $request)
    {
        return response()->json($this->productService->update($productId, $request));
    }

    /**
     * @SWG\Get(
     *     path="/products",
     *     @SWG\Response(
     *          response="200",
     *          description="Return all produtcs as an array",
     *          @SWG\Schema(ref="#/definitions/GetAllProducts")),
     *     tags={"Products"},
     * )
     */
    public function read()
    {
        return response()->json(["products" => $this->productService->getAll()]);
    }

    /**
     * @SWG\Delete(
     *     path="/products/{product_id}",
     *     @SWG\Parameter(name="product_id", in="path", description="product ID", required=true, type="string"),
     *     @SWG\Response(
     *          response="200",
     *          description="Delete chosen product",
     *          @SWG\Schema(ref="#/definitions/genericOkResponse")),
     *     tags={"Products"},
     * )
     */
    public function delete($productId)
    {
        return response()->json($this->productService->delete($productId));
    }
}
