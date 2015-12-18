<?php

namespace App\Core\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class Exception extends HttpException
{
    /**
     * Constructor.
     *
     * @param int $statusCode The HTTP status code
     * @param string $message The internal exception message
     * @param \Exception $previous The previous exception
     * @param null $code The error code
     */
    public function __construct($statusCode = 500, $message = null, \Exception $previous = null, $code = null)
    {
        parent::__construct(
            $statusCode,
            $message ?? Handler::$errorMessages[get_class($this)] ?? null,
            $previous,
            [],
            $code ?? Handler::$errorCodes[get_class($this)] ?? 0
        );
    }
}