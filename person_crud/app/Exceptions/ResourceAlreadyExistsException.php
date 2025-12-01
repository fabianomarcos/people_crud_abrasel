<?php

namespace App\Exceptions;

use Exception;

class ResourceAlreadyExistsException extends Exception
{
    public function __construct($message = "Recurso já cadastrado.", $code = 400)
    {
        parent::__construct($message, $code);
    }
}
