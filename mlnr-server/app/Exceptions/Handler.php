<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        Illuminate\Auth\Access\AuthorizationException::class,
        Symfony\Component\HttpKernel\Exception\HttpException::class,
        Illuminate\Database\Eloquent\ModelNotFoundException::class,
        ValidationException::class,
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
        $success = false;
        $response = null;
        if (method_exists($e,'getStatusCode')) {
            $status = $e->getStatusCode();
        } else {
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;
        }
        if ($e instanceof HttpResponseException) {
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response = $e->getResponse();
        } elseif ($e instanceof Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
            $status = Response::HTTP_METHOD_NOT_ALLOWED;
        } elseif ($e instanceof Symfony\Component\HttpKernel\Exception\NotFoundHttpException
            || $e instanceof Illuminate\Database\Eloquent\ModelNotFoundException) {
            $status = Response::HTTP_NOT_FOUND;
        } elseif ($e instanceof Symfony\Component\HttpKernel\Exception\AuthorizationException
            || $e instanceof Illuminate\Auth\Access\AuthorizationException) {
            $status = Response::HTTP_FORBIDDEN;
        } elseif ($e instanceof \Dotenv\Exception\ValidationException && $e->getResponse()) {
            $status = Response::HTTP_BAD_REQUEST;
            $e = new \Dotenv\Exception\ValidationException('HTTP_BAD_REQUEST', $status, $e);
            $response = $e->getResponse();
        }
        return response()->json([
            'success' => $success,
            'status' => $status,
            'message' => $e->getMessage(),
        ], $status);
    }
}
