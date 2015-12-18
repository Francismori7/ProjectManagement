<?php

namespace App\Auth\Exceptions;

use App\Core\Exceptions\CoreException;

class EmailWasNotInvitedException extends CoreException
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct(422);
    }
}
