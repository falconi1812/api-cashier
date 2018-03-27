<?php

namespace App\Repositories;

use App\Icons;

/**
 * Class IconsRepository
 * @package App\Repositories
 */
class IconsRepository extends Repository {

    /**
     * @var Icons
     */
    private $icon;

    /**
     * IconsRepository constructor.
     * @param Icons $icon
     */
    public function __construct(Icons $icon)
    {
        $this->icon = $icon;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return Icons::all();
    }

}

?>
