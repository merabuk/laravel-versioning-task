<?php

declare(strict_types=1);

namespace App\Infrastructure\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddAcceptJsonHeader
{
    public function handle(Request $request, Closure $next): mixed
    {
        $request->headers->set('Accept', 'application/json');

        return $next($request);
    }
}
