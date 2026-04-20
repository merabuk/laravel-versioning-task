<?php

declare(strict_types=1);

namespace App\App\Api\V1\Exceptions;

use App\Infrastructure\Exceptions\EntityFindException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\{MethodNotAllowedHttpException, NotFoundHttpException};
use Throwable;

final class Handler extends ExceptionHandler
{
    protected $dontReport = [
        EntityFindException::class,
        NotFoundHttpException::class,
        MethodNotAllowedHttpException::class,
        ThrottleRequestsException::class,
        ValidationException::class,
    ];

    public function render(mixed $request, Throwable $e): Response
    {
        if ($e instanceof EntityFindException) {
            return response()->json([
                'error' => __('errors.entity_not_found.code', [
                    'entity' => $e->getCodeName(),
                ]),
                'message' => __('errors.entity_not_found.message', [
                    'entity' => $e->getEntityName(),
                    'field' => $e->getEntityField(),
                ]),
            ], Response::HTTP_NOT_FOUND);
        }

        if ($e instanceof NotFoundHttpException) {
            return response()->json([
                'error' => __('errors.method_not_found.code'),
                'message' => __('errors.method_not_found.message'),
            ], Response::HTTP_NOT_FOUND);
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'error' => __('errors.method_not_allowed.code'),
                'message' => __('errors.method_not_allowed.message'),
            ], Response::HTTP_METHOD_NOT_ALLOWED);
        }

        if ($e instanceof ValidationException) {
            return response()->json([
                'error' => __('errors.validation_error.code'),
                'message' => __('errors.validation_error.message'),
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($e instanceof ThrottleRequestsException) {
            return response()->json([
                'error' => __('errors.too_many_requests.code'),
                'message' => $e->getMessage(),
            ], Response::HTTP_TOO_MANY_REQUESTS);
        }

        Log::critical("{$e->getMessage()}\n{$e->getTraceAsString()}");

        return response()->json([
            'error' => __('errors.unexpected_error.code'),
            'message' => __('errors.unexpected_error.message'),
        ], Response::HTTP_SERVICE_UNAVAILABLE);
    }
}
