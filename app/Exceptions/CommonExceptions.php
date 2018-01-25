<?php

namespace App\Exceptions;

use Exception;

class CommonExceptions {

    private $exception;

    public function __construct()
    {
        $this->exception = new \Exception();
    }

    public function wrongType($type)
    {
        throw new $this->exception("This should not be an {$type}", 409);
    }

}
