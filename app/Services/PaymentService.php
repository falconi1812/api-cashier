<?php

namespace App\Services;

use App\Repositories\PaymentRepository;
use App\Exceptions\PaymentsExceptions;
use App\Helpers\CommonHelper;

class PaymentService extends Service
{
    use CommonHelper;

    private $paymentsRepository;

    private $paymentsExceptions;

    public function __construct(PaymentRepository $paymentsRepository, PaymentsExceptions $paymentsExceptions)
    {
        parent::__construct();
        $this->paymentsRepository = $paymentsRepository;
        $this->paymentsExceptions = $paymentsExceptions;
    }

    /**
     * @SWG\Definition(
     * 		definition="GetAllPayments",
     *    @SWG\Property(property="payments", type="array", @SWG\Items(
     *          @SWG\Property(property="id", type="integer"),
     *          @SWG\Property(property="product_id", type="integer"),
     *          @SWG\Property(property="location_id", type="integer"),
     *          @SWG\Property(property="quantity", type="integer"),
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

    public function processSave(int $locationId, int $typeId, $body)
    {
      try {

        $products = $this->getBody($body)->all();

        if (!$this->is_multi_array($products)) {
            $this->paymentsExceptions->wrongType(gettype($products));
        }

        foreach ($products as $product) {
            $product['location_id'] = $locationId;
            $product['type_id'] = $typeId;
            $this->paymentsRepository->create($product);
        }

        return $this->paymentsRepository->findBylocation($locationId);

      } catch (Exception $e) {
        report($e);
        return $e->getMessage();
      }
    }

}

?>
