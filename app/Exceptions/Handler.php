<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            return response()->json(['error' => $exception->errors()], $exception->status);
        }
        return response()->json(['error' => $exception->getMessage()], 400);
    }

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            // Do nothing for now
        });
    }
}
