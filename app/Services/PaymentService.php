<?php

namespace App\Services;

use App\Repositories\PaymentRepository;

class PaymentService extends Service
{
    private $paymentsRepository;

    public function __construct(PaymentRepository $paymentsRepository)
    {
        parent::__construct();
        $this->paymentsRepository = $paymentsRepository;
    }

    /**
     * @SWG\Definition(
     * 		definition="GetAllPayments",
     *    @SWG\Property(property="payments", type="array", @SWG\Items(
     *          @SWG\Property(property="id", type="integer"),
     *          @SWG\Property(property="product", type="string"),
     *          @SWG\Property(property="location", type="string"),
     *          @SWG\Property(property="created_at", type="string"),
     *          @SWG\Property(property="updated_at", type="string"),
     *      )
     *    ),
     * )
     */
    public function getAll()
    {
      try {
        return $this->paymentsRepository->getAll();
      } catch (Exception $e) {
        report($e);
        return $e->getMessage();
      }
    }

    public function processSave(int $locationId, $products)
    {
      try {
        foreach ($products as $key => $product) {
            $this->paymentsRepository->save($locationId, $product->id, $product->quantity);
        }

        return $this->paymentsRepository->findBylocation($locationId);
      } catch (Exception $e) {
        report($e);
        return $e->getMessage();
      }
    }

}

?>
