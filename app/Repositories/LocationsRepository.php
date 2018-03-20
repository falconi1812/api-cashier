<?php

namespace App\Repositories;

use App\Locations;
use App\ClientLocations;
use App\Clients;
use App\LocationProducts;
use App\Products;
use App\Repositories\TerrainRepository;
use App\Exceptions\LocationExceptions;

class LocationsRepository extends Repository {

    private $locations;

    private $clientLocations;

    private $clients;

    private $terrainRepository;

    private $locationException;

    public function __construct(
                          Locations $locations,
                          ClientLocations $clientLocations,
                          Clients $clients,
                          TerrainRepository $terrain,
                          LocationExceptions $locationExceptions
                          )
    {
        $this->locations = $locations;
        $this->clientLocations = $clientLocations;
        $this->clients = $clients;
        $this->terrainRepository = $terrain;
        $this->locationException = $locationExceptions;
    }

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
                    "type_id" => 1,
                    "terrain_id" => $this->terrainRepository->createIfdoesNotExist($client->terrain)
                ]);
            }

            return ['location_id' => $location->id, 'client_email' => $client->mail];

        }, $clients);

        return $locations;
    }

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

    public function saveClientLocationRelationship(int $clientId, int $locationId)
    {
        $existRelationship = ClientLocations::where('client_id', $clientId)->where('location_id', $locationId)->first();

        if (!empty($existRelationship)) {
            return $existRelationship;
        }

        return ClientLocations::create(['client_id' => $clientId, 'location_id' => $locationId, 'day' => date('Y-m-d')]);
    }

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

    public function addItemsToList(string $code, int $product_id, array $items)
    {
        $products = $this->getProductsByCodeAndProductId($code, $product_id);
        $products->products_in_list = $products->products_in_list + $items['products_in_list'];
        $products->products_in_payment = $products->products_in_payment + $items['products_in_payment'];

        return $products->save();
    }

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

    public function getAllProductsWithIconName(\Illuminate\Database\Eloquent\Collection $products) : \Illuminate\Database\Eloquent\Collection
    {
      $allProducts = Products::with(['icon'])->get();

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

    public function removeLocation(int $locationId)
    {
      $location = Locations::find($locationId);

      if (empty($location)) {
          $this->locationException->notFound('location', $locationId);
      }

      return $location->delete();
    }

    public function getIdFromCode(string $code)
    {
        $location = Locations::where('code', $code)->first();

        if (empty($location)) {
            $this->locationException->notFound('location', $locationId);
        }

        return $location->id;
    }

    public function restoreLocation(string $locationCode)
    {
        $location = $this->locations::where('code', $locationCode)->withTrashed()->get();

        if (empty($location)) {
            $this->locationException->notFound('location', $locationCode);
        }

        return $location[0]->restore();
    }

    public function trash($date = null)
    {
        $locations = $this->locations::with(['clients.client', 'products.product.icon'])->onlyTrashed();

        if (!is_null($date)) {
            $locations->where('day', $date);
        }

        return $locations->get();
    }
}

?>
