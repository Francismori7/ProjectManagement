<?php

namespace App\Auth\Exceptions;

use App\Core\Exceptions\Exception;

class EmailWasNotInvitedException extends Exception
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct(422);
    }
}