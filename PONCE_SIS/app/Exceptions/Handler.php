<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Handler extends ExceptionHandler
{
    protected $levels = [
        //
    ];

    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // Custom error handling for specific exceptions
        $this->renderable(function (Throwable $e, $request) {
            if ($request->expectsJson()) {
                if ($e instanceof ValidationException) {
                    return response()->json([
                        'message' => 'The given data was invalid.',
                        'errors' => $e->errors(),
                    ], 422);
                }

                if ($e instanceof QueryException) {
                    return response()->json([
                        'message' => 'Database error occurred.',
                        'error' => $this->isDebugMode() ? $e->getMessage() : 'Internal server error',
                    ], 500);
                }

                if ($e instanceof AuthenticationException) {
                    return response()->json([
                        'message' => 'Unauthenticated.',
                    ], 401);
                }

                if ($e instanceof AuthorizationException) {
                    return response()->json([
                        'message' => 'This action is unauthorized.',
                    ], 403);
                }

                if ($e instanceof ModelNotFoundException) {
                    return response()->json([
                        'message' => 'Record not found.',
                    ], 404);
                }
            }

            if ($e instanceof TokenMismatchException) {
                return redirect()->back()
                    ->withInput($request->except('_token'))
                    ->with('error', 'Your session has expired. Please try again.');
            }

            if ($e instanceof ValidationException) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors($e->validator)
                    ->with('error', 'Please check the form for errors.');
            }

            if ($e instanceof NotFoundHttpException) {
                return response()->view('errors.404', [], 404);
            }

            if ($this->isHttpException($e)) {
                return $this->renderHttpException($e);
            }

            if (!$this->isDebugMode()) {
                return response()->view('errors.500', [], 500);
            }
        });
    }

    protected function isDebugMode(): bool
    {
        return config('app.debug');
    }
} 