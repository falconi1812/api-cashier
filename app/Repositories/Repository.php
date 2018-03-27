<?php

namespace App\Repositories;

use Validator;

/**
 * Class Repository
 * @package App\Repositories
 */
class Repository {

    /**
     * @var Validator
     */
    public $validator;

    /**
     * Repository constructor.
     */
    public function __construct()
    {
        $this->validator = new Validator;
    }
}

?>
