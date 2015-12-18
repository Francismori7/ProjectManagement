<?php

namespace App\Core\Exceptions;

use App\Projects\Exceptions\UserNotInProject;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * An array of all possible error codes.
     *
     * @var array
     */
    public static $errorCodes = [
        UserNotInProject::class => 10001,
    ];

    /**
     * And array error messages.
     *
     * @var array
     */
    public static $errorMessages = [
        UserNotInProject::class => 'You are not in this project.',
    ];

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Exception $e
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception $e
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }

        if (($request->isXmlHttpRequest() || $request->acceptsJson()) && $this->isHttpException($e)) {
            return response()->json([
                'error' => $e->getStatusCode(),
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        }

        return parent::render($request, $e);
    }
}
