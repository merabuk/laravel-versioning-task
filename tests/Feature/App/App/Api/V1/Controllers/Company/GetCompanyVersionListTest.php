<?php

declare(strict_types=1);

namespace Feature\App\App\Api\V1\Controllers\Company;

use App\App\Api\V1\Controllers\Company\GetCompanyVersionListController;
use App\Core\Versioning\Models\Version;
use App\Domain\Company\Models\Company;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class GetCompanyVersionListTest extends  TestCase
{
    private string $route = 'public-api.v1.company.item.versions';

    public function testMethodExist(): void
    {
        $response = $this->optionsJson(route($this->route, [
            'edrpou' => '12345678',
        ]));

        self::assertStringContainsString('GET', $response->headers->get('Allow'));
    }

    public function testUnexpectedErrorsProcessed(): void
    {
        $this->mockControllerException(GetCompanyVersionListController::class);

        $this->getJson(route($this->route, [
            'edrpou' => '12345678',
        ]))
            ->assertServiceUnavailable()
            ->assertExactJson($this->getExactServiceUnavailableError());
    }

    public function testEdrpouValidationError(): void
    {
        $this->getJson(route($this->route, [
            'edrpou' => '00032113',
        ]))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['edrpou']);
    }

    public function testSuccessResponseAndCorrectData(): void
    {
        $company = Company::factory()
            ->withName('ТОВ Українська енергетична біржа')
            ->withEdrpou('37027819')
            ->withAddress('01001, Україна, м. Київ, вул. Хрещатик, 44')
            ->create();

        $count = 10;
        for ($i = 1; $i <= $count; $i++) {
            $version = Version::factory()
                ->forVersionable($company)
                ->withVersion($i)
                ->create();

            $company->relationLoaded('versions')
                ? $company->versions->push($version)
                : $company->setRelation('versions', Collection::make([$version]));
        }

        $this->getJson(route($this->route, [
            'edrpou' => $company->edrpou,
        ]))
            ->assertOk()
            ->assertJsonStructure([
                'company_id',
                'edrpou',
                'name',
                'address',
                'versions' => [
                    '*' => [
                        'version',
                        'payload' => [
                            'name',
                            'edrpou',
                            'address',
                        ],
                    ],
                ],
            ])
            ->assertJsonCount($count, 'versions');
    }

    public function testCompanyNotFound(): void
    {
        $this->getJson(route($this->route, [
            'edrpou' => '00032112',
        ]))
            ->assertNotFound()
            ->assertExactJson($this->getExactEntityNotFound(
                entity: 'company',
                field: 'edrpou',
            ));
    }
}
