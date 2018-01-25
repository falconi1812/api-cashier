<?php

namespace App\Repositories;

use App\Payments;
use App\Repositories\RepositoryInterface;
use App\Exceptions\CommonExceptions;

class PaymentRepository extends Repository implements RepositoryInterface {

    private $paymentsModel;

    public function __construct(Payments $Payments)
    {
        $this->paymentsModel = $Payments;
        parent::__construct();
    }

    public function getAll()
    {
        return $this->paymentsModel::all();
    }

    public function create(array $parameters)
    {
        $this->validate($parameters);

        return $this->paymentsModel::create($parameters);
    }

    public function find(int $id)
    {
        return $this->paymentsModel::find($id);
    }

    public function findBylocation(int $locationId)
    {
        return $this->paymentsModel::where('location_id', $locationId)->get();
    }

    public function validate($payment)
    {
      $isObjectValid = $this->validator::make($payment, $this->paymentsModel->rules());

      if ($isObjectValid->fails()) {
        throw new \Exception($isObjectValid->errors()->first(), 409);
      }
    }

}

?>
