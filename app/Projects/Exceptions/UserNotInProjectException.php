<?php

namespace App\Projects\Exceptions;

use App\Core\Exceptions\CoreException;

class UserNotInProjectException extends CoreException
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct(403);
    }
}
