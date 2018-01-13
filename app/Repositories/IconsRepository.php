<?php

namespace App\Repositories;

use App\Icons;

class IconsRepository extends Repository {

    private $icon;

    public function __construct(Icons $icon)
    {
        $this->icon = $icon;
    }

    public function getAll()
    {
        return Icons::all();
    }

}

?>
