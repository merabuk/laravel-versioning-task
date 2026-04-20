<?php

declare(strict_types=1);

namespace Feature\App\App\Api\V1\Controllers\Company;

use App\App\Api\V1\Controllers\Company\CreateCompanyController;
use App\Core\Versioning\Enums\StatusEnum;
use App\Core\Versioning\Models\Version;
use App\Domain\Company\Models\Company;
use Tests\TestCase;

class CreateCompanyTest extends TestCase
{
    private string $route = 'public-api.v1.company.create';

    public function testMethodExist(): void
    {
        $response = $this->optionsJson(route($this->route));

        self::assertStringContainsString('POST', $response->headers->get('Allow'));
    }

    public function testUnexpectedErrorsProcessed(): void
    {
        $this->mockControllerException(CreateCompanyController::class);

        $this->postJson(route($this->route))
            ->assertServiceUnavailable()
            ->assertExactJson($this->getExactServiceUnavailableError());
    }

    public function testRequiredParameters(): void
    {
        $required = ['name', 'edrpou', 'address'];

        $this->postJson(route($this->route))
            ->assertUnprocessable()
            ->assertJsonValidationErrors($required)
            ->assertJsonStructure($this->getBaseValidationErrorStructure($required));
    }

    /**
     * @dataProvider nameProvider
     */
    public function testNameValidationError(string $value, bool $expectError): void
    {
        $response = $this->postJson(route($this->route), [
            'name' => $value,
        ])
            ->assertUnprocessable();

        if ($expectError) {
            $response->assertJsonValidationErrors(['name']);
        } else {
            $response->assertJsonMissingValidationErrors(['name']);
        }
    }

    public static function nameProvider(): iterable
    {
        yield 'too short' => ['', true];
        yield 'too long' => [str_repeat('a', 257), true];
        yield 'valid' => ['valid name', false];
    }

    /**
     * @dataProvider edrpouCodesProvider
     */
    public function testEdrpouValidationError(string $value, bool $expectError): void
    {
        $response = $this->postJson(route($this->route), [
            'edrpou' => $value,
        ])
            ->assertUnprocessable();

        if ($expectError) {
            $response->assertJsonValidationErrors(['edrpou']);
        } else {
            $response->assertJsonMissingValidationErrors(['edrpou']);
        }
    }

    public static function edrpouCodesProvider(): iterable
    {
        yield 'valid edrpou codes' => ['37027819', false];
        yield 'invalid edrpou codes' => ['00032113', true];
        yield 'too short edrpou codes' => ['123', true];
        yield 'with letters' => ['ABC12345', true];
    }

    /**
     * @dataProvider addressProvider
     */
    public function testAddressValidationError(string $value, bool $expectError): void
    {
        $response = $this->postJson(route($this->route), [
            'address' => $value,
        ])
            ->assertUnprocessable();

        if ($expectError) {
            $response->assertJsonValidationErrors(['address']);
        } else {
            $response->assertJsonMissingValidationErrors(['address']);
        }
    }

    public static function addressProvider(): iterable
    {
        yield 'too short' => ['', true];
        yield 'too long' => [str_repeat('a', 65_536), true];
        yield 'valid' => ['valid address', false];
    }

    /**
     * @dataProvider companyProvider
     */
    public function testSuccessResponseAndCorrectData(
        array $payload,
        array $expectedResponse,
        array $existingCompany = [],
    ): void {
        if ($existingCompany) {
            $company = Company::factory()
                ->withName($existingCompany['name'])
                ->withEdrpou($existingCompany['edrpou'])
                ->withAddress($existingCompany['address'])
                ->create();
            Version::factory()
                ->forVersionable($company)
                ->withVersion($existingCompany['version'])
                ->create();
        }

        $this->postJson(route($this->route), $payload)
            ->assertOk()
            ->assertJsonStructure(['status', 'company_id', 'version'])
            ->assertJsonFragment(['status' => $expectedResponse['status']])
            ->assertJsonFragment(['version' => $expectedResponse['version']]);
    }

    public static function companyProvider(): iterable
    {
        $payload = [
            'name' => 'ТОВ Українська енергетична біржа',
            'edrpou' => '37027819',
            'address' => '01001, Україна, м. Київ, вул. Хрещатик, 44',
        ];
        $response = [
            'status' => StatusEnum::Created->value,
            'company_id' => 'unknown',
            'version' => 1,
        ];

        yield 'created' => [
            'payload' => $payload,
            'expectedResponse' => $response,
        ];
        yield 'updated' => [
            'payload' => [
                ...$payload,
                'name' => 'Updated name',
            ],
            'expectedResponse' => [
                'status' => StatusEnum::Updated->value,
                'version' => 2,
            ],
            'existingCompany' => [
                ...$payload,
                'version' => 1,
            ],
        ];
        yield 'duplicate' => [
            'payload' => [
                ...$payload,
                'name' => 'Updated name',
            ],
            'expectedResponse' => [
                'status' => StatusEnum::Duplicate->value,
                'version' => 2,
            ],
            'existingCompany' => [
                ...$payload,
                'name' => 'Updated name',
                'version' => 2,
            ],
        ];
    }
}
