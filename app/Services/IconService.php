<?php

namespace App\Services;

use App\Clients;
use App\Repositories\IconsRepository as iconRepository;

class IconService extends Service
{
    private $iconRepository;

    public function __construct(iconRepository $iconsRepository)
    {
        parent::__construct();
        $this->iconRepository = $iconsRepository;
    }

    /**
     * @SWG\Definition(
     * 		definition="GetAllIcons",
     *    @SWG\Property(property="icons", type="array", @SWG\Items(
     *          @SWG\Property(property="id", type="integer"),
     *          @SWG\Property(property="name", type="string"),
     *          @SWG\Property(property="ref", type="string"),
     *          @SWG\Property(property="created_at", type="string"),
     *          @SWG\Property(property="updated_at", type="string"),
     *      )
     *    ),
     * )
     */
    public function getIcons()
    {
      try {

        return $this->iconRepository->getAll();
        
      } catch (Exception $e) {

        report($e);
        return $e->getMessage();

      }
    }

}

?>
