<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use App\Lib\Response\ApiResponse;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        // ModelNotFoundException::class
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        $apiResponse = new ApiResponse();

        if ($e instanceof NotFoundHttpException) {
            return $apiResponse->notFound();
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            return $apiResponse->methodNotAllowed();
        }

        if ($e instanceof ValidationException) {
            return $apiResponse->validationFail($e);
        }

        if ($e instanceof ModelNotFoundException) {
            return $apiResponse->noResults();
        }

        if ($e instanceof ConflictHttpException) {
            return $apiResponse->duplicated();
        }

        return parent::render($request, $e);
    }
}
