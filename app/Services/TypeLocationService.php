<?php

namespace App\Services;

use App\Repositories\TypeLocationRepository;

class TypeLocationService extends Service
{
    private $typeLocationRepository;

    public function __construct(TypeLocationRepository $typeLocationRepository)
    {
        parent::__construct();
        $this->typeLocationRepository = $typeLocationRepository;
    }

    /**
     * @SWG\Definition(
     * 		definition="GetAllTypes",
     *    @SWG\Property(property="types", type="array", @SWG\Items(
     *          @SWG\Property(property="id", type="integer"),
     *          @SWG\Property(property="name", type="string"),
     *          @SWG\Property(property="created_at", type="string"),
     *          @SWG\Property(property="updated_at", type="string"),
     *      )
     *    ),
     * )
     */
    public function getAll()
    {
      try {

          return $this->typeLocationRepository->getAll();
      } catch (Exception $e) {
          report($e);
          return $e->getMessage();
      }
    }

}

?>
