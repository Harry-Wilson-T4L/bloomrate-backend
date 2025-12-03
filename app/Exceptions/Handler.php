<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($request->is("api/*")) {
            if ($exception instanceof ModelNotFoundException) {
                return response()->json([
                    'status' => 0,
                    'message' => $exception->getMessage(),
                ], 404);
            }elseif ($exception instanceof ValidationException){
                return response()->json([
                    'status' => 0,
                    'message' => $exception->validator->errors()->first(),
                ], 400);
            }
            elseif ($exception instanceof MethodNotAllowedHttpException) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Wrong http method given',
                ], 400);
            }elseif ($exception instanceof NotFoundHttpException) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Given URL not found on server',
                ], 404);
            }elseif($exception instanceof CustomValidationException){
                return response()->json([
                    'status' =>  0,
                    'message' => $exception->getMessage(),
                ], 400);
            }elseif($exception instanceof  AuthenticationException){
                return response()->json([
                    'status' =>  0,
                    'message' => $exception->getMessage(),
                ],401);
            }
            else{
                return response()->json([
                    'status' => 0,
                    'message' =>  config('app.debug') ? $exception->getMessage() .' on line no '.$exception->getLine() :"Something went wrong",
                ], 500);
            }
        }
        return parent::render($request, $exception);
    }
}
