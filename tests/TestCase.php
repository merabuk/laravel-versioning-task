<?php

declare(strict_types=1);

namespace Tests;

use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use ErrorMessageHelper;
    use RefreshDatabase;

    protected function mockControllerException(string $class): void
    {
        $this->app->when($class)
            ->give($this->mock($class)
                ->shouldReceive('__invoke')
                ->andThrow(Exception::class));
    }
}
