<?php

namespace App\Repositories;

use App\Payments;
use App\Repositories\RepositoryInterface;

class PaymentRepository extends Repository implements RepositoryInterface {

    public function getAll()
    {
        return Payments::all();
    }

    public function save(int $locationId, int $productId, int $quantity)
    {

    }

    public function find(int $id)
    {
        return Payments::find($id);
    }

    public function findBylocation(int $locationId) : array
    {
        return Payments::where('location_id', $locationId)->get();
    }

}

?>
