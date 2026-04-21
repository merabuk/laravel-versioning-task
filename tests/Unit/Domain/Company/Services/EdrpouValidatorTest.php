<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Company\Services;

use App\Domain\Company\Services\EdrpouValidator;
use PHPUnit\Framework\TestCase;

class EdrpouValidatorTest extends TestCase
{
    private EdrpouValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new EdrpouValidator();
    }

    /**
     * @dataProvider edrpouCodesProvider
     */
    public function testValidate(string $code, bool $expected): void
    {
        $this->assertEquals($expected, $this->validator->validate($code));
    }

    public static function edrpouCodesProvider(): iterable
    {
        yield 'valid edrpou codes' => ['00032112', true];
        yield 'invalid edrpou codes' => ['00032113', false];
        yield 'too short edrpou codes' => ['123', false];
        yield 'with letters' => ['ABC12345', false];
    }
}
