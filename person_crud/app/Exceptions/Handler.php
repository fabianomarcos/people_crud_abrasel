<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {
            $status = 500;

            if ($exception instanceof ResourceAlreadyExistsException) {
                return response()->json([
                    'error' => $exception->getMessage()
                ], 400);
            }

            if ($exception instanceof HttpException) {
                $status = $exception->getStatusCode();
            }

            if ($exception instanceof \RuntimeException) {
                return response()->json([
                    'error' => $exception->getMessage()
                ], 400);
            }

            return response()->json([
                'error' => true,
                'message' => $exception->getMessage()
            ], $status);
        }

        return parent::render($request, $exception);
    }
}
