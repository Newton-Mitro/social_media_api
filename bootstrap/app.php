<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Foundation\Application;
use Illuminate\Database\QueryException;
use Illuminate\Support\ItemNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\Eloquent\JsonEncodingException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: [
            __DIR__ . '/../routes/api.php',
        ],
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withEvents()
    ->withMiddleware(function (Middleware $middleware): void {
        // Global Middleware Goes Here...
        // $middleware->append(JwtAccessTokenMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Exception $exception, Request $request) {

            if ($exception instanceof UnauthorizedException) {
                return response()->json([
                    'data' => null,
                    'message' => $exception->getMessage(),
                    'error' => $exception->getMessage(),
                    'errors' => null,
                ], Response::HTTP_UNAUTHORIZED);
            }

            if ($exception instanceof ModelNotFoundException) {
                return response()->json([
                    'data' => null,
                    'message' => 'Model not found',
                    'error' => 'Model not found',
                    'errors' => null,
                ], Response::HTTP_NOT_FOUND);
            }

            if ($exception instanceof NotFoundHttpException) {
                return response()->json([
                    'data' => null,
                    'message' => "No query results",
                    'error' => "No query results",
                    'errors' => null,
                ], Response::HTTP_NOT_FOUND);
            }

            if ($exception instanceof AccessDeniedHttpException) {
                return response()->json([
                    'data' => null,
                    'message' => 'You do not have enough permission',
                    'error' => 'You do not have enough permission',
                    'errors' => null,
                ],  Response::HTTP_UNAUTHORIZED);
            }

            if ($exception instanceof JsonEncodingException) {
                return response()->json([
                    'data' => null,
                    'message' => 'JSON parsing error',
                    'error' => 'JSON parsing error',
                    'errors' => null,
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            if ($exception instanceof ErrorException) {
                return response()->json([
                    'data' => null,
                    'message' => $exception->getMessage(),
                    'error' => $exception->getMessage(),
                    'errors' => null,
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            if ($exception instanceof ItemNotFoundException) {
                return response()->json([
                    'data' => null,
                    'message' => 'Content not found',
                    'error' => 'Content not found',
                    'errors' => null,
                ], Response::HTTP_NOT_FOUND);
            }

            if ($exception instanceof QueryException) {
                return response()->json([
                    'data' => null,
                    'message' => 'Query exception',
                    'error' => 'Query exception',
                    'errors' => null,
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            if ($exception instanceof ValidationException) {
                return response()->json([
                    'data' => null,
                    'message' => 'Validation exception',
                    'error' => 'Validation exception',
                    'errors' => $exception->errors(),
                ], Response::HTTP_BAD_REQUEST);
            }

            return response()->json([
                'data' => null,
                'message' => $exception->getMessage(),
                'error' => $exception->getMessage(),
                'errors' => null,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        });
    })->create();
