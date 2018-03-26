<?php

namespace App\Repositories;

use App\Type;

class TypeLocationRepository extends Repository {

    private $type;

    public function __construct(Type $type)
    {
        $this->type = $type;
        parent::__construct();
    }

    public function getAll()
    {
        return $this->type::all();
    }

    public function createIfdoesNotExist($typeLocationName)
    {
        $type = $this->type::firstOrCreate(['name' => $typeLocationName]);

        return $type->id;
    }

}

?>
