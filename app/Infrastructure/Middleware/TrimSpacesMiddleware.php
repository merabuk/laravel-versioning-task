<?php

declare(strict_types=1);

namespace App\Infrastructure\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class TrimSpacesMiddleware
{
    public function handle(Request $request, Closure $next): SymfonyResponse
    {
        if (! in_array($request->method(), ['POST', 'PATCH', 'PUT'], true)) {
            return $next($request);
        }

        $input = $request->all();
        $request->merge($this->process($input));

        return $next($request);
    }

    /**
     * @param array<string, mixed> $input
     * @return array<string, mixed>
     */
    private function process(array $input): array
    {
        foreach ($input as &$item) {
            if (is_array($item)) {
                $item = $this->process($item);
            }

            if (is_string($item)) {
                $item = preg_replace(['/(?:\r?\n){2,}/', '/( {2,})/'], [PHP_EOL . PHP_EOL, ' '], $item);
            }
        }

        return $input;
    }
}
