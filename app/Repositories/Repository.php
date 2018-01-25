<?php

namespace App\Repositories;

use Validator;

class Repository {

    public $validator;

    public function __construct()
    {
        $this->validator = new Validator;
    }
}

?>
