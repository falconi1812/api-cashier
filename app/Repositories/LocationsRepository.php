<?php

namespace App\Repositories;

use App\Locations;
use App\ClientLocations;
use App\Clients;
use App\LocationProducts;
use App\Products;
use App\Repositories\TerrainRepository;
use App\Exceptions\LocationExceptions;
use App\Repositories\TypeLocationRepository;

/**
 * Class LocationsRepository
 * @package App\Repositories
 */
class LocationsRepository extends Repository {

    /**
     * @var Locations
     */
    private $locations;

    /**
     * @var ClientLocations
     */
    private $clientLocations;

    /**
     * @var Clients
     */
    private $clients;

    /**
     * @var \App\Repositories\TerrainRepository
     */
    private $terrainRepository;

    /**
     * @var \App\Repositories\TypeLocationRepository
     */
    private $typeLocationRepository;

    /**
     * @var LocationExceptions
     */
    private $locationException;

    /**
     * LocationsRepository constructor.
     * @param Locations $locations
     * @param ClientLocations $clientLocations
     * @param Clients $clients
     * @param \App\Repositories\TerrainRepository $terrain
     * @param \App\Repositories\TypeLocationRepository $typeLocationRepository
     * @param LocationExceptions $locationExceptions
     */
    public function __construct(
                          Locations $locations,
                          ClientLocations $clientLocations,
                          Clients $clients,
                          TerrainRepository $terrain,
                          TypeLocationRepository $typeLocationRepository,
                          LocationExceptions $locationExceptions
                          )
    {
        $this->locations = $locations;
        $this->clientLocations = $clientLocations;
        $this->clients = $clients;
        $this->terrainRepository = $terrain;
        $this->typeLocationRepository = $typeLocationRepository;
        $this->locationException = $locationExceptions;
    }

    /**
     * @param array $clients
     * @return array
     */
    public function saveLocationWithClientsArray(array $clients) : array
    {
        $locations = array_map(function($client) {

            $location = Locations::withTrashed()->where('code', $client->code_loc)->first();

            if (empty($location)) {
                $location = Locations::create([
                    "code" => $client->code_loc,
                    "players" => $client->nb,
                    "hour_end" => $client->hour_end,
                    "hour_start" => $client->hour_start,
                    "day" => date('Y-m-d'),
                    "type_id" => $this->typeLocationRepository->createIfdoesNotExist($client->type_rental),
                    "terrain_id" => $this->terrainRepository->createIfdoesNotExist($client->terrain)
                ]);
            }

            return ['location_id' => $location->id, 'client_email' => $client->mail];

        }, $clients);

        return $locations;
    }

    /**
     * @param array $clientsEmailAndLocationId
     * @return array
     * @throws \Exception
     */
    public function saveClientLocationRelationshipWithEmail(array $clientsEmailAndLocationId) : array
    {
        $result = [];

        foreach ($clientsEmailAndLocationId as $client) {
            $email = $client['client_email'];
            $clientObject = Clients::where('email', $email)->first();

            if (empty($clientObject)) {
                throw new \Exception("There's not any user with email {$email}", 409);
            }

            array_push($result, $this->saveClientLocationRelationship($clientObject->id, $client['location_id']));
        }

        return $result;
    }

    /**
     * @param int $clientId
     * @param int $locationId
     * @return mixed
     */
    public function saveClientLocationRelationship(int $clientId, int $locationId)
    {
        $existRelationship = ClientLocations::where('client_id', $clientId)->where('location_id', $locationId)->first();

        if (!empty($existRelationship)) {
            return $existRelationship;
        }

        return ClientLocations::create(['client_id' => $clientId, 'location_id' => $locationId, 'day' => date('Y-m-d')]);
    }

    /**
     * @param string $code
     * @return mixed
     */
    public function getAllIncludingClientByCode(string $code)
    {
        $locationObject = Locations::where('code', $code)->with(['clients.client', 'products.product.icon'])->first();

        if (empty($locationObject)) {
            $this->locationException->notFound('location', $code);
        }

        $locationObject->client = $locationObject->clients->client;

        $locationObject->allProducts = $this->getAllProductsWithIconName($locationObject->products);

        unset($locationObject->clients);
        unset($locationObject->products);

        return $locationObject;
    }

    /**
     * @param string $code
     * @param int $product_id
     * @param array $items
     * @return mixed
     */
    public function addItemsToList(string $code, int $product_id, array $items)
    {
        $products = $this->getProductsByCodeAndProductId($code, $product_id);
        $products->products_in_list = $products->products_in_list + $items['products_in_list'];
        $products->products_in_payment = $products->products_in_payment + $items['products_in_payment'];

        return $products->save();
    }

    /**
     * @param string $code
     * @param int $product_id
     * @param array $items
     * @return mixed
     * @throws \Exception
     */
    public function removeItemsFromList(string $code, int $product_id, array $items)
    {
      $products = $this->getProductsByCodeAndProductId($code, $product_id);

      if ($products->products_in_list < $items['products_in_list'] || $products->products_in_payment < $items['products_in_payment']) {
        throw new \Exception("Products cannot be negative, not enough products for removal", 409);
      }

      $products->products_in_list = $products->products_in_list - $items['products_in_list'];
      $products->products_in_payment = $products->products_in_payment - $items['products_in_payment'];

      return $products->save();
    }

    /**
     * @param string $code
     * @param int $product_id
     * @return mixed
     */
    public function getProductsByCodeAndProductId(string $code, int $product_id)
    {
      $locationObject = Locations::where('code', $code)->first();

      if (empty($locationObject)) {
          $this->locationException->notFound('location', $code);
      }

      $products = LocationProducts::where('location_id', $locationObject->id)->where('product_id', $product_id)->first();

      if (empty($products)) {
        $product = LocationProducts::create(['location_id' => $locationObject->id, 'product_id' => $product_id]);
        return $product;
      }

      return $products;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection $products
     * @param array $productsId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllProductsWithIconName(\Illuminate\Database\Eloquent\Collection $products, array $productsId = []) : \Illuminate\Database\Eloquent\Collection
    {
      $allProducts = Products::with(['icon']);

      if (!empty($productsId)) {
          $allProducts->whereIn('id', $productsId);
      }

      $allProducts = $allProducts->get();

      $allProducts = $this->formatProductsWithIcons($allProducts, $products);

      return $allProducts;
    }

    /**
     * @param int $locationId
     * @return mixed
     */
    public function removeLocation(int $locationId)
    {
      $location = Locations::find($locationId);

      if (empty($location)) {
          $this->locationException->notFound('location', $locationId);
      }

      return $location->delete();
    }

    /**
     * @param string $code
     * @return mixed
     */
    public function getIdFromCode(string $code)
    {
        $location = Locations::where('code', $code)->first();

        if (empty($location)) {
            $this->locationException->notFound('location', $locationId);
        }

        return $location->id;
    }

    /**
     * @param string $locationCode
     * @return mixed
     */
    public function restoreLocation(string $locationCode)
    {
        $location = $this->locations::where('code', $locationCode)->withTrashed()->get();

        if (empty($location)) {
            $this->locationException->notFound('location', $locationCode);
        }

        return $location[0]->restore();
    }

    /**
     * @param null $date
     * @return mixed
     */
    public function trash($date = null)
    {
        $locations = $this->locations::with(['clients.client', 'products.product.icon', 'type'])->onlyTrashed();

        if (!is_null($date)) {
            $locations->where('day', $date);
        }

        return $locations->get();
    }

    /**
     * @param $allProducts
     * @param $products
     * @return mixed
     */
    public function formatProductsWithIcons($allProducts, $products)
    {
        foreach ($allProducts as &$product) {
          $product->products_in_list = 0;
          $product->products_in_payment = 0;
          $product->icon_ref = $product->icon->ref;
          foreach ($products as $singleProduct) {
            if ($product->id === $singleProduct->product_id) {
                $product->products_in_list = $singleProduct->products_in_list;
                $product->products_in_payment = $singleProduct->products_in_payment;
                $product->icon_ref = $singleProduct->product->icon->ref;
            }
          }
          unset($product->icon);
        }

        return $allProducts;
    }

    /**
     * @param string $code
     * @param int $product_id
     * @param array $items
     * @return mixed
     */
    public function replaceItemsInList(string $code, int $product_id, array $items)
    {
        $products = $this->getProductsByCodeAndProductId($code, $product_id);
        $products->products_in_list = $items['products_in_list'];
        $products->products_in_payment = $items['products_in_payment'];

        return $products->save();
    }
}

?>
