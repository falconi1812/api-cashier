<?php

namespace App\Repositories;

use App\Payments;
use App\Repositories\RepositoryInterface;
use App\Exceptions\CommonExceptions;

/**
 * Class PaymentRepository
 * @package App\Repositories
 */
class PaymentRepository extends Repository implements RepositoryInterface {

    /**
     * @var Payments
     */
    private $paymentsModel;

    /**
     * PaymentRepository constructor.
     * @param Payments $Payments
     */
    public function __construct(Payments $Payments)
    {
        $this->paymentsModel = $Payments;
        parent::__construct();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return $this->paymentsModel::all();
    }

    /**
     * @param array $parameters
     * @return mixed
     */
    public function create(array $parameters)
    {
        $this->validate($parameters);

        return $this->paymentsModel::create($parameters);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->paymentsModel::find($id);
    }

    /**
     * @param int $locationId
     * @return mixed
     */
    public function findBylocation(int $locationId)
    {
        return $this->paymentsModel::where('location_id', $locationId)
                    ->with(['product' => function($query) {
                        $query->withTrashed();
                    }])
                    ->get();
    }

    /**
     * @param $payment
     * @throws \Exception
     */
    public function validate($payment)
    {
      $isObjectValid = $this->validator::make($payment, $this->paymentsModel->rules());

      if ($isObjectValid->fails()) {
        throw new \Exception($isObjectValid->errors()->first(), 409);
      }
    }

    /**
     * @param $payments
     * @param $typeId
     * @return array
     */
    public function groupProductsByType($payments, $typeId)
    {
        $groupedProducts = [];
        foreach ($payments as $key => $payment) {
            if ($typeId == $payment->type_id) {
                array_push($groupedProducts, $payment);
            }
        }

        return $groupedProducts;
    }

    /**
     * @param $payments
     * @param $productId
     * @return array
     */
    public function groupProductsById($payments, $productId)
    {
        $total = 0;

        foreach ($payments as $key => $payment) {
            if ($productId == $payment->product_id) {
                $total += $payment->quantity;
            }
        }

        return ['total' => $total, 'id' => $productId];
    }

    /**
     * @param $payments
     * @param $typeId
     * @return array
     */
    public function groupForInvoice($payments, $typeId)
    {
        $result = [];

        $totals = [];

        $groupedProducts = $this->groupProductsByType($payments, $typeId);

        foreach ($groupedProducts as $payment) {
            if (!in_array($payment->product->id, array_column($totals, 'id'))) {
                array_push($totals, $this->groupProductsById($groupedProducts, $payment->product->id));
            }
        }

        foreach ($totals as $total) {
            foreach ($payments as $payment) {
                if ($payment->product->id == $total['id'] && !in_array($payment->product->id, array_column($result, 'id'))) {
                    array_push($result , ['total' => $payment->product->price * $total['total'],
                                          'id' => $payment->product->id, 'product' => $payment->product,
                                          'total_quantity' => $total['total']
                                        ]);
                }
            }
        }

        return $result;
    }

    /**
     * @param $payments
     * @return int
     */
    public function getTotalForInvoice($payments)
    {
        $total = 0;
        foreach ($payments as $key => $payment) {
            $total += $payment['total'];
        }

        return $total;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id)
    {
        $payment = $this->paymentsModel::find($id);

        if (empty($payment)) {
            $this->CommonExceptions->notFound('payment', $id);
        }

        return $payment->delete();
    }

}

?>
