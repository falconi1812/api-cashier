<?php

namespace App\Repositories;

use App\Products;
use Validator;
use App\Exceptions\Handler;

/**
 * Class ProductsRepository
 * @package App\Repositories
 */
class ProductsRepository extends Repository {

    /**
     * @return array
     */
    public function rules()
    {
        return [
              'name' => 'required|max:255|string',
              'price' => 'required|integer',
              'icon_id' => 'required|integer'
          ];
    }

    /**
     * @param $RequestProduct
     * @return array
     * @throws \Exception
     */
    public function validate($RequestProduct)
    {
      $isObjectValid = Validator::make($RequestProduct->all(), $this->rules());

      if ($isObjectValid->fails()) {
        throw new \Exception($isObjectValid->errors()->first(), 409);
      }

      return array_unique($RequestProduct->all());
    }

    /**
     * @param $RequestProduct
     * @return mixed
     */
    public function create($RequestProduct)
    {
        $RequestProduct = $this->validate($RequestProduct);

        return Products::create($RequestProduct);
    }

    /**
     * @param int $productId
     * @param $RequestProduct
     * @return mixed
     * @throws \Exception
     */
    public function update(int $productId, $RequestProduct)
    {
        $RequestProduct = $RequestProduct->all();

        $product = Products::find($productId);

        if (empty($product)) {
            throw new \Exception("Product with ID $productId does not exist.", 404);
        }

        foreach ($RequestProduct as $key => $value) {
            if (!isset($product->$key)) {
                throw new \Exception("$key does not exist, remove this field and try again.", 409);
            }
            $product->$key = $value;
        }

        return $product->save();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        $products = Products::with('icon')->get();

        foreach ($products as $key => $product) {
            $product->icon_ref = $product->icon->ref;
            $product->icon_id = $product->icon->id;

            unset($product->icon);
        }

        return $products;
    }

    /**
     * @param int $productId
     * @return mixed
     * @throws \Exception
     */
    public function delete(int $productId)
    {
        $product = Products::find($productId);

        if (empty($product)) {
            throw new \Exception("Product with ID $productId does not exist.", 404);
        }

        return $product->delete();
    }

}
?>
