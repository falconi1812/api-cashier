<?php

namespace App\Repositories;

use App\Type;

/**
 * Class TypeLocationRepository
 * @package App\Repositories
 */
class TypeLocationRepository extends Repository {

    /**
     * @var Type
     */
    private $type;

    /**
     * TypeLocationRepository constructor.
     * @param Type $type
     */
    public function __construct(Type $type)
    {
        $this->type = $type;
        parent::__construct();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return $this->type::all();
    }

    /**
     * @param $typeLocationName
     * @return mixed
     */
    public function createIfdoesNotExist($typeLocationName)
    {
        $type = $this->type::firstOrCreate(['name' => $typeLocationName]);

        return $type->id;
    }

}

?>
