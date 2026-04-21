<?php

declare(strict_types=1);

namespace App\Infrastructure\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Symfony\Component\ErrorHandler\Error\FatalError;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * @var array<int, string>
     */
    protected $dontFlash = ['current_password', 'password', 'password_confirmation'];

    public function register(): void
    {
        $this->reportable(function (Throwable $e): void {
        });
    }

    public function render(mixed $request, Throwable $e): Response
    {
        if ($e instanceof FatalError) {
            Log::critical('Fatal error occurred', [
                'url' => $request->fullUrl() ?: 'N/A',
                'userId' => auth()->check() ? auth()->id() : 'guest',
                'exception' => $e,
            ]);

            return $this->renderUnexpectedException();
        }

        if ($e instanceof NotFoundHttpException) {
            return $this->renderNotFoundException();
        }

        Log::critical("{$e->getMessage()}\n{$e->getTraceAsString()}");

        return $this->renderUnexpectedException();
    }

    public function report(Throwable $e): void
    {
        if ($e instanceof FatalError) {
            if (app()->runningInConsole()) {
                global $argv;
                $commandSignature = implode(' ', array_slice($argv, 1));

                Log::critical('Fatal error occurred', [
                    'command' => $commandSignature,
                    'exception' => $e,
                ]);
            } else {
                $request = request();

                Log::critical('Fatal error occurred', [
                    'url' => optional($request)?->fullUrl() ?: 'N/A',
                    'userId' => auth()->check() ? auth()->id() : 'guest',
                    'exception' => $e,
                ]);
            }
        }

        parent::report($e);
    }

    protected function renderUnexpectedException(): Response
    {
        return response()->json([
            'error' => __('errors.unexpected_error.code'),
            'message' => __('errors.unexpected_error.message'),
        ], Response::HTTP_SERVICE_UNAVAILABLE);
    }

    protected function renderNotFoundException(): Response
    {
        return response()->json([
            'error' => __('errors.not_found.code'),
            'message' => __('errors.not_found.message'),
        ], Response::HTTP_NOT_FOUND);
    }
}
