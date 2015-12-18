<?php

namespace App\Projects\Exceptions;

use App\Core\Exceptions\Exception;

class UserNotInProject extends Exception
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct(403);
    }

}
