<?php

declare(strict_types=1);

namespace App\Infrastructure\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class SetAppLocale
{
    public function handle(Request $request, Closure $next): SymfonyResponse
    {
        app()->setLocale($this->setAndGetAppLocale($request->getLanguages()));

        return $next($request);
    }

    /**
     * @param string[] $languages
     */
    private function setAndGetAppLocale(array $languages): string
    {
        $available = config('app.locales');

        $preferences = array_map(static fn ($locale) => str_replace('_', '-', $locale), $languages);

        foreach ($preferences as $preference) {
            if (in_array($preference, $available, true)) {
                return $preference;
            }
        }

        return config('app.locale', 'en');
    }
}
